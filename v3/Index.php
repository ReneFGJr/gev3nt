<?php

namespace App\Models\Messages;

use CodeIgniter\Model;

class Index extends Model
{
	protected $table            = 'articles';
	protected $primaryKey       = 'id_w';
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

	public function messages($tp = 0, $dt = [])
	{
		switch ($tp) {
			case '4': /* Aceite de Trabalho */
				$message = '<br>Prezados(as) autor(es) <b>[Autores]</b>.
							<br>
							<br>Temos o prazer de informar que o trabalho intitulado "<b>[Titulo]</b>", submetido à [Evento], foi <b>ACEITO</b> para apresentação.
							<br>
							<br>Será uma grande satisfação contar com a participação no evento. Informamos que, neste ano, as apresentações serão obrigatoriamente presenciais. Solicitamos, portanto, a confirmação da presença.
							<br>
							<br>Encaminhamos a carta de aprovação neste e-mail.
							<br>
							<br>Caso tenham dúvidas relacionadas ao evento, entrem em contato pelo e-mail: [EventoEmail].
							<br>
							<br>Esperamos encontrá-los!
							<br>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
				break;

			case '3':
				$message = 'Prezado(a) [Nome],
							<br>
							<br>Agradecemos sua inscrição no [Evento]. Entretanto, não identificamos a efetivação do pagamento da sua inscrição. Para darmos continuidade ao processo de validação, solicitamos que nos envie o(s) seguinte(s) documento(s):<ul>';

				if ($dt['type']['3'] == 1) {
					$message .= '<li>Comprovante de Depósito/PIX: referente ao pagamento da inscrição.</li>';
				}
				if ($dt['type']['2'] == 1) {
					$message .= '<li>Comprovante de Matrícula: para inscrições na categoria estudante de graduação ou pós-graduação.</li>';
				}

				$message .= '</ul><br>Pedimos que os documentos sejam encaminhados para o e-mail de contato [EventoEmail], identificando no assunto o seu nome completo e o número da inscrição.';
				$message .= '<p><b>Pagamento Realizado por Terceiros</b>: caso o pagamento tenha sido efetuado por terceiros, como uma fundação, solicitamos que informe o nome da fundação e a data do pagamento.</p>';
				$message .= '<p>Informamos que a programação completa do evento, bem como o status de validação da sua inscrição, estão disponíveis no sistema, por meio do link: [site].
							<br>Caso tenha alguma dúvida ou necessite de suporte, estamos à disposição.
							<br>Agradecemos sua participação e aguardamos o envio dos documentos para finalizarmos sua inscrição.
							</p>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
				break;

			case '2': /* Confirmação de pagamento */
				$message = 'Prezado(a) [Nome],
							<br>
							<br>Agradecemos sua inscrição [Evento]!
							<br>
							<br>Temos o prazer de confirmar o recebimento de sua inscrição no evento.
							<br>
							<br>Detalhes da Inscrição:
							<br>Nome: [Nome]
							<br>Categoria: [Tipo]
							<br>Valor da inscrição: R$ [Valor]

							<br><b>Informações para pagamento:</b>
							<br>Para efetivar sua inscrição, realize o pagamento de forma rápida e segura via PIX utilizando a Chave PIX: 10.262.169/0001-73 em nome da Sociedade ISKO Brasil.
							<br>
							<br>Ou por meio de depósito bancário:
							<br>Sociedade ISKO Brasil
							<br>Banco do Brasil (Código: 001)
							<br>Agência: 0141-4
							<br>C/C: 70261-7
							<br>CNPJ: 10.262.169/0001-73
							<br>
							<br>
							<br>Próximos Passos:
							<br>📌 Em breve, você receberá mais informações sobre a programação completa e instruções para acessar o evento.
							<br>
							<br>📌 Você pode acompanhar por aqui a efetivação de sua inscrição.
							<br>
							<br>📌 Caso tenha alguma dúvida ou precise de suporte, entre em contato pelo e-mail: [EmailSuporte].
							<br>
							<br>Estamos ansiosos para recebê-lo(a) em nosso evento e proporcionar uma experiência enriquecedora com debates e aprendizados.
							<br>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
				break;
			case '1': /* Confirmação de inscrição */
				$message = 'Prezado(a) [Nome],
							<br>
							<br>Agradecemos sua inscrição [Evento]!
							<br>
							<br>Temos o prazer de confirmar o recebimento do seu pagamento e sua participação no evento.
							<br>
							<br>Detalhes da Inscrição:
							<br>Nome: [Nome]
							<br>Categoria: [Tipo]
							<br>Valor Pago: R$ [Valor]
							<br>
							<br>Próximos Passos:
							<br>📌 Em breve, você receberá mais informações sobre a programação completa e instruções para acessar o evento.
							<br>📌 Caso tenha alguma dúvida ou precise de suporte, entre em contato pelo e-mail: [EmailSuporte].
							<br>
							<br>Estamos ansiosos para recebê-lo(a) em nosso evento e proporcionar uma experiência enriquecedora com debates e aprendizados.
							<br>
							<br>Atenciosamente,
							<br><b>Comitê Organizador - [Evento]</b>';
				break;
			default:
				$message = 'Nenhuma mensagem definida ' . $tp;
				break;
		}

		$message = str_replace('[Nome]', '<b>' . $dt['n_nome'] . '</b>', $message);
		$message = str_replace('[Evento]', $dt['e_name'], $message);
		$message = str_replace('[EventoEmail]', $dt['e_email'], $message);

		if (isset($dt['titulo'])) {
			$message = str_replace('[Titulo]', $dt['titulo'], $message);
		}

		if (isset($dt['autores'])) {
			$autores = $dt['autores'];
			$autores = trim(str_replace(' , ', ', ', $autores));
			$message = str_replace('[Autores]', $autores, $message);
		}

		if (isset($dt['ei_modalidade'])) {
			$message = str_replace('[Tipo]', $dt['ei_modalidade'], $message);
			$message = str_replace('[Valor]', number_format($dt['ei_preco'], 2, ',', '.'), $message);
		}
		$message = str_replace('[Data]', $dt['cb_created'], $message);
		$message = str_replace('[EmailSuporte]', 'isko@isko.org.br', $message);

		if (isset($dt['site'])) {
			$message = str_replace('[site]', $dt['site'], $message);
		} else {
			$message = str_replace('[site]', 'https://isko.org.br/inscricoes', $message);
		}
		return $message;
	}
}
