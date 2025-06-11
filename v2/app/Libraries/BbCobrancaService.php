<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Cache\CacheInterface;

class BbCobrancaService
{
	protected $clientId;
	protected $clientSecret;
	protected $appKey;
	protected $baseUrl;
	protected $http;
	protected $cache;

	// https://acesso.bb.com.br/v2/login?appId=ipa-developers

	public function __construct()
	{
		$this->clientId = env('BB_CLIENT_ID');
		$this->clientSecret = env('BB_CLIENT_SECRET');
		$this->appKey = env('BB_APP_KEY');
		// escolha URL conforme ambiente
		$env = env('BB_ENV');
		if ($env === 'producao') {
			$this->baseUrl = env('BB_API_URL_PROD');
		} else {
			$this->baseUrl = env('BB_API_URL_HOMOLOG');
		}

		// HTTP client do CI4
		$this->http = \Config\Services::curlrequest([
			'base_uri' => $this->baseUrl,
			'timeout'  => 30,
			'headers'  => [
				'Content-Type' => 'application/json',
				'Accept'       => 'application/json'
			],
		]);
		// Cache para token
		$this->cache = \Config\Services::cache();
	}

	/**
	 * Obtém ou renova o access token usando Client Credentials OAuth2
	 */
	protected function getAccessToken()
	{
		// Tenta recuperar do cache
		if ($tokenData = $this->cache->get('bb_access_token')) {
			// tokenData: ['access_token'=>..., 'expires_at'=>timestamp]
			if (time() < $tokenData['expires_at']) {
				return $tokenData['access_token'];
			}
		}
		// Realiza requisição de token
		$tokenUrl = '/oauth/token'; // ver docs exato endpoint
		$response = $this->http->post($tokenUrl, [
			'auth' => [$this->clientId, $this->clientSecret],
			'form_params' => [
				'grant_type' => 'client_credentials'
			],
			'headers' => [
				'Accept' => 'application/json',
				'Content-Type' => 'application/x-www-form-urlencoded',
				'AppKey' => $this->appKey
			]
		]);
		$body = json_decode($response->getBody(), true);
		if (empty($body['access_token']) || empty($body['expires_in'])) {
			throw new \Exception('Falha ao obter access_token BB: ' . json_encode($body));
		}
		$accessToken = $body['access_token'];
		// Calcula expiração levemente antes para segurança
		$expiresAt = time() + intval($body['expires_in']) - 60;
		// Armazena em cache
		$this->cache->save('bb_access_token', [
			'access_token' => $accessToken,
			'expires_at'   => $expiresAt
		], intval($body['expires_in']) - 60);
		return $accessToken;
	}

	/**
	 * Monta cabeçalhos autorizados para chamada à API
	 */
	protected function getHeaders()
	{
		$token = $this->getAccessToken();
		return [
			'Authorization' => 'Bearer ' . $token,
			'AppKey'        => $this->appKey,
			'Content-Type'  => 'application/json',
			'Accept'        => 'application/json',
		];
	}

	/**
	 * Registra um boleto
	 * $data: array com campos conforme documentação BB, ex:
	 *   numeroConvenio, numeroCarteira, numeroVariacaoCarteira, codigoModalidade,
	 *   dataEmissao (YYYY-MM-DD), dataVencimento, valorOriginal, indicadorAceiteTituloVencido, ...
	 */
	public function registrarBoleto(array $data)
	{
		$endpoint = '/cobrancas?gw-dev-app-key=0bc895e9c8d54070b7fc2d12ece9e22c'; // verificar o endpoint correto em docs: /cobrancas ou /boletos
		$response = $this->http->post($endpoint, [
			'headers' => $this->getHeaders(),
			'json'    => $data,
		]);
		$body = json_decode($response->getBody(), true);
		return $body;
	}

	/**
	 * Consulta um boleto por identificador (ex: nossoNumero ou identificador retornado)
	 */
	public function consultarBoleto(string $id)
	{
		$endpoint = "/cobrancas/{$id}";
		$response = $this->http->get($endpoint, [
			'headers' => $this->getHeaders()
		]);
		return json_decode($response->getBody(), true);
	}

	/**
	 * Cancela um boleto
	 */
	public function cancelarBoleto(string $id, array $motivo = null)
	{
		$endpoint = "/cobrancas/{$id}/cancelamento";
		$payload = $motivo ?? [];
		$response = $this->http->post($endpoint, [
			'headers' => $this->getHeaders(),
			'json'    => $payload
		]);
		return json_decode($response->getBody(), true);
	}

	// Outros métodos: alterarBoleto, baixarBoleto, listar, webhook, etc.
}
