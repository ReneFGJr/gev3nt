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

	public function sendEmail($to, $subject, $message, $attachments = [])
	{
		$email = service('email');  // Carrega o serviço de e-mail

		$email->setFrom(getenv('EMAIL_FROM'), getenv('EMAIL_NAME'));
		$email->setTo($to);
		$email->setBCC(['iskobrazil@gmail.com', 'renefgj@gmail.com']);
		$email->setSubject($subject);
		$email->setMailType('html');

		// Caminho da imagem incorporada
		$path = FCPATH;
		$path = str_replace('system/', 'public/', $path);
		$imagePath = $path . 'assets/logos/logo_isko_brasil.png';

		if (!file_exists($imagePath)) {
			return 'Erro: Imagem não encontrada no caminho: ' . $imagePath;
		}

		// Anexa a imagem e cria o CID
		$email->attach($imagePath);
		$cid = $email->setAttachmentCID($imagePath);

		// Monta a mensagem HTML com imagem incorporada
		$htmlMessage = '
		<table style="width: 640px; background-color: #f0f0f0; font-size: 16px; font-family: Arial, sans-serif; padding: 10px; border: 1px solid #ccc; border-radius: 10px;">
			<tr><td>
				<img src="cid:' . $cid . '" alt="Cabeçalho" style="max-width: 640px; height: auto;">
			</td></tr>
			<tr><td>' . $message . '</td></tr>
		</table>';

		$email->setMessage($htmlMessage);

		// Anexos adicionais (arquivos PDF, DOC, etc.)
		if (!empty($attachments)) {
			foreach ($attachments as $filePath) {
				if (file_exists($filePath)) {
					$email->attach($filePath);
				} else {
					return 'Erro: Arquivo de anexo não encontrado em: ' . $filePath;
				}
			}
		}

		if ($email->send()) {
			return 'E-mail enviado com sucesso!';
		} else {
			return 'Erro ao enviar e-mail: ' . print_r($email->printDebugger(), true);
		}
	}



	function sendEmailTest()
	{

		echo 'From Email: ' . getenv('EMAIL_FROM') . '<br>';
		echo 'SMTP Host: ' . getenv('EMAIL_HOST') . '<br>';
		echo 'SMTP User: ' . getenv('EMAIL_USER') . '<br>';

		$email = service('email');  // Carrega o serviço de e-mail

		$email->setFrom(getenv('EMAIL_FROM'), getenv('EMAIL_NAME'));

		$email->setTo('renefgj@gmail.com');  // Defina o e-mail do destinatário
		$email->setSubject('Assunto do E-mail');
		$email->setMessage('<p>Este é um e-mail de teste enviado via CodeIgniter 4.</p>');

		if ($email->send()) {
			return 'E-mail enviado com sucesso!';
		} else {
			return 'Erro ao enviar e-mail: ' . print_r($email->printDebugger(), true);
		}
	}
}
