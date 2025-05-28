<?php

namespace App\Models;

use CodeIgniter\Model;

  class UsersModel extends Model {

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
      'name', 'email', 'cpf', 'rg', 'phone', 'address', 'number', 'district', 'city', 'fu'
    ];

    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    // (Opcional) Tipo de retorno: objeto ou array
    // protected $returnType  = 'array';

  }