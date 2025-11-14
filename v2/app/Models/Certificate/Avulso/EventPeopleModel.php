<?php

namespace App\Models\Certificate\Avulso;

use CodeIgniter\Model;

class EventPeopleModel extends Model
{
    protected $DBGroup = 'isko';
    protected $table            = 'event_people';
    protected $primaryKey       = 'id_p';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'p_name',
        'p_email',
        'p_cpf',
        'p_email_2',
        'p_institution'
    ];

    // A tabela contém created_at, mas sem updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // não existe campo updated

    // Regras de validação opcionais
    protected $validationRules = [
        'p_name'        => 'permit_empty|string|max_length[100]',
        'p_email'       => 'permit_empty|valid_email|max_length[100]',
        'p_cpf'         => 'permit_empty|max_length[20]',
        'p_email_2'     => 'permit_empty|valid_email|max_length[100]',
        'p_institution' => 'permit_empty|integer'
    ];

    function add_person($dta)
    {
        $dt = $this->where('p_email', $dta['email'])->first();
        if ($dt != null) {
            return $dt['id_p'];
        }
        $dt = [];
        $dt['p_name'] = $dta['name'];
        $dt['p_email'] = $dta['email'];
        if (isset($dta['cpf'])) {
            $dt['p_cpf'] = $dta['cpf'];
        }
        if (isset($dta['email2'])) {
            $dt['p_email_2'] = $dta['email2'];
        }
        if (isset($dta['institution'])) {
            $dt['p_institution'] = $dta['institution'];
        }
        $this->insert($dt);
        return $this->getInsertID();
    }
}
