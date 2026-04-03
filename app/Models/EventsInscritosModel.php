<?php
namespace App\Models;

use CodeIgniter\Model;

class EventsInscritosModel extends Model
{
    protected $table = 'events_inscritos';
    protected $primaryKey = 'id_i';
    protected $allowedFields = [
        'i_evento',
        'i_date_in',
        'i_user',
        'i_status',
        'i_date_out',
        'i_certificado',
        'i_titulo_trabalho',
        'i_autores',
        'i_carga_horaria',
        'i_cracha'
    ];
    protected $returnType = 'array';


    function getCertificadosByUser($userId)
    {
        $rsp = $this
                ->join('events', 'events_inscritos.i_evento = events.id_e')
                ->where('i_user', $userId)
                ->orderBy('events.e_data', 'DESC')
                ->orderBy('id_i', 'DESC')
                ->findAll();
        return $rsp;
    }
}
