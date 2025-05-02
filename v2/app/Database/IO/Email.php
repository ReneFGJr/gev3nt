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

	public function sendEmail($to='renefgj@gmail.com', $subject='Assunto do E-mail', $message='Mensagem do E-mail')
	{
		$email = service('email');  // Carrega o serviço de e-mail

		// Configuração do e-mail para HTML
		$email->setMailType('html');
		$email->setTo($to);  // Defina o e-mail do destinatário
		$email->setBCC('iskobrazil@gmail.com');
		$email->setSubject($subject);
		$email->setMessage($message);

		if ($email->send()) {
			return 'E-mail enviado com sucesso!';
		} else {
			return 'Erro ao enviar e-mail: ' . print_r($email->printDebugger(), true);
		}
	}
}
