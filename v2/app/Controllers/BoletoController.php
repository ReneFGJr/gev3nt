<?php

namespace App\Controllers;

use App\Libraries\BbCobrancaService;
use App\Models\Bb\Boleto;
use CodeIgniter\Controller;

helper('sisdoc');
helper('nbr');

class BoletoController extends Controller
{
	protected $bbService;
	protected $boletoModel;
	protected $request;
	protected $session;

	public function __construct()
	{
		$this->bbService = new BbCobrancaService();
		$this->boletoModel = new Boleto();
		$this->request = service('request');
		$this->session = session();
	}

	/**
	 * Formulário para criar boleto
	 */
	public function form()
	{
		$sx = '';
		$sx .= view('header/header');
		$data = [];
		$_POST['numeroConvenio'] = '1234567';
		$_POST['numeroCarteira'] = '17';
		$_POST['numeroVariacaoCarteira'] = '35';
		$_POST['codigoModalidade'] = '1';
		$_POST['dataEmissao'] = '2025-06-10';
		$_POST['vencimento'] = '2025-06-20';
		$_POST['valor'] = '150.00';
		$_POST['indicadorAceiteTituloVencido'] = "N";
		$_POST['cliente_nome'] = 'João da Silva';
		$_POST['cliente_documento'] = '12345678909'; // CPF fictício


		$data['navbar'] = '';
		$data['event'] = view('boletos/form');
		$sx .= view('main', $data);
		return $sx;
	}

	/**
	 * Ação para registrar boleto
	 */
	public function registrar()
	{
		// Validação básica
		$post = $this->request->getPost();
		if (!$this->validate([
			'valor' => 'required|decimal',
			'vencimento' => 'required|valid_date[Y-m-d]',
			'cliente_nome' => 'required',
			// outros campos...
		])) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}


		// Monta payload conforme API BB
		$payload = [
			'numeroConvenio' => $post['numeroConvenio'],
			'numeroCarteira' => $post['numeroCarteira'],
			'numeroVariacaoCarteira' => $post['numeroVariacaoCarteira'],
			'codigoModalidade' => $post['codigoModalidade'],
			'dataEmissao' => date('Y-m-d'),
			'dataVencimento' => $post['vencimento'],
			'valorOriginal' => number_format($post['valor'], 2, '.', ''),
			'indicadorAceiteTituloVencido' => $post['indicadorAceiteTituloVencido'] ?? 'N',
			// demais campos obrigatórios/ opcionais: pagador (nome, documento, endereço), instruções etc.
			'pagador' => [
				'nome' => $post['cliente_nome'],
				'documento' => $post['cliente_documento'],
				// ...
			],
		];

		try {
			$response = $this->bbService->registrarBoleto($payload);
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Erro ao comunicar com API BB: ' . $e->getMessage());
		}
		// Exemplo: supõe que $response contenha um identificador ou “nossoNumero”
		$idBb = $response['id'] ?? ($response['nossoNumero'] ?? null);
		// Salvar localmente
		$this->boletoModel->insert([
			'nosso_numero'    => $response['nossoNumero'] ?? null,
			'id_bb'           => $idBb,
			'valor'           => $post['valor'],
			'vencimento'      => $post['vencimento'],
			'cliente_nome'    => $post['cliente_nome'],
			'cliente_documento' => $post['cliente_documento'],
			'status_bb'       => $response['status'] ?? null,
			'payload_request' => json_encode($payload),
			'response_bb'     => json_encode($response),
		]);
		// Exibir resultado
		$Events = new \App\Models\Event\Events();
		$sx = '';
		$sx .= view('header/header');
		$sx .= view('boletos/sucesso', ['response' => $response]);
		return $sx;
	}

	/**
	 * Consulta status de um boleto local
	 */
	public function consultar($idLocal)
	{
		$boleto = $this->boletoModel->find($idLocal);
		if (!$boleto) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Boleto não encontrado");
		}
		if (empty($boleto['id_bb'])) {
			return redirect()->back()->with('error', 'Boleto local não possui ID BB.');
		}
		try {
			$response = $this->bbService->consultarBoleto($boleto['id_bb']);
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Erro ao consultar API BB: ' . $e->getMessage());
		}
		// Atualizar status local
		$this->boletoModel->update($idLocal, [
			'status_bb'   => $response['status'] ?? $boleto['status_bb'],
			'response_bb' => json_encode($response),
		]);
		return view('boletos/consulta', ['response' => $response, 'boleto' => $boleto]);
	}
}
