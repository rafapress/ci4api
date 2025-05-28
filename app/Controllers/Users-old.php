<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;
use App\Libraries\ApiLogger;

  class Users extends ResourceController {

    private $userModel;
    private $token;

    public function __construct() {

      $this->userModel = new \App\Models\UsersModel();
      $this->token = getenv('TOKEN');

    }

    private function _validaToken() {
      return $this->request->getHeaderLine('token') == $this->token;
    }

    // Endpoint para retornar todos os usuários da tabela (GET)
    public function list() {

      $response = [];

      if ($this->_validaToken()) {

        try {

          $data = $this->userModel->findAll();
          return $this->response->setJSON($data);

        } catch(Exception $e) {

          $response = [
            'response' => 'error',
            'msg'      => 'Ocorreu um erro ao listar os usuários',
            'errors'   => [
              'exception'   => $e->getMessage()
            ]
          ];

        }

      } else {

        $response = [
          'response' => 'error',
          'msg'      => 'Token inválido'
        ];
        
      }

      return $this->response->setJSON($response);

    }

    // Endpoint para cadastrar usuários no Banco de Dados (POST)
    public function create() {

      $response = [];

      if ($this->_validaToken()) {

        // $newUser['name']    = $this->request->getPost('name');
        // $newUser['email']   = $this->request->getPost('email');

        try {

          $newUser  = $this->request->getPost();
          $userId   = $this->userModel->insert($newUser);

          if ($userId) {

            // ApiLogger::info('Usuário criado com ID: ' . $userId);

            $response = [
              'response' => 'success',
              'msg'      => 'Usuário cadastrado com sucesso'
            ];

          } else {

            //ApiLogger::error('Falha ao criar usuário');

            $response = [
              'response' => 'error',
              'msg'      => 'Ocorreu um erro ao cadastrar o usuário',
              'errors'   => $this->userModel->errors()
            ];

          }

        } catch(Exception $e) {

          $response = [
            'response' => 'error',
            'msg'      => 'Ocorreu um erro ao cadastrar o usuário',
            'errors'   => [
              'exception'   => $e->getMessage()
            ]
          ];

        }

      } else {

        $response = [
          'response' => 'error',
          'msg'      => 'Token inválido'
        ];

      }

      return $this->response->setJSON($response);

    }

    public function delete($id = null) {

      $response = [];

      if ($this->_validaToken()) {

        try {

          $data = $this->userModel->find($id);

          if ($data) {

            $delete = $this->userModel->delete($id);

            if ($delete) {

              $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                  'success' => 'Usuário excluído com sucesso'
                ]
              ];

              return $this->respondDeleted($response);

            }

          }else{
            return $this->failNotFound('Nenhum usuário encontrado com o id: ' . $id);
          }

        } catch(Exception $e) {

          $response = [
            'status'   => 500,
            'response' => 'error',
            'msg'      => 'Ocorreu um erro ao excluir o usuário',
            'errors'   => [
              'exception'   => $e->getMessage()
            ]
          ];

        }

      } else {

        $response = [
          'response' => 'error',
          'msg'      => 'Token inválido'
        ];
        
      }

      return $this->response->setJSON($response);

    }

  }