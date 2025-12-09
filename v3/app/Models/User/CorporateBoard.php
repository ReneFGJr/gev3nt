<?php

namespace App\Models\User;

use CodeIgniter\Model;

class CorporateBoard extends Model
{
    protected $table            = 'corporatebody';
    protected $primaryKey       = 'id_cb';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

	function select($id=0)
		{
			$dt = [];
			$cp = "id_cb, concat(cb_nome,' - ',cb_sigla,' (',cb_pais,')') as cb_nome";
			if ($id > 0)
				{
					$dt = parent::select($cp)
							->where('id_cb', $id)
							->findAll();
				} else{
					$dt[] = ['id_cb' => '', 'cb_nome' => '-Selecionar-'];
				}
			$dt2 = parent::select($cp)->orderBy("cb_nome")->findAll();
			$dt = array_merge($dt,$dt2);
			return $dt;
		}
}
