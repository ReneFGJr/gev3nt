<?php

namespace App\Controllers;

use App\Models\ChapaModel;
use App\Models\VotoModel;

class Votacao extends BaseController
{
	public function index()
	{
		return view('votacao/login');
	}

	public function autenticar()
	{
		$id = $this->request->getPost('id_nb');
		$Users = new \App\Models\User\Users();
		$socio = $Users->where('id_nb', $id)->first();

		if ($socio) {
			$votoModel = new VotoModel();
			if ($votoModel->where('id_socio', $id)->first()) {
				return view('votacao/mensagem', ['mensagem' => 'Você já votou!']);
			}

			session()->set('id_nb', $id);
			$chapaModel = new ChapaModel();
			$chapas = $chapaModel->findAll();

			return view('votacao/votar', ['chapas' => $chapas, 'socio' => $socio]);
		}

		return view('votacao/mensagem', ['mensagem' => 'Sócio não encontrado']);
	}

	public function votar()
	{
		$idChapa = $this->request->getPost('id_chapa');
		$idSocio = session()->get('id_nb');

		$votoModel = new VotoModel();
		try {
			$votoModel->insert(['id_socio' => $idSocio, 'id_chapa' => $idChapa]);
			return view('votacao/mensagem', ['mensagem' => 'Voto registrado com sucesso!']);
		} catch (\Exception $e) {
			return view('votacao/mensagem', ['mensagem' => 'Erro: Você já votou.']);
		}
	}
}
