<?php
namespace App\Models;

use CodeIgniter\Model;

class EventInscritosModel extends Model
{
    protected $table = 'event_inscritos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'n_email',
        'n_cracha',
        'n_nome',
        'n_email',
        'n_password',
        'n_cpf',
        'n_orcid',
        'n_afiliacao',
        'created_at',
        'updated_at',
        'apikey'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType    = 'array';
}
