<?php

namespace App\Models\User;

use CodeIgniter\Model;

helper('cookie');

class Users extends Model
{
	protected $table            = 'events_names';
	protected $primaryKey       = 'id_n';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'n_password',
		'apikey',
		'n_nome',
		'n_cpf',
		'n_email',
		'n_estrangeiro',
		'n_badge_name',
		'n_afiliacao',
		'n_badge_print',
		'n_biografia',
		'n_orcid'
	];

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

	/**************************** COOKIE */

	function etiqueta($ev)
	{
		$cp = 'n_badge_name, cb_sigla, id_n';
		$dt = $this
			->select($cp)
			->join('corporatebody', 'n_afiliacao = id_cb','left')
			->where('n_badge_print', 1)
			->orderBy('n_badge_name', 'ASC')
			->findAll();
		$texto = '';

		if (count($dt) == 0) {
			return "Nenhum participante com crachá impresso.";
		}

		foreach ($dt as $line) {
			$texto .= 'L
N
D11
191215100400080' . mb_strtoupper(ascii($line['n_badge_name'])) . '
191200300150080' . mb_strtoupper(ascii($line['cb_sigla'])) . '
E';
			$dd = [];
			$dd['n_badge_print'] = 0;
			$this->set($dd)->where('id_n', $line['id_n'])->update();
		}
		$file = 'etiqueta-' . date("Y-m-d-H:i:s") . '.prn';



		// Headers para forçar download do .prn
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . strlen($texto));
		echo $texto;
		exit;
	}
	public function saveCookieUser($dt = [])
	{
		// Nome do cookie
		$cookieName = 'g3ventos_permanent_cookie';
		// Valor do cookie
		$cookieValue = json_encode($dt);
		// Tempo de expiração (10 anos em segundos)
		$expiry = time() + (10 * 365 * 24 * 60 * 60);


		// Configurando o cookie
		set_cookie(
			$cookieName,  // Nome
			$cookieValue, // Valor
			$expiry       // Tempo de expiração
		);

		return "Cookie salvo com sucesso!";
	}

	public function getCookie()
	{
		$cookieName = 'g3ventos_permanent_cookie';

		// Obtendo o valor do cookie
		$cookieValue = get_cookie($cookieName);

		if ($cookieValue) {
			return (array)json_decode($cookieValue);
		} else {
			return [];
		}
	}

	function getUserId($id)
	{
		$dt = $this
			->join('corporatebody', 'n_afiliacao = id_cb')
			->find($id);
		return $dt;
	}

	public function logoff()
	{
		$this->deleteCookie();
		return true;
	}

	public function deleteCookie()
	{
		$cookieName = 'g3ventos_permanent_cookie';

		// Deletando o cookie corretamente
		//helper('cookie');
		delete_cookie($cookieName);
		return "";
	}

	/********************************************* SIGNIN */
	function signin($email, $password)
	{
		$dt = $this->where('n_email', $email)->first();
		if (count($dt) > 0) {
			$password = md5($password);
			if ($dt['n_password'] == $password) {
				$dd = [];
				$dd['id_n'] = $dt['id_n'];
				$dd['n_name'] = $dt['n_nome'];
				$dd['n_email'] = $dt['n_email'];
				$dd['apikey'] = $dt['apikey'];
				$this->saveCookieUser($dd);
				return 1;
			} else {
				return 2;
			}
		} else {
			return -1;
		}
	}

	function getByEmail($email)
	{
		$dt = $this->where('n_email', $email)->first();
		if (count($dt) > 0) {
			return $dt;
		} else {
			return [];
		}
	}

	function updatePassword($idu, $pass)
	{
		$dt = [];
		$dt['n_password'] = $pass;
		$this->set($dt)->where('id_n', $idu)->update();
		return 1;
	}

	function check_email($email)
	{
		if ($email == '') {
			return -1;
		}
		$dt = $this->where('n_email', $email)->findAll();
		if (count($dt) > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	public static function validateCPF(string $cpf): bool
	{
		// Remove all non-numeric characters
		$cpf = preg_replace('/\D/', '', $cpf);

		// Check if length is 11 and not a sequence of the same number
		if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
			return false;
		}

		// Calculate first digit verification
		for ($i = 0, $sum = 0; $i < 9; $i++) {
			$sum += $cpf[$i] * (10 - $i);
		}
		$remainder = $sum % 11;
		$firstCheck = ($remainder < 2) ? 0 : 11 - $remainder;

		// Calculate second digit verification
		for ($i = 0, $sum = 0; $i < 10; $i++) {
			$sum += $cpf[$i] * (11 - $i);
		}
		$remainder = $sum % 11;
		$secondCheck = ($remainder < 2) ? 0 : 11 - $remainder;

		// Check if both digits match
		return $cpf[9] == $firstCheck && $cpf[10] == $secondCheck;
	}

	function check_cpf($cpf)
	{
		if ($cpf == '') {
			return 0;
		}

		if ($this->validateCPF($cpf) == false) {
			return 9;
		}
		$dt = $this->where('n_cpf', $cpf)->findAll();
		if (count($dt) > 0) {
			return 1;
		} else {
			return 0;
		}
	}
}
