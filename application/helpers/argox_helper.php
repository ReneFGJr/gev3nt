<?
/*
@Author: Rene Faustino Gabriel Junior
https://github.com/ReneFGJr/ViaOro/blob/master/_etiqueta/a_modelo_02.prn
https://www.quebeckautomacao.com.br/emulacao-de-linguagem-para-impressoras-termicas/
https://blog.fabianobento.com.br/2016/11/argox-os-214-progamacao-ppla-criar-layout-de-etiquetas/
https://blog.fabianobento.com.br/2016/11/argox-os-214-progamacao-ppla-criar-layout-de-etiquetas/
http://labelary.com/viewer.html
*/
class argox
{
	/*
	Source: https://github.com/NewtonMan/PHP-Printer-PPLA
	*/
	private $STX = null;
	private $CR = null;

	public function __construct()
	{
		$this->STX = chr(2);
		$this->CR = chr(13);
	}

	public $lines = array();

	public function add()
	{
		$this->lines[] = $this->STX . 'L' . $this->CR;
		$this->lines[] = $this->STX . 'c0600' . $this->CR;
	}

	public function text($str, $x, $y, $font = 0, $orientation = 1, $mH = 0, $mV = 0)
	{
		$x = ($x < 45 ? 45 : $x);
		$x = $this->addLeading($x, 4);
		$y = $this->addLeading($y, 4);
		$this->lines[] = $orientation . $font . $mH . $mV . '003' . $y . $x . $str . $this->CR;
	}

	public function barcode($bar, $x = 0, $y = 0, $height = 0)
	{
		$x = ($x < 45 ? 45 : $x);
		$x = $this->addLeading($x, 4);
		$y = $this->addLeading($y, 4);
		$height = $this->addLeading($alt, 3);
		$this->lines[] = 'H16' . $this->CR;
		$this->lines[] = 'D18' . $this->CR;
		$this->lines[] = '1A63' . $height . $y . $x . $bar . $this->CR;
	}

	public function output()
	{
		$this->lines[] = 'E' . $this->CR;
		$this->lines[] = $this->STX . 'f320' . $this->CR;
		return implode('', $this->lines);
	}

	function addLeading($i, $size)
	{
		if (strlen($i) < $size) {
			for ($x = strlen($i); $x < $size; $x++) {
				$i = "0{$i}";
			}
		}
		return $i;
	}

	function print($tx)
		{
		$size = strlen($tx);
		header('Content-Description: File Transfer');
		header('Content-Type: image/prn');
		header('Content-Disposition: attachment; filename="etiqueta_atacado.prn"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . $size);
		echo $tx;
		exit;
		}
}
