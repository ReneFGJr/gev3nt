<?php
namespace App\Models;

use CodeIgniter\Model;

class EventInscritosModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'event_inscritos';
    protected $primaryKey = 'id_ein';
    protected $allowedFields = [
        'ein_event',
        'ein_tipo',
        'ein_user',
        'ein_data',
        'ein_pago',
        'ein_presente',
        'ein_pago_em',
        'ein_recibo'
    ];
    protected $returnType = 'array';
}
