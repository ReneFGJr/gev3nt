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

	/**************************** COOKIE */
	public function saveCookieUser($dt=[])
	{
		// Nome do cookie
		$cookieName = 'g3ventos_permanent_cookie';
		// Valor do cookie
		$cookieValue = $dt;
		// Tempo de expiração (10 anos em segundos)
		$expiry = time() + (10 * 365 * 24 * 60 * 60);

		// Configurando o cookie
		$this->response->setCookie(
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
		$cookieValue = $this->request->getCookie($cookieName);

		if ($cookieValue) {
			return "Valor do cookie: " . $cookieValue;
		} else {
			return "Cookie não encontrado.";
		}
	}

	public function deleteCookie()
	{
		$cookieName = 'g3ventos_permanent_cookie';

		// Deletando o cookie
		$this->response->deleteCookie($cookieName);

		return "Cookie excluído com sucesso.";
	}

	/********************************************* SIGNIN */
	function signin($email, $password)
	{
		$dt = $this->where('n_email', $email)->where('apikey', md5($password))->findAll();
		if (count($dt) > 0) {
			$this->saveCookieUser($dt[0]);
			return 1;
		} else {
			return 2;
		}
	}

	function check_email($email)
		{
			if ($email == '') {
				return -1;
			}
			$dt = $this->where('n_email', $email)->findAll();
			if (count($dt) > 0)
				{
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
