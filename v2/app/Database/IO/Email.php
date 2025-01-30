<?php

namespace App\Models\IO;

use CodeIgniter\Model;
use CodeIgniter\Email\Email;

class EmailX extends Model
{
    protected $table            = 'emails';
    protected $primaryKey       = 'id';
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

	public function sendEmail()
	{
		$email = service('email');  // Carrega o serviço de e-mail

		$email->setTo('destinatario@example.com');  // Defina o e-mail do destinatário
		$email->setSubject('Assunto do E-mail');
		$email->setMessage('<p>Este é um e-mail de teste enviado via CodeIgniter 4.</p>');

		if ($email->send()) {
			return 'E-mail enviado com sucesso!';
		} else {
			return 'Erro ao enviar e-mail: ' . print_r($email->printDebugger(), true);
		}
	}
}
