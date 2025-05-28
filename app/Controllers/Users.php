<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsersModel;

class Users extends ResourceController {

  protected $modelName = UsersModel::class;
  protected $format = 'json';

  // Listar todos usuários - GET /api/users
  public function index() {
    $users = $this->model->orderBy('id', 'ASC')->findAll();
    return $this->respond($users);
  }

  // Mostrar um usuário específico - GET /api/users/{id}
  public function show($id = null) {

    $user = $this->model->find($id);

    if (!$user) {
      return $this->failNotFound('Usuário não encontrado');
    }

    return $this->respond($user);

  }

  // Criar usuário - POST /api/users
  public function create() {

    $data = $this->request->getJSON(true);

    if (!$data) {
      return $this->failValidationErrors('Dados inválidos');
    }

    if (!$this->model->insert($data)) {
      return $this->failValidationErrors($this->model->errors());
    }

    $data['id'] = $this->model->getInsertID();

    $response = [
      'message' => 'Usuário criado com sucesso',
      'data'    => $data
    ];

    return $this->respondCreated($response);

  }

  // Atualizar usuário - PUT /api/users/{id}
  public function update($id = null) {

    $user = $this->model->find($id);

    if (!$user) {
      return $this->failNotFound('Usuário não encontrado');
    }

    $data = $this->request->getJSON(true);

    if (!$data) {
      return $this->failValidationErrors('Dados inválidos');
    }

    if (!$this->model->update($id, $data)) {
      return $this->failValidationErrors($this->model->errors());
    }

    return $this->respond(['message' => 'Usuário atualizado com sucesso']);

  }

  // Excluir usuário - DELETE /api/users/{id}
  public function delete($id = null) {

    if ($id === null) {
      return $this->failValidationErrors('ID do usuário é obrigatório para exclusão.');
    }

    $user = $this->model->find($id);

    if (!$user) {
      return $this->failNotFound('Usuário não encontrado');
    }

    $this->model->delete($id);
    return $this->respondDeleted(['message' => 'Usuário excluído com sucesso']);

  }

}
