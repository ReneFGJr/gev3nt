<?php

namespace App\Models\Certificate\Avulso;

use CodeIgniter\Model;

class EventAssinatureModel extends Model
{
    protected $DBGroup = 'isko';
    protected $table      = 'event_assinature';
    protected $primaryKey = 'id_ass';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'ass_name',
        'ass_location',
        'ass_reason',
        'ass_certPem',
        'ass_keyPem'
    ];

    // Caso queira usar timestamps no futuro:
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation (opcional)
    protected $validationRules = [
        'ass_name'     => 'required|min_length[3]|max_length[100]',
        'ass_location' => 'required|max_length[100]',
        'ass_reason'   => 'required|max_length[100]',
        'ass_certPem'  => 'required|max_length[100]',
        'ass_keyPem'   => 'required|max_length[100]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
