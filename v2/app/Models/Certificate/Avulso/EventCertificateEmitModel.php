<?php

namespace App\Models\Certificate\Avulso;

use CodeIgniter\Model;

class EventCertificateEmitModel extends Model
{
    protected $DBGroup = 'isko';
    protected $table            = 'event_certificate_emit';
    protected $primaryKey       = 'id_ece';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'ece_person',
        'ece_certificate',
        'ece_status'
    ];

    // A tabela não possui created_at nem updated_at
    protected $useTimestamps = false;

    // Validação opcional
    protected $validationRules = [
        'ece_person'      => 'required|integer',
        'ece_certificate' => 'required|integer',
        'ece_status'      => 'required|integer'
    ];

    function add_certificate($dta)
    {
        $dt = $this->where('ece_person', $dta['ece_person'])
                   ->where('ece_certificate', $dta['ece_certificate'])
                   ->first();
        if ($dt != null) {
            return $dt['id_ece'];
        }
        $dt = [];
        $dt['ece_person'] = $dta['ece_person'];
        $dt['ece_certificate'] = $dta['ece_certificate'];
        $dt['ece_status'] = 0; // Pendente
        $this->insert($dt);
        return $this->getInsertID();
    }
}
