<?php
namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'events_names';
    protected $primaryKey = 'id_n';
    protected $allowedFields = [
        'n_email',
        'n_cracha',
        'n_nome',
        'n_password',
        'n_cpf',
        'n_orcid',
        'n_afiliacao',
        'created_at',
        'updated_at',
        'apikey', 'reset_token', 'reset_token_expires'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType    = 'array';
}
