<?php
defined("BASEPATH") OR exit("No direct script access allowed");

/**
* CodeIgniter Form Helpers
*
* @package     CodeIgniter
* @subpackage  Helpers
* @category    Helpers
* @author      Rene F. Gabriel Junior <renefgj@gmail.com>
* @link        http://www.sisdoc.com.br/CodIgniter
* @version     v0.20.12.18
*/

/* 2020-01-24 function 2 e 3 */
require("form_sisdoc_helper_2.php");
require("form_sisdoc_helper_3.php");
require("form_sisdoc_helper_4.php");
require("form_sisdoc_helper_5.php");

/* 2017-12-21 function read_link($url) */
$dd = array();

/**
* Classe container para metodos estaticos de utilidades variadas
* @author goncin (goncin ARROBA gmail PONTO com)
*/

const NN_PONTO = '\.';
const NN_PONTO_ESPACO = '. ';
const NN_ESPACO = ' ';
const NN_REGEX_MULTIPLOS_ESPACOS = '\s+';
const NN_REGEX_NUMERO_ROMANO = '^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$';

///////////////////////////////////////////////////////////////////////////////////////////////
//// Creditos : http://forum.imasters.uol.com.br/index.php?showtopic=125375&hl=extenso       //
//// Autor desconhecido, postado por Fabyo                                                   //
///////////////////////////////////////////////////////////////////////////////////////////////
function extenso($valor = 0, $maiusculas = false) {
    $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

    $z = 0;
    $rt = "";

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++)
    for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
    $inteiro[$i] = "0" . $inteiro[$i];

    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")
        $z++;
        elseif ($z > 0)
        $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
        $r .= (($z > 1) ? " de " : "") . $plural[$t];
        if ($r)
        $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    if (!$maiusculas) {
        return ($rt ? $rt : "zero");
    } else {
        if ($rt)
        $rt = ereg_replace(" E ", " e ", ucase($rt));
        return (($rt) ? ($rt) : "Zero");
    }

}

/***/
function sn($it = 0) {
    if ($it == 0) {
        $rst = mst('NÃO');
    } else {
        $rst = mst('SIM');
    }
    return ($rst);
}

/**
* @param string $nome O nome a ser normalizado
* @return string O nome devidamente normalizado
*/

function normalizarNome($nome) {
    return ($nome);
}

/**
* CodeIgniter
* sisDOC Labs
*
* @package PageCount
* @author  Rene F. Gabriel Junior <renefgj@gmail.com>
* @copyright Copyright (c) 2006 - 2015, sisDOC
* @version 0.16.01
*/
function page_count()
{
    $sx = '';
    return ($sx);
}

/**
* CodeIgniter
* sisDOC Labs
*
* @package CodeIgniter
* @author  Rene F. Gabriel Junior <renefgj@gmail.com>
* @copyright Copyright (c) 2006 - 2015, sisDOC
* @license http://opensource.org/licenses/MIT  MIT License
* @link    http://codeigniter.com
* @since   Version 2.1.0
* @version 0.15.35
* @filesource
*/

function get($key) {
    $CI = &get_instance();
    $dp = '';
    if (is_array($CI -> input -> post($key))) {
        $dpn = $CI -> input -> post($key);
        for ($r = 0; $r < count($dpn); $r++)
        {
            $dp .= $dpn[$r] . ';';
        }
    } else {
        $dp = $CI -> input -> post($key);
        $dp .= $CI -> input -> get($key);
        /* tratamento */
        $dp = trim($dp);

        $dp = troca($dp, "'", '´');
    }
    return ($dp);
}

function alert($msg)
{
    $sx = '';
    if (strlen($msg) > 0)
    {
        $sx = '
        <script>
        alert("' . $msg . '");
        </script>';
    }
    return ($sx);
}

function xls($arquivo = '') {
    // Configurações header para forçar o download
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/x-msexcel");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
    header("Content-Description: CIP - Export file " . $arquivo);
}

function validaemail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        list($alias, $domain) = explode("@", $email);
        if (checkdnsrr($domain, "MX")) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function brtosql($dt)
{
    $dt = brtos($dt);
    $dt = substr($dt, 0, 4) . '-' . substr($dt, 4, 2) . '-' . substr($dt, 6, 2);
    return ($dt);
}

function dataDiff($d1,$d2)
    {
    $data_inicio = new DateTime($d1);
    $data_fim = new DateTime($d2);

    // Resgata diferença entre as datas
    $dateInterval = $data_inicio->diff($data_fim);
    return($dateInterval->days);
    }

function data_completa($data)
{
    $dt = sonumero($data);
    $ano = substr($dt, 0, 4);
    $mes = round(substr($dt, 4, 2));
    $dia = round(substr($dt, 6, 2));
    if ($dia == '1')
    {
        $dia = '1º';
    }
    $txt = $dia . ' de ' . meses($mes) . ' de ' . $ano . '.';
    return ($txt);
}

function meses($id = 0) {
    $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    $id = round($id);
    return ($mes[$id]);
}

function meses_short() {
    $mes = array('', 'Jan.', 'Fev.', 'Mar.', 'Abr.', 'Maio', 'Jun.', 'Jul.', 'Ago.', 'Set.', 'Out.', 'Nov.', 'Dez.');
    return ($mes);
}



/* checa e cria diretorio */
function dircheck($dir) {
    $ok = 0;
    if (is_dir($dir)) { $ok = 1;
    } else {
        mkdir($dir);
        $rlt = fopen($dir . '/index.php', 'w');
        fwrite($rlt, 'acesso restrito');
        fclose($rlt);
    }
    return ($ok);
}

function mst($txt) {
    $txt = troca($txt, chr(13), '<br/>');
    return ($txt);
}

function format_fone($tel) {
    $tel = sonumero($tel);
    if (strlen($tel) > 9) {
        if (strlen($tel) > 10) {
            $tel = '(' . substr($tel, 0, 2) . ') ' . substr($tel, 2, 5) . '-' . substr($tel, 7, 4);
        } else {
            $tel = '(' . substr($tel, 0, 2) . ') ' . substr($tel, 2, 4) . '-' . substr($tel, 6, 4);
        }
    } else {
        if (strlen($tel) > 8) {
            $tel = substr($tel, 0, 5) . '-' . substr($tel, 5, 4);
        } else {
            $tel = substr($tel, 0, 4) . '-' . substr($tel, 4, 4);
        }
    }
    return ($tel);
}

function sonumero($it) {
    $rlt = '';
    for ($ki = 0; $ki < strlen($it); $ki++) {
        $ord = ord(substr($it, $ki, 1));
        if (($ord >= 48) and ($ord <= 57)) { $rlt = $rlt . substr($it, $ki, 1);
        }
    }
    return $rlt;
}

function load_page($url)
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_HEADER => false, // don't return headers
        CURLOPT_FOLLOWLOCATION => true, // follow redirects
        CURLOPT_ENCODING => "", // handle all encodings
        CURLOPT_USERAGENT => "spider", // who am i
        CURLOPT_AUTOREFERER => true, // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
        CURLOPT_TIMEOUT => 120, // timeout on response
        CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);
    curl_close($ch);

    $header['errno'] = $err;
    $header['errmsg'] = $errmsg;
    $header['content'] = $content;
    return $header;
}

function brtos($data) {
    $data = sonumero($data);
    $data = substr($data, 4, 4) . substr($data, 2, 2) . substr($data, 0, 2);
    return ($data);
}

function brtod($data) {
    $data = sonumero($data);
    $data = substr($data, 4, 4) . '-' . substr($data, 2, 2) . '-' . substr($data, 0, 2);
    return ($data);
}

function strzero($ddx, $ttz) {
    $ddx = round($ddx);
    while (strlen($ddx) < $ttz) { $ddx = "0" . $ddx;
    }
    return ($ddx);
}

function UpperCase($d) {

    $d = troca($d, 'ç', 'Ç');

    $d = troca($d, 'á', 'Á');
    $d = troca($d, 'à', 'À');
    $d = troca($d, 'ã', 'Ã');
    $d = troca($d, 'â', 'Â');
    $d = troca($d, 'ä', 'Ä');

    $d = troca($d, 'é', 'É');
    $d = troca($d, 'è', 'È');
    $d = troca($d, 'ê', 'Ê');
    $d = troca($d, 'ë', 'Ë');

    $d = troca($d, 'í', 'Í');
    $d = troca($d, 'ì', 'Ì');
    $d = troca($d, 'î', 'Î');
    $d = troca($d, 'ï', 'Ï');

    $d = troca($d, 'ó', 'Ó');
    $d = troca($d, 'ò', 'Ò');
    $d = troca($d, 'õ', 'Õ');
    $d = troca($d, 'ö', 'Ö');
    $d = troca($d, 'ô', 'Ô');

    $d = troca($d, 'ú', 'Ú');
    $d = troca($d, 'ù', 'Ù');
    $d = troca($d, 'û', 'Û');
    $d = troca($d, 'ü', 'Ü');

    $d = strtoupper($d);

    return $d;
}

/* Gerador de CPF */
function mod($dividendo, $divisor) {
    return round($dividendo - (floor($dividendo / $divisor) * $divisor));
}

function GerarCPF() {
    $n1 = '1';
    $n2 = '1';
    $n3 = '1';
    $n4 = '1';
    $n5 = rand(0, 9);
    $n6 = rand(0, 9);
    $n7 = rand(0, 9);
    $n8 = rand(0, 9);
    $n9 = rand(0, 9);
    $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
    $d1 = 11 - ( mod($d1, 11));

    if ($d1 >= 10) {
        $d1 = 0;
    }

    $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
    $d2 = 11 - ( mod($d2, 11));

    if ($d2 >= 10) { $d2 = 0;
    }

    return ($n1 . $n2 . $n3 . $n4 . $n5 . $n6 . $n7 . $n8 . $n9 . $d1 . $d2);
}

function validaCPF($cpf = null) {
    /* @author http://www.geradorcpf.com/script-validar-cpf-php.htm */
    // Verifica se um número foi informado
    if (empty($cpf)) {
        return false;
    }

    // Elimina possivel mascara
    $cpf = sonumero($cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    // Verifica se o numero de digitos informados é igual a 11
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo
    // foi digitada. Caso afirmativo, retorna falso
    else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
        return false;
        // Calcula os digitos verificadores para verificar se o
        // CPF é válido
    } else {

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += (int)$cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ((int)$cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

function mask_cpf($cpf) {
    $cpf = sonumero($cpf);
    if (strlen($cpf) > 12) {
        strzero($cpf, 12);
        $cpf = substr($cpf, 0, 2) . '.' . substr($cpf, 2, 3) . '.' . substr($cpf, 5, 3) . '/' . substr($cpf, 8, 4) . '-' . substr($cpf, 12, 2);
    } else {
        strzero($cpf, 12);
        $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
    return ($cpf);
}

function db_query($sql) {
    global $dbn;
    $dbn = 0;
    $CI = &get_instance();
    $query = $CI -> db -> query($sql);
    return ($query -> result());
}

/* Tipo de servidor */
function debug() {
    if (file_exists('_server_type.php')) {
        require ("_server_type.php");
        if ($server_type != '3') {
            $CI = &get_instance();
            $CI -> output -> enable_profiler('true');
        }
    }
}


function reload($tipo = 'J')
{
    $sx = '
    <script>
    location.reload();
    </script>
    ';
    echo $sx;
}

/* Recupera IP
* @author Rene F. Gabriel Junior <renefgj@gmail.com>
* @versao v0.15.23
*/
function ip() {
    $ip = trim($_SERVER['REMOTE_ADDR']);
    if ($ip == '::1') { $ip = '127.0.0.1';
    }
    return ($ip);
}

/*
* http://www.kathirvel.com/php-convert-or-cast-array-to-object-object-to-array/
*/
function array_to_object($array) {
    return (object)$array;
}

function object_to_array($object) {
    return (array)$object;
}

/*
* Rene
*/

function cr() {
    /* retorna um Nova linha e Retorno de Carro */
    return (chr(13) . chr(10));
}

function stosql($data = 0) {
    $data = sonumero($data);
    if ($data < 19100101) {
        return ('0000-00-00');
    } else {
        $dt = substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2);
        return ($dt);
    }
}

function DateAdd($ddf, $ddi, $ddt) {
    $ddano = intval("0" . substr($ddt, 0, 4));
    $ddmes = intval("0" . substr($ddt, 4, 2));
    $dddia = intval("0" . substr($ddt, 6, 2));
    $ddr = mktime(0, 0, 0, 1, 1, 1900);
    if ($ddf == 'd') {
        $ddt = mktime(0, 0, 0, $ddmes, $dddia + $ddi, $ddano);
    }
    if ($ddf == 'w') {
        $ddt = mktime(0, 0, 0, $ddmes, $dddia + $ddi * 7, $ddano);
    }
    if ($ddf == 'm') {
        $ddt = mktime(0, 0, 0, $ddmes + $ddi, $dddia, $ddano);
    }
    if ($ddf == 'y') {
        $ddt = mktime(0, 0, 0, $ddmes, $dddia, $ddano + $ddi);
    }
    return (date("Ymd", $ddt));
}

function stodbr($data = 0) {
    $data = sonumero($data);
    if ($data < 19100101) {
        return ('');
    } else {
        $dt = substr($data, 6, 2) . '/' . substr($data, 4, 2) . '/' . substr($data, 0, 4);
        return ($dt);
    }
}

function stod($data = 0) {
    $data = sonumero($data);
    if ($data < 19100101) {
        return (0);
    } else {
        $dt1 = substr($data, 6, 2);
        $dt2 = substr($data, 4, 2);
        $dt3 = substr($data, 0, 4);
        $dt = mktime(0, 0, 0, $dt2, $dt1, $dt3);
        return ($dt);
    }
}

function form_sisdoc_getpost() {
    global $dd, $acao;

    $CI = &get_instance();
    $post = $CI -> input -> post();
    $get = $CI -> input -> get();
    $vars = array_merge($get, $post);

    if (!isset($vars['acao']))
    {
        $acao = '';
    } else {
        $acao = troca($vars['acao'], "'", '´');
    }

    for ($k = 0; $k < 100; $k++) {
        /* Valore absolutos */
        $varf = 'dd' . $k;
        if (isset($vars[$varf])) {
            $varf = $vars[$varf];
            $dd[$k] = post_security($varf);
        } else {
            $dd[$k] = '';
        }

        /******** Subvariaveis */
        for ($t=0;$t < 24;$t++)
        {
            $varf = 'dd' . $k.chr(97+$t);
            if (isset($vars[$varf])) {
                $varf = $vars[$varf];
                $dd[$k] .= post_security($varf).';';
            }
        }
    }
    return (true);
}

function post_security($s) {
    $s = troca($s, '<', '&lt;');
    $s = troca($s, '>', '&gt;');
    $s = troca($s, '"', '&quot;');
    //$s = troca($s,'/','&#x27;');
    $s = troca($s, "'", '&#x2F;');
    return ($s);
}

/* Obsoleto em 20/01/2020 */
function nbr_autor($xa, $tp) {
    return(nbr_author($xa,$tp));
}

function db_read($rlt) {
    global $dba, $dbn;
    if (!isset($dba)) { $dba = array();
    }

    /* */
    if (count($rlt) == 0) {
        return (FALSE);
    }

    /* */
    if (!isset($dbn)) { $dbn = 0;
    }

    $row = object_to_array($rlt[0]);

    $keys = array_keys($row);
    $key = $keys[0];

    if ((!isset($dba[$key])) or ($dbn == 0)) {
        $dba[$key] = 0;
    } else {
        $dba[$key] = $dba[$key] + 1;
    }
    $dbn = 1;
    $id = round($dba[$key]);

    if ($id >= count($rlt)) {
        return (FALSE);
    } else {
        $rslt = $row = object_to_array($rlt[$id]);
        return ($rslt);
    }

    exit ;
}

function page() {
    $pg = $_SERVER['REQUEST_URI'];

    $pos = strpos($pg, '.php');
    $pg = substr($pg, $pos + 5, strlen($pg));
    //$pg = troca($pg,'/','-');
    if (strpos($pg, '?') > 0) {
        $pos = strpos($pg, '?');
        $pg = substr($pg, 0, $pos);
    }
    $pg = troca($pg, '1', '');
    $pg = troca($pg, '2', '');
    $pg = troca($pg, '3', '');
    $pg = troca($pg, '4', '');
    $pg = troca($pg, '5', '');
    $pg = troca($pg, '6', '');
    $pg = troca($pg, '7', '');
    $pg = troca($pg, '8', '');
    $pg = troca($pg, '9', '');
    $pg = troca($pg, '0', '');
    $pg = troca($pg, '/', '');

    $page = $pg;
    return ($page);
}

function load_file_local($file) {
    $sx = '';
    $fld = fopen($file, 'r');
    while (!(feof($fld))) {
        $sx .= fread($fld, 1024);
    }
    fclose($fld);
    return ($sx);
}

/* Funcao */

function highlight($text, $words) {
    $mark_on = '<font style="background-color : Yellow;"><B>';
    $mark_off = '</B></font>';

    $text = ($text);
    foreach ($words as $word) {
        $word = preg_quote($word);
        $text = preg_replace("/\b($word)\b/i", $mark_on . '$1' . $mark_off, $text);
    }
    return $text;
}

function ascii($d)
{    //$d = strtoupper($d);

    /* acentos agudos */
    $d = (str_replace(array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'), array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), $d));

    /* acentos til */
    $d = (str_replace(array('ã', 'õ', 'Ã', 'Õ'), array('a', 'o', 'A', 'O'), $d));

    /* acentos cedilha */
    $d = (str_replace(array('ç', 'Ç', 'ñ', 'Ñ'), array('c', 'C', 'n', 'N'), $d));

    /* acentos agudo inverso */
    $d = (str_replace(array('à', 'è', 'ì', 'ò', 'ù', 'À', 'È', 'Ì', 'Ò', 'Ù'), array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), $d));

    /* acentos agudo cinconflexo */
    $d = (str_replace(array('â', 'ê', 'î', 'ô', 'û', 'Â', 'Ê', 'Î', 'Ô', 'Û'), array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), $d));

    /* trema */
    $d = (str_replace(array('ñ', 'ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü'), array('n', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), $d));


    /* Especiais */
    $d = (str_replace(array('Å'), array('A'), $d));
    return $d;
}

function UpperCaseSQL($d) {
    $d = ascii($d);
    $d = strtoupper($d);
    return $d;
}

function LowerCase($term) {
    $d = mb_strtolower($term);
    return ($d);
}

function LowerCaseSQL($term) {
    $term = ascii($term);
    $term = mb_strtolower($term);
    return ($term);
}

// --------------------- FILE MANIPULATION
function file_save_post($dir, $name, $file) {
    $temp = $file['tmp_name'];
    $fname = $file['name'];
    $size = $file['size'];
    $filename = $dir . $name;

    if (move_uploaded_file($temp, $filename)) {
        return (1);
    } else {
        return (0);
    }
}

// ------------------------------------------------------------------------
/* FORM CLASS
*
*
*
*
*/
class form {
    var $id = 0;
    var $cp = array();
    var $data = array();
    var $post = array();
    var $tabela = '';
    var $saved = 0;

    /* row */
    var $fd = array();
    var $lb = array();
    var $mk = array();
    var $edit = false;
    var $see = false;
    var $novo = false;

    var $row_view = '';
    var $row_edit = '';
    var $row = '';
    var $offset = 30;
    var $order = '';

    var $ged_tabela = '';
    var $ged_upload = '';
    var $ged_download = '';

    function editar($cp, $tabela) {
        $ed = new form;
        $ed -> id = $this -> id;
        $ed -> tabela = $tabela;
        if (isset($this->return))
        {
            $_POST['return'] = $this->return;
            echo '<HR>';
        }

        /* Valida botao */
        $bt = 0;
        for ($r = 0; $r < count($cp); $r++) {
            if (UpperCaseSQL(substr($cp[$r][0], 0, 2)) == '$B') { $bt = 1;
            }
        }
        if ($bt == 0) {
            array_push($cp, array('$B8', '', msg('submit'), False, False));
        }

        /* Monta forumário */
        $ed -> cp = $cp;
        $result = form_edit($ed);

        $t = $result['tela'];
        $this -> saved = $result['saved'];
        return ($t);
    }

    /***
    * Format submit Ajax
    */
    function ajax_submit($cp, $url = '', $div = '') {
        $vdata = "";
        $data = "";
        $saved = 0;
        $CI = &get_instance();
        $acao = $CI -> input -> post('acao');

        /* VALIDA POST */
        if (strlen($acao) > 0) {
            $saved = valida_post($cp);
            if ($saved > 0) {
                return ($saved);
            }
        }
        //valida_post
        for ($r = 0; $r < count($cp); $r++) {
            $tp = substr($cp[$r][0], 0, 2);

            if (($tp == '$O') or ($tp == '$Q')) {
                $vdata .= '$dd' . $r . ' = $("#dd' . $r . ' option:selected").val(); ' . cr();
            } else {
                $vdata .= '$dd' . $r . ' = $("#dd' . $r . '").val(); ' . cr();
            }
            if (strlen($data) > 0) { $data .= ', ' . cr();
            }
            $data .= 'dd' . $r . ': $dd' . $r;
        }
        $data .= ', acao: "save" ';
        $sx = '
        <script>
        $("#acao").click(function() {
            ' . $vdata . '
            $.ajax({
                url : "' . $url . '",
                type : "post",
                data : { ' . $data . ' },
                success : function(data) {
                    $("#' . $div . '").html(data);
                } });
            });
            </script>
            ';
            return ($sx);
        }

    }

    /* Paginacao */
    function npag($obj, $blank = 1, $tot = 10, $offset = 20) {
        $page = uri_string();
        $pagm = $tot;
        $term = $obj -> term;
        $npage = $obj -> npag;
        $field = $obj -> fd;
        $npage = round($npage);

        /* Campos para busca */
        $fd = $obj -> fd;

        $sx = '<table class="table lt2" width="100%">';
        $sx .= '<tr valign="middle"><td width="35%" class="visible-lg">';
        $page = substr($page, 0, strpos($page, '/'));
        $link = $obj -> row;


        /* Paginacao */
        $sx .= ' Page:';
        $linka = $link . '/';
        $sx .= '<select onChange="location=\'' . $linka . '\'+this.options[this.selectedIndex].value;">';
        for ($r = 1; $r <= $pagm; $r++)
        {
            $chk = '';
            if ($r == $npage)
            {
                $chk = "selected";
            }
            $sx .= '<option value="' . $r . '" ' . $chk . '>' . $r . '</option>';
        }
        $sx .= '</select>';

        /* Busca */

        /************************* form */
        $sx .= '</td><td width="10%">';
        $attribute['method'] = 'get';
        $sx .= form_open($link, $attribute);

        /* ************************** filtro ************************/
        $sx .= '</td><td align="right" width="20%"><nobr>';
        $sx .= msg('filtro') . ':';
        if (strlen(get('dd1')) > 0)
        {
            $vlr = get('dd1');
        } else {
            $vlr = $term;
        }

        $data = array('name' => 'dd1', 'id' => 'dd1', 'value' => $vlr, 'maxlength' => '100', 'size' => '100', 'style' => 'width:150px', );
        $sx .= form_input($data);
        //$sx .= form_submit('acao', msg('bt_search'));
        $sx .= '&nbsp;<a href="' . ($link) . '"><input type="submit" name="acao" value="' . msg('bt_search') . '" class="btn">';

        if (strlen($term) > 0)
        {
            //$sx .= form_submit('acao', msg('bt_clear'));
            $sx .= '&nbsp;<a href="' . ($link) . '"><input type="submit" name="acao" value="' . msg('bt_clear') . '" class="btn">';
        }
        $sx .= '</nobr>';

        /* ************************** field ************************/
        if (strlen(get('dd5')) > 0)
        {
            $dd5 = sonumero(get('dd5'));
        } else {
            $dd5 = 1;
        }
        $sx .= '</td><td><nobr>';

        $sx .= msg('in').': <select name="dd5" id="dd5">' . cr();
        for ($rt = 1; $rt < count($fd); $rt++)
        {
            $sel = '';
            if ($rt == $dd5)
            {
                $sel = "selected";
            }
            $sx .= '<option value="' . $rt . '" ' . $sel . '>' . msg($fd[$rt]) . '</option>' . cr();
        }
        $sx .= '</select></nobr>' . cr();
        $sx .= form_hidden('dd2', 'search');
        /* ************************** action ************************/
        $sx .= form_close();


        /*************** LADO DIREITO BOTAO NOVO*/
        if ($obj -> novo == true) {
            $link = $obj -> row_edit . '/0/0';
            $sx .= '<td align="right">';
            //$sx .= form_submit('acao', msg('bt_new'));
            $sx .= '<a href="' . ($link) . '"><input type="button" value="' . msg('bt_new') . '" class="btn">';
            $sx .= '</td>';
        }

        $sx .= '</tr>'.cr();
        $sx .= '</table>'.cr();
        return ($sx);
    }

    /* Funcao troca */
    function troca($qutf, $qc, $qt)
    {
        if (!is_array($qc))
        {
            $qc = array($qc);
        }
        if (!is_array($qt))
        {
            $qt = array($qt);
        }
        return (str_replace($qc, $qt, $qutf));
    }

    ############################################### CHECSUM
    function checksum($tz)
    {
        $t=0;
        for ($r=0;$r < strlen($tz);$r++)
        {
            $o = ord($tz[$r]);
            $t = $t + $o;
        }
        $t = dechex($t);
        while (strlen($t) < 12)
        {
            $t = '0'.$t;
        }
        return($t);
    }


    if (!function_exists('splitx')) {
        function splitx($in, $string) {
            $string .= $in;
            $vr = array();
            while (strpos(' ' . $string, $in)) {
                $vp = strpos($string, $in);
                $v4 = trim(substr($string, 0, $vp));
                $string = trim(substr($string, $vp + 1, strlen($string)));
                if (strlen($v4) > 0) { array_push($vr, $v4);
                }
            }
            return ($vr);
        }

    }

    if (!function_exists('form_edit')) {
        /* Form Edit
        * @parameter $cp - campos de edicao
        * @parameter $tabela - nome da tabela que le/insere/atualiza registro
        * @paramrter $id - chave primaria do registro
        * @parameter $data - Dados do post inserir no controler: $data = $this->input->post();
        */



        function form_save($obj) {
            /* recupera post */
            /* Retorna se nao existir tabela */
            if (strlen($obj -> tabela) == 0) {
                return ('');
            }
            $CI = &get_instance();
            $post = $CI -> input -> post();

            $tabela = $obj -> tabela;
            $cp = $obj -> cp;
            $id = $obj -> id;

            /* Modo de gravacao */
            if (round($id) > 0) {
                /* Update */
                $sql = "update " . $tabela . " set ";
                $sv = 0;
                for ($r = 1; $r < count($cp); $r++) {
                    /* verifica se existe parametro */
                    $vlr = get('dd' . $r);
                    $cpt = $cp[$r][0];
                    /* Checkbox */
                    if (substr($cpt, 0, 3) == '$SW') {
                        if (strlen($vlr) == 0) { $vlr = '0';
                        }
                    }
                    /* Checkbox */
                    if (substr($cpt, 0, 2) == '$N') {
                        if (strlen($vlr) == 0) { $vlr = '0';
                        }
                        $vlr = troca($vlr, '.', '');
                        $vlr = troca($vlr, ',', '.');
                    }
                    /* Data */
                    if (substr($cpt, 0, 2) == '$D') {
                        $vlr = strzero(sonumero($vlr), 8);
                        $vlr = substr($vlr, 4, 4) . '-' . substr($vlr, 2, 2) . '-' . substr($vlr, 0, 2);
                    }
                    /* Excessoes */
                    if (isset($vlr)) {
                        /* Array */
                        if (is_array($vlr)) {
                            $vlr = serialize($vlr);
                        }

                        /* verefica se o campo na gravavel */
                        if (strlen($cp[$r][1]) > 0) {
                            if ($sv > 0) { $sql .= ', ';
                            }
                            $sql .= $cp[$r][1] . " = '" . $vlr . "' ";
                            $sv++;
                        }
                    }
                }
                $fld = $cp[0][1];
                $sql .= "where " . $fld . ' = ' . $id;
            } else {
                /* Insert */
                $sql = "insert into " . $tabela . " ";
                $sq1 = '';
                $sq2 = '';
                $sv = 0;
                for ($r = 1; $r < count($cp); $r++) {
                    /* verifica se existe parametro */
                    $vlr = $CI -> input -> post('dd' . $r);
                    $cpt = $cp[$r][0];
                    /* Checkbox */
                    if (substr($cpt, 0, 3) == '$SW') {
                        if (strlen($vlr) == 0) { $vlr = '0';
                        }
                    }
                    /* Checkbox */
                    if (substr($cpt, 0, 2) == '$N') {
                        if (strlen($vlr) == 0) { $vlr = '0';
                        }
                        $vlr = troca($vlr, '.', '');
                        $vlr = troca($vlr, ',', '.');
                    }
                    /* Data */
                    if (substr($cpt, 0, 2) == '$D') {
                        $vlr = strzero(sonumero($vlr), 8);
                        $vlr = substr($vlr, 4, 4) . '-' . substr($vlr, 2, 2) . '-' . substr($vlr, 0, 2);
                    }

                    /* Salvar */
                    if ((isset($vlr)) and (strlen($cp[$r][1]) > 0)) {

                        if ($sv > 0) { $sq1 .= ', ';
                            $sq2 .= ', ';
                        }
                        $sq1 .= $cp[$r][1];
                        if (is_array($vlr)) {
                            $vlr2 = '';
                            for ($rw = 0; $rw < count($vlr); $rw++) {
                                if (strlen($vlr2) > 0) { $vlr2 .= ';';
                                }
                                $vlr2 .= $vlr[$rw];
                            }
                            $vlr = $vlr2;
                        }
                        $vlr = troca($vlr, "'", "´");
                        $sq2 .= "'" . $vlr . "'";
                        $sv++;
                    }
                }
                $sql .= '(' . $sq1 . ') values (' . $sq2 . ')';
            }
            if ($sv == 0) { $sql = "";
            } else {
                $CI = &get_instance();
                $query = $CI -> db -> query($sql);
                return (1);
            }
            return (0);
        }

        function form_menu($id, $editar = FALSE, $excluir = FALSE) {
            $CI = &get_instance();
            $url_pre = uri_string();
            $url_edit = troca($url_pre, '/view', '/edit');
            $url_del = troca($url_pre, '/view', '/del');

            $link = '';

            if ($editar == TRUE) {
                $link_editar = base_url($url_edit);
                $link = '<A HREF="' . $link_editar . '" class="link lt0">' . $CI -> lang -> line('sisdocform_edit') . '</A>';
            }

            if ($excluir == TRUE) {
                $link_delete = base_url($url_del);
                $link .= ' | <A HREF="' . $link_delete . '" class="link lt0">' . $CI -> lang -> line('sisdocform_del') . '</A>';
            }
            return ($link);

        }

        function checkpost_link($id) {
            $chk = md5($id . date("Y") . '0917');
            return ($chk);
        }

        function checkpost($id, $chk1) {
            $chk2 = checkpost_link($id);
            if ($chk1 == $chk2) {
                return (1);
            } else {
                return (0);
            }
        }

        /*
        *
        * Le dados do banco
        */
        function le_dados($obj) {
            $id = $obj -> id;
            $tabela = $obj -> tabela;
            $fld = $obj -> cp[0][1];

            if ($id == 0) {
                return ( array());
            }

            $sql = "select * from " . $tabela . " where $fld = $id";
            $CI = &get_instance();
            $query = $CI -> db -> query($sql);
            $row = $query -> row();

            $cp = $obj -> cp;

            for ($r = 0; $r < count($cp); $r++) {
                $tp = $cp[$r][0];
                $fld = $cp[$r][1];

                if (substr($tp, 0, 2) == '$D') {
                    if (!isset($row -> $fld)) {
                        $vlr = '';
                    } else {
                        $vlr = $row -> $fld;
                    }

                    $vlr = trim(sonumero($vlr));
                    $vlr = substr($vlr, 6, 2) . '/' . substr($vlr, 4, 2) . '/' . substr($vlr, 0, 4);
                    if ($vlr == '00/00/0000') { $vlr = '';
                    }
                    if ($vlr == '//') { $vlr = '';
                    }
                    //if ($vlr == '') { $vlr = date("d/m/Y");
                        //}
                        if (strlen($fld) > 0) {
                            $row -> $fld = $vlr;
                        }
                    }
                    if (substr($tp, 0, 2) == '$N') {
                        if (!isset($row -> $fld)) {
                            $vlr = '';
                        } else {
                            $vlr = $row -> $fld;
                        }

                        if (strlen($vlr) > 0) {
                            $row -> $fld = number_format($vlr, 2, ',', '.');
                        } else {

                        }
                    }
                    if (substr($tp, 0, 2) == '$I') {
                        $fld = trim($cp[$r][1]);
                        if (strlen($fld) > 0) {
                            $row -> $fld = number_format($row -> $fld, 0, ',', '.');
                        }
                    }
                }
                return ($row);
            }

            function valida_post($cp) {
                /* recupera post */
                $CI = &get_instance();
                /* define como default */
                $saved = 1;
                $sx = '';
                for ($r = 0; $r < count($cp); $r++) {
                    $requer = $cp[$r][3];
                    if ($requer == true) {
                        $vlr = get('dd' . $r);
                        if (is_array($vlr)) {
                            if (count($vlr) == 0) {
                                $saved = 0;
                                $sx .= '<br>Erro: ' . $cp[$r][2] . '-' . $r;
                                $cp[$r][10] = '1';
                            }
                        } else {
                            if (strlen($vlr) == 0) { $saved = 0;
                                $sx .= '<br>Erro: ' . $cp[$r][2] . '-' . $r;
                                $cp[$r][10] = '1';
                            }
                        }
                    }
                }
                return ($saved);
            }

            function form_edit($obj) {
                $dd = array($obj -> id);
                $saved = 0;

                /* recupera post */
                $CI = &get_instance();
                $post = $CI -> input -> post();

                $cp = $obj -> cp;
                /* Recupera dados do banco */
                $recupera = 0;
                /* recupera ACAO do post */
                $acao = get("acao");

                if (strlen($acao) == 0) { $recupera = 1;
                }

                /* Save in table */
                if ($recupera == 0) {
                    /* Valida */
                    $saved = valida_post($cp);
                    if ($saved > 0) {
                        form_save($obj);
                    }
                }
                /***************** from open *****************/
                $attribute = array();
                for ($r = 0; $r < count($cp); $r++) {
                    $fld = $cp[$r][0];
                    if (($fld == '$SFILE') or ($fld == '$FILE')) {
                        $attribute['enctype'] = 'multipart/form-data';
                    }

                }

                $link = '';
                $tela = '';
                $tela .= form_open($link, $attribute) . '
                <table class="form_tabela2 table" width="100%">
                ';

                if ($recupera == 1) {

                    /* recupera dados do banco */
                    if (strlen($obj -> tabela) > 0) {
                        $data = le_dados($obj);
                    } else {
                        $recupera = 0;
                    }
                } else {
                    $data = array();
                }
                //$tela .= 'Recupera = ' . $recupera;

                for ($r = 0; $r < count($cp); $r++) {
                    /* Recupera dados */
                    $vlr = '';
                    if ($recupera == 1) {
                        /* banco de dados */
                        $fld = $cp[$r][1];
                        if (isset($data -> $fld)) {
                            $vlr = $data -> $fld;
                        }
                    } else {
                        $vlr = get('dd' . $r);
                    }
                    $tela .= form_field($cp[$r], $vlr);
                }
                $tela .= '</table>';
                $tela .= "
                <script>
                $(document).ready(function(){
                    $('.date').mask('00/00/0000');
                    $('.money').mask('000.000.000.000.000,00', {reverse: true});
                });
                </script>
                ";
                $tela .= form_close();

                $data = array('tela' => $tela, 'saved' => $saved);
                return ($data);
            }

            /* Botao novo */
            function form_botton_new($url, $txt = 'Novo registro') {
                $link = '<A HREF="' . $url . '/edit/0/' . checkpost_link('0') . '">';
                $sx = $link . '<span class="botton_new">' . $txt . '</span>' . '</A>';
                return ($sx);
            }

            /* Formulario */
            function form_field($cp, $vlr, $name = '', $table = 1, $return='') {
                global $dd, $ddi;
                /* Zera tela */
                $tela = '';

                if (!(isset($dd))) { $dd = array();
                    $ddi = 0;
                }

                $type = $cp[0];
                $label = $cp[2];
                $required = $cp[3];
                $placeholder = $label;
                $readonly = $cp[4];

                $tt = substr($type, 1, 1);

                /* exessoes */
                if (substr($type, 0, 3) == '$DM') { $tt = 'DM';}
                if (substr($type, 0, 3) == '$QC') { $tt = 'QC';}
                if (substr($type, 0, 3) == '$QR') { $tt = 'QR';}
                if (substr($type, 0, 4) == '$MES') { $tt = 'MES';}
                if (substr($type, 0, 3) == '$SN') { $tt = 'SN';}
                if (substr($type, 0, 3) == '$SW') { $tt = 'SW';}
                if (substr($type, 0, 3) == '$HV') { $tt = 'HV';}
                if (substr($type, 0, 5) == '$LINK') { $tt = 'LINK';}
                if (substr($type, 0, 6) == '$NOCAB') { $tt = 'NOCAB';}
                if (substr($type, 0, 3) == '$AA') { $tt = 'AA';}
                if (substr($type, 0, 3) == '$CM') { $tt = 'CM';}
                if (substr($type, 0, 5) == '$FILE') { $tt = 'FILE';}
                if (substr($type, 0, 6) == '$SFILE') { $tt = 'SFILE';}
                if (substr($type, 0, 3) == '$UF') { $tt = 'UF';}
                if (substr($type, 0, 4) == '$RDF') { $tt = 'RDF';}
                if (substr($type, 0, 5) == '$ERRO') { $tt = 'MSG_ERRO';}
                if (substr($type, 0, 5) == '$SUCE') { $tt = 'MSG_OK';}

                /* form */
                $max = 100;
                $size = 100;
                $dados = array();

                if (strlen($name) == 0) {
                    $dn = 'dd' . $ddi;
                } else {
                    $dn = $name;
                }

                if ($table == 1) {

                    if (strlen($label) == 0) {
                        $td = '<td colspan=2>';
                    } else {
                        $td = '<td>';
                    }
                    $tdl = '<td align="right" width="15%">';
                    $tdn = '</td>';

                    $tr = '<tr valign="top">';
                    $trn = '</tr>';
                } else {
                    $td = '';
                    $tdl = '';
                    $tdn = '';
                    $tr = '';
                    $trn = '';
                }

                //$dados = array('name'=>'dd'.$ddi, 'id'=>'dd'.$ddi,'value='.$dd[$ddi],'maxlenght'=>$max,'size'=>$size,$class=>'');
                switch ($tt) {
                    case '{' :
                        $tela .= $tr;
                        $tela .= '<td colspan=2>';
                        $tela .= '<fieldset class="border1 table"><legend class="lt3 bold">' . $label . '</legend>';
                        $tela .= '<table width="100%" class="table">';
                        $tela .= '<tr><td width="15%"></td><td width="85%"></td></tr>';
                    break;
                    case '}' :
                        $tela .= '</table>';
                        $tela .= '</fieldset>';
                        $tela .= '</td></tr>';
                        $tela .= '<table width="100%" id="row">';
                        $tela .= '</td></tr>';
                    break;
                    /* Select Box */
                    case '[' :
                        $ntype = trim(substr($type, 2, strlen($type)));
                        $n1 = substr($ntype, 0, strpos($ntype, '-'));
                        $n2 = sonumero(substr($ntype, strpos($ntype, '-'), strlen($ntype)));
                        $n3 = substr($ntype, strlen($ntype) - 1, 1);
                        /* Sem option */
                        if (strpos($ntype, 'U') > 0) {

                        } else {
                            $options = array('' => msg('::select an option::'));
                        }

                        if ($n3 != 'D') {
                            /* Crescente */
                            for ($r = $n1; $r <= $n2; $r++) {
                                $options[$r] = $r;
                            }
                        } else {
                            /* Descrecente */
                            for ($r = $n2; $r >= $n1; $r--) {
                                $options[$r] = $r;
                            }
                        }

                        /* recupera dados */
                        $dados = array('name' => $dn, 'id' => $dn, 'size' => 1, 'class' => 'form-control ');

                        $tela .= $tr;

                        /* label */
                        if (strlen($label) > 0) {
                            $tela .= $tdl . $label . ' ';
                        }
                        if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                        }
                        $tela .= $td;
                        $tela .= form_dropdown($dados, $options, $vlr);
                    break;

                    /* Caption - Header*/
                    case 'A' :
                        if (strlen($label) > 0) {
                            /* TR da tabela */
                            $tela .= $tr;
                            $nr = round(sonumero($type));
                            if ($nr < 1) { $nr = '3';
                            }

                            if (substr($tdl, 0, 3) == '<td') {
                                $tdd = '<td colspan=2 align="left">';
                                $tela .= $tdd . '<h' . $nr . '>' . $label . '</h' . $nr . '> ';
                            }
                        }
                    break;

                    /* Select Box - Autocomplete*/
                    case 'AA' :
                        $ntype = trim(substr($type, 2, strlen($type)));
                        $ntype = troca($ntype, ':', ';') . ';';
                        $param = splitx(';', $ntype);

                        /* TR da tabela */
                        $tela .= $tr;

                        /* label */
                        if (strlen($label) > 0) {
                            $tela .= $tdl . $label . ' ';
                        }
                        if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                        }
                        /* **/
                        $dados = array('name' => $dn . 'a', 'id' => $dn . 'a', 'value' => $vlr, 'maxlenght' => $max, 'size' => $size, 'placeholder' => $label, 'class' => 'form_string ', 'autocomplete' => 'on');
                        $tela .= $td . form_input($dados);

                        $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => $max, 'size' => 10, 'placeholder' => $label, 'class' => 'form_string ', 'autocomplete' => 'on');
                        if ($readonly == false) { $dados['readonly'] = 'readonly';
                        }
                        $tela .= form_input($dados);

                        $tela .= $tdn . $trn;

                        $tela .= '
                        <script>
                        $(function(){
                            var $sfield = $("#' . $dn . 'a").autocomplete({
                                source: function(request, response){
                                    var url = "' . base_url("index.php/instituicao/autocomplete?term=") . '" + $("#' . $dn . 'a").val();
                                    $.get(url, {},
                                    function(data)
                                    {
                                        response($.map(data, function(rlt)
                                        {
                                            return { label: rlt.nome, value: rlt.id };
                                        }));
                                    }, "json");
                                },
                                select: function( event, ui ) {
                                    $( "#' . $dn . 'a" ).val( ui.item.label );
                                    $( "#' . $dn . '" ).val( ui.item.value );
                                    return false;
                                } , minLength: 4, autofocus: true });
                            });
                            </script>
                            ';
                        break;
                        /* Button */
                        case 'B' :
                            IF (strlen($label) > 0) {
                                $tela .= $tr . $tdl . $td;
                                $dados = array('name' => 'acao', 'id' => 'acao', 'value' => $label, 'class' => 'form_submit btn btn-primary');

                                if (isset($_POST['return']) > 0)
                                {
                                    $label = msg("return");
                                    $tela .= '<a href="'.$_POST['return'].'" class="form_submit btn btn-outline-warning">'.msg('return').'</a> '.cr();
                                }
                                $tela .= form_submit($dados);
                                $tela .= $tdn . $trn;
                            } else {
                                $vlr = $cp[2];
                                $dados = array($dn => $vlr);
                                $tela .= '<input type="hidden" name="acao" id="acao" value="submit">' . cr();
                                if (isset($_POST['return']) > 0)
                                {
                                    $label = msg("return");
                                    $tela .= ' <a href="'.$_POST['return'].'" class="form_submit btn btn-outline-warning">'.msg('return').'</a>'.cr();
                                }
                            break;
                        }
                    break;
                    case 'C' :
                        /* TR da tabela */
                        $tela .= $tr;

                        $dados = array('name' => $dn, 'id' => $dn, 'value' => '1', 'class' => 'form_checkbox ');
                        if ($readonly == false) { $dados['readonly'] = 'readonly';
                        }
                        $tela .= '<td align="right">' . form_checkbox($dados, 'accept', $vlr);
                        ;

                        /* label */
                        if (strlen($label) > 0) {
                            $tela .= '<td>' . $label . ' ';
                        }
                        if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                        }
                        $tela .= $tdn . $trn;
                    break;

                    /* Select Box */
                    case 'CM' :
                        $ntype = trim(substr($type, 3, strlen($type)));
                        $ntype = troca($ntype, '&', ';') . ';';
                        $param = splitx(';', $ntype);

                        $tela .= $tr;

                        /* label */
                        if (strlen($label) > 0) {
                            $tela .= $tdl . $label . ' ';
                        }
                        if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                        }

                        /* TR da tabela */
                        $tela .= '<td align="left">';
                        $vlr = splitx(';', $vlr . ';');

                        if (is_array($vlr)) {

                        } else {
                            $vlr = array();
                        }
                        for ($r = 0; $r < count($param); $r++) {
                            if (count(trim($param[$r])) > 0) {
                                $nterm = splitx(':', $param[$r] . ':');
                                $key = $nterm[0];
                                $valor = $nterm[1];
                                $check = '';
                                for ($rx = 0; $rx < count($vlr); $rx++) {
                                    if ($vlr[$rx] == $key) { $check = 'checked';
                                    }
                                }
                                $tela .= '<input type="checkbox" name="' . $dn . '[]" id="' . $dn . '" value="' . $key . '" ' . $check . '>' . $valor . '<br>';
                            }
                        }
                        $tela .= '<br>';
                    break;
                    /* File */
                    case 'FILE' :
                        $tela .= $tr;
                        if (isset($_FILES['tmp_name']))
                        {
                            $vlr = $_FILES['tmp_name'];
                        }


                        /* Simple Submit File */
                        case 'SFILE' :
                            $tela .= $tr;
                            $tela .= '<input type="file" name="fileToUpload" id="fileToUpload">';

                            /* Oculto */
                            case 'H' :
                                $dados = array($dn => $vlr);
                                $tela .= form_hidden($dados);
                            break;

                            /* Oculto */
                            case 'NOCAB' :
                                $dados = array($dn => $vlr);
                                $tela .= '<input type="hidden" name="nocab" id="nocab" value="true">' . cr();
                            break;

                            case 'HV' :
                                $vlr = $cp[2];
                                $dados = array($dn => $vlr);
                                $tela .= '<input type="hidden" name="' . $dn . '" id="' . $dn . '" value="' . $vlr . '">' . cr();
                            break;

                            /* Select Box - Mes */
                            case 'MES' :
                                $options = array('' => msg('::select an option::'));

                                /* recupera dados */
                                for ($r = (date("Y") + 4); $r > 1990; $r--) {
                                    $vlra = $r;
                                    $options[$vlra] = '===' . $r . '===';
                                    //array_push($options,array('2019'));
                                    $ar = array();
                                    for ($y = 12; $y > 0; $y--) {
                                        $vlrs = $r . strzero($y, 2) . '01';
                                        $cpt = $r . '/' . msg('mes_' . strzero($y, 2));
                                        $op = array($vlr => $cpt);
                                        $ar[$vlrs] = $cpt;
                                        //array_push($options,$op);
                                    }
                                    $options[$vlra] = $ar;
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'size' => 1, 'class' => 'form_select  ');
                                $tela .= $tr;
                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                if (strlen($vlr) == 0) { $vlr = date("Ym") . '01';
                                } else {
                                    $vlr = sonumero($vlr);
                                }
                                $tela .= '<TD>';
                                $tela .= form_dropdown($dados, $options, $vlr);
                            break;

                            case 'MSG_ERRO' :
                                if (strlen($label) > 0) {
                                    $tela .= $tr;
                                    $tela .= '</br>
                                    <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    ERRO: <span class="sr-only">Error:</span>
                                    ' . $label . '
                                    </div>';
                                }
                            break;
                            case 'MSG_OK' :
                                if (strlen($label) > 0) {
                                    $tela .= $tr;
                                    $tela .= '</br>
                                    <div class="alert alert-success" role="alert">
                                    <span class="sr-only">Sucesso:</span>
                                    OK: ' . $label . '
                                    </div>';
                                }
                            break;

                            /* Select Box */
                            case 'SN':
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $size = sonumero($type);

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => $max, 'size' => $size, 'placeholder' => $label, 'class' => 'form-control form_string form_s' . $size, 'style' => 'width: 80px;');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $options = array(1=>msg('Yes'),0=>msg('No'));
                                $tela .= $td . form_dropdown($dados, $options, $vlr);
                                $tela .= $tdn . $trn;
                            break;

                            /********************** OPTIONS ************************************************/
                            case 'O' :
                                $ntype = trim(substr($type, 2, strlen($type)));
                                $ntype = troca($ntype, '&', ';') . ';';
                                $param = splitx(';', $ntype);

                                $options = array('' => msg('::select an option::'));
                                for ($r = 0; $r < count($param); $r++) {
                                    if (strlen(trim($param[$r])) > 0) {
                                        $nterm = splitx(':', $param[$r] . ':');
                                        if (isset($nterm[0])) {
                                            $key = $nterm[0];
                                            $valor = $nterm[1];
                                            $options[$key] = $valor;
                                        }
                                    }
                                }

                                /* recupera dados */
                                $dados = array('name' => $dn, 'id' => $dn, 'size' => 1, 'class' => 'form-control  ');

                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<TD>';
                                $tela .= form_dropdown($dados, $options, $vlr);
                            break;

                            /* Select Box */
                            case 'Q' :
                                $ntype = trim(substr($type, 2, strlen($type)));
                                $ntype = troca($ntype, ':', ';') . ';';
                                $param = splitx(';', $ntype);
                                $options = array('' => msg('::select an option::'));

                                /* recupera dados */
                                $sql = "select * from (" . $param[2] . ") as tabela order by " . $param[1];
                                $CI = &get_instance();
                                $query = $CI -> db -> query($sql);
                                foreach ($query->result_array() as $row) {
                                    /* recupera ID */
                                    $flds = trim($param[0]);
                                    $vlrs = trim($param[1]);
                                    $flds = $row[$flds];
                                    $vlrs = $row[$vlrs];
                                    $options[$flds] = $vlrs;
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'size' => 1, 'class' => 'form-control  ');

                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<TD>';
                                $tela .= form_dropdown($dados, $options, $vlr);
                            break;

                            /* String */
                            /* Multiple CheckBox */
                            case 'QC' :
                                $ntype = trim(substr($type, 3, strlen($type)));
                                $ntype = troca($ntype, ':', ';') . ';';
                                $param = splitx(';', $ntype);
                                $options = array('' => msg('::select an option::'));

                                /* recupera dados */
                                $sql = "select * from (" . $param[2] . ") as tabela order by " . $param[1];
                                $CI = &get_instance();
                                $query = $CI -> db -> query($sql);
                                $form = '';
                                $ct = 0;
                                foreach ($query->result_array() as $row) {
                                    /* recupera ID */
                                    $flds = trim($param[0]);
                                    $vlrs = trim($param[1]);
                                    $flds = $row[$flds];
                                    $vlrs = $row[$vlrs];
                                    $options[$flds] = $vlrs;
                                    $checked = '';
                                    $dnn = $dn.chr(97+$ct);
                                    $dnn = $dn;
                                    if (strlen(get($dnn)) > 0) { $checked = 'checked'; }
                                    $form .= '<input type="checkbox" name="'.$dnn.'[]" value="'.$flds.'">'.$vlrs.'<br>';
                                    $ct++;
                                }
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<TD>';
                                $tela .= $form;
                            break;

                            /* Select Box */
                            case 'QR' :
                                $ntype = trim(substr($type, 3, strlen($type)));
                                $ntype = troca($ntype, ':', ';') . ';';
                                $param = splitx(';', $ntype);
                                $options = array('' => msg('::select an option::'));

                                /* recupera dados */
                                $sql = "select * from (" . $param[2] . ") as tabela order by " . $param[1];
                                $CI = &get_instance();
                                $query = $CI -> db -> query($sql);
                                $form = '';
                                foreach ($query->result_array() as $row) {
                                    /* recupera ID */
                                    $flds = trim($param[0]);
                                    $vlrs = trim($param[1]);
                                    $flds = $row[$flds];
                                    $vlrs = $row[$vlrs];
                                    $options[$flds] = $vlrs;
                                    $checked = '';
                                    //$dados = array('name' => $dn, 'id' => $dn, 'value' => $flds, 'class' => 'form-control  ', 'checked' => $checked);
                                    $dados = array('name' => $dn, 'id' => $dn, 'value' => $flds, 'checked' => $checked);
                                    $form .= form_radio($dados) . ' ' . $vlrs . '<br>';
                                }

                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<TD>';
                                $tela .= $form;
                            break;

                            /* String */
                            case 'R' :
                                $ntype = trim(substr($type, 2, strlen($type)));
                                $ntype = troca($ntype, '&', ';') . ';';
                                $param = splitx(';', $ntype);
                                $form = '';

                                for ($r = 0; $r < count($param); $r++) {
                                    if (strlen(trim($param[$r])) > 0) {
                                        $nterm = splitx(':', $param[$r] . ':');
                                        $key = $nterm[0];
                                        $valor = $nterm[1];
                                        $options[$key] = $valor;
                                        $checked = false;
                                        if ($key == $vlr) { $checked = true;
                                        }
                                        $dados = array('name' => $dn, 'id' => $dn, 'value' => $key, 'class' => 'form_select  ', 'checked' => $checked);
                                        if (strlen($form) > 0) { $form .= '<br>' . cr();
                                        }
                                        $form .= form_radio($dados);
                                        $form .= '' . $valor;
                                    }
                                }
                                $form .= '';

                                /* recupera dados */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= '<td colspan="2">' . $label . '</td>';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<tr><td></td><TD>';
                                //$tela .= form_radio($dados, $options, $vlr);
                                $tela .= $form;
                            break;

                            /* String */
                            case 'D' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => 12, 'size' => 12, 'placeholder' => $label, 'class' => 'form_string date');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $tela .= $td . form_input($dados) . ' (dd/mm/yyyy)';
                                $tela .= $tdn . $trn;
                                $tela .= '
                                <script>
                                $(function() {
                                    $( "#' . $dn . '" ).datepicker();
                                });
                                </script>
                                ';
                            break;

                            /* String */
                            case 'DM' :
                                /* TR da tabela */
                                //$tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => 1, 'size' => 1, 'placeholder' => $label, 'class' => 'form_string ');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $year = date("Y");
                                $month = date("m");
                                for ($r=0;$r < 48;$r++)
                                    {
                                        $mes = $year.'/'.strzero($month,2);
                                        $options[$mes] = $mes;
                                        $month--;
                                        if ($month == 0)
                                            {
                                                $month = 12;
                                                $year--;
                                            }
                                    }

                                $tela .= $td . form_dropdown($dados, $options, $vlr);
                                $tela .= $tdn;
                                //$tela .= $trn;

                            break;

                            /* String */
                            case 'LINK' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => $max, 'size' => $size, 'placeholder' => $label, 'class' => 'form_string  ');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $tela .= $td . form_input($dados);
                                $tela .= $tdn . $trn;
                            break;

                            case 'M' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                $tela .= '<td colspan=2>' . '<span class="lt1">' . $label . '</span>';
                                $tela .= $tdn . $trn;
                            break;

                            /* form_number */
                            case 'N' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => 15, 'size' => 15, 'placeholder' => $label, 'class' => 'form_string money');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $tela .= $td . form_input($dados);
                                $tela .= $tdn . $trn;
                            break;
                            case 'I' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => 15, 'size' => 15, 'placeholder' => $label, 'class' => 'form_string number');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $tela .= $td . form_input($dados);
                                $tela .= $tdn . $trn;
                            break;

                            /* Password */
                            case 'P' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => $max, 'size' => $size, 'class' => 'form-control ');
                                $tela .= $td . form_password($dados);
                                $tela .= $tdn . $trn;
                            break;

                            /* String */
                            case 'S' :
                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $size = sonumero($type);

                                $dados = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'maxlenght' => $max, 'size' => $size, 'placeholder' => $label, 'class' => 'form-control form_string form_s' . $size, 'style' => 'width: ' . $size . '%;');
                                if ($readonly == false) { $dados['readonly'] = 'readonly';
                                }
                                $tela .= $td . form_input($dados);
                                $tela .= $tdn . $trn;
                            break;

                            /* RDF */
                            case 'RDF' :
                                $ntype = trim(substr($type, 4, strlen($type)));
                                $ntype = troca($ntype, ':', ';') . ';';
                                $param = splitx(';', $ntype);
                                $options = array('' => msg('::select an option::'));

                                /* recupera dados */
                                $sql = "select * from rdf as tabela
                                where rdf_class = '" . $param[0] . "'
                                order by rdf_value";
                                $CI = &get_instance();
                                $query = $CI -> db -> query($sql);
                                foreach ($query->result_array() as $row) {
                                    /* recupera ID */
                                    $flds = $row['rdf_resource'];
                                    $vlrs = $row['rdf_value'];
                                    $options[$flds] = $vlrs;
                                }

                                $dados = array('name' => $dn, 'id' => $dn, 'size' => 1, 'class' => 'form-control  ');

                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<TD>';
                                $tela .= form_dropdown($dados, $options, $vlr);
                            break;

                            case 'SW' :
                                {
                                    /* TR da tabela */
                                    $tela .= $tr;
                                    $checked = False;
                                    /* label */
                                    $tela .= ' <td class="lt4" colspan=2>
                                    <table>
                                    <tr>
                                    <td>
                                    <div class="onoffswitch">
                                    ';
                                    /* cehcked */
                                    if (trim($vlr) == '1') { $checked = True;
                                    }

                                    /* Monta lista */
                                    $data = array('name' => $dn, 'checked' => $checked, 'class' => 'onoffswitch-checkbox', 'id' => $dn, 'value' => '1');
                                    $tela .= form_checkbox($data);
                                    $tela .= ' <label class="onoffswitch-label" for="' . $dn . '"> <span class="onoffswitch-inner"></span> <span class="onoffswitch-switch"></span> </label>
                                    </div></td><td class="lt2"> ' . $label . ' </td>
                                    </tr>
                                    </table></td></tr>';
                                }
                            break;

                            /* Estado */
                            case 'UF' :
                                $options = array('' => msg('::select an option::'), "PR" => "Paraná", "AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraíba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RS" => "Rio Grande do Sul", "RR" => "Roraima", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");

                                /* recupera dados */
                                $dados = array('name' => $dn, 'id' => $dn, 'size' => 1, 'class' => 'form_select  ');

                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }
                                $tela .= '<TD>';
                                $tela .= form_dropdown($dados, $options, $vlr);
                            break;

                            /* Update */
                            case 'U' :
                                if (round($vlr) == 0) { $vlr = date("Y-m-d");
                                }
                                $dados = array($dn => $vlr);
                                $tela .= form_hidden($dados);
                            break;

                            /* Textarea */
                            case 'T' :
                                $ntype = trim(substr($type, 2, strlen($type)));
                                $ntype = troca($ntype, ':', ';') . ';';
                                $param = splitx(';', $ntype);

                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $data = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'rows' => $param[1], 'cols' => $param[0], 'class' => 'form-control form_textarea ');
                                $tela .= $td . form_textarea($data);
                                $tela .= $tdn . $trn;
                            break;
                            /* Password */
                            case 'V' :
                                /* TR da tabela */
                                $tela .= $tr;
                                $tela .= $td . msg('validation');
                                $tela .= '<td>';
                                $CI = &get_instance();
                                $cmd = '$rs = ' . $cp[2];
                                $tela .= '</td>';
                                $tela .= '</tr>';
                                eval($cmd);
                                /* retorno */
                                $tela .= $rs[1];
                                $validate = $rs[0];
                                if ($validate == 0) { $validate = '';
                                }
                                $dados = array($dn => $validate);
                                $tela .= form_hidden($dados);

                            break;
                            /* Textarea */
                            case 'W' :
                                $ntype = trim(substr($type, 2, strlen($type)));
                                $ntype = troca($ntype, ':', ';') . ';';
                                $param = splitx(';', $ntype);
                                if (!isset($param[1])) { $param[1] = 10; }
                                if (!isset($param[0])) { $param[0] = 80; }

                                /* TR da tabela */
                                $tela .= $tr;

                                /* label */
                                if (strlen($label) > 0) {
                                    $tela .= $tdl . $label . ' ';
                                }
                                if ($required == 1) { $tela .= ' <font color="red">*</font> ';
                                }

                                $data = array('name' => $dn, 'id' => $dn, 'value' => $vlr, 'rows' => $param[1], 'cols' => $param[0], 'class' => 'form-control form_textarea ');
                                $tela .= $td . form_textarea($data);
                                $tela .= $tdn . $trn;

                                $tela = '<script src="'.base_url('js/ckeditor/ckeditor.js').'"></script>'.cr();
                                $tela .= '<textarea name="'.$dn.'" id="'.$dn.'" rows="10" cols="80">'.$vlr.'</textarea>'.cr();
                                $tela .= '
                                <script>
                                CKEDITOR.replace( \''.$dn.'\' );
                                </script>';


                            break;
                        }
                        $ddi++;
                        return ($tela);
                    }

                    //Define a callback and pass the format of date
                    function valid_date($date, $format = 'Y-m-d') {
                        $d = DateTime::createFromFormat($format, $date);
                        //Check for valid date in given format
                        if ($d && $d -> format($format) == $date) {
                            return true;
                        } else {
                            $this -> form_validation -> set_message('valid_date', 'The %s date is not valid it should match this (' . $format . ') format');
                            return false;
                        }
                    }

                    function mask_fone($fone) {
                        $fone = sonumero($fone);
                        $fone_m = $fone;
                        if (strlen($fone) <= 8) {
                            $fone_m = substr($fone, 0, 4) . '.' . substr($fone, 4, 4);
                        }
                        if (strlen($fone) == 9) {
                            $fone_m = substr($fone, 0, 5) . '.' . substr($fone, 5, 4);
                        }
                        if ((strlen($fone) > 9) and (strlen($fone) < 13)) {
                            $fone_m = '(' . substr($fone, 0, 2) . ')' . substr($fone, 2, 4) . '.' . substr($fone, 6, 5);
                        }
                        return ($fone_m);
                    }

                    function mask_cep($cep) {
                        $cep = strzero(sonumero($cep), 8);
                        $cep = substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5, 3);
                        return ($cep);
                    }

                    function name_weekday($day) {
                        $wk = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
                        $day = round($day);
                        if ($day > 6) { $day = 0;
                        }
                        return ($wk[$day]);
                    }

                    function hex_dump($data, $newline = "\n") {
                        $sx = '';
                        static $from = '';
                        static $to = '';

                        static $width = 32;
                        # number of bytes per line

                        static $pad = '.';
                        # padding for non-visible characters

                        if ($from === '') {
                            for ($i = 0; $i <= 0xFF; $i++) {
                                $from .= chr($i);
                                $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
                            }
                        }

                        $hex = str_split(bin2hex($data), $width * 2);
                        $chars = str_split(strtr($data, $from, $to), $width);

                        $offset = 0;
                        foreach ($hex as $i => $line) {
                            $sx .= sprintf('%6X', $offset) . ' : ' . implode(' ', str_split($line, 2)) . ' [' . $chars[$i] . ']' . $newline;
                            $offset += $width;
                        }
                        return ($sx);
                    }

                }

                function trata_nome($name) {
                    for ($r = 0; $r <= 31; $r++) {
                        $name = troca($name, chr($r), ' ');
                    }
                    while (strpos($name, '  ')) {
                        $name = troca($name, '  ', ' ');
                    }
                    $name = trim($name);
                    return ($name);
                }

                function read_link($url) {
                    global $CI;
                    $dt = $CI -> config -> config;
                    if (isset($dt['readfile'])) {
                        $read = $dt['readfile'];
                    } else {
                        $read = 'CURL';
                    }
                    //$read = 'file';
                    //echo '<h1>'.$read.'</h1>';
                    //exit;
                    switch ($read) {
                        case 'file' :
                            if (substr($url,0,4) == 'http')
                            {
                                $headers = get_headers($url);
                                $sta = sonumero($headers[0]);
                                $sta = substr($sta,strlen($sta)-3,3);
                            } else {
                                $sta = '200';
                            }

                            if ($sta != '404')
                            {
                                $contents = file_get_contents($url);
                            } else {
                                $contents = '';
                            }
                        break;

                        /******************************************************** CURL ******************/
                        default :
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        $data = curl_exec($curl);
                        curl_close($curl);
                        return ($data);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        //curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);

                        $contents = curl_exec($ch);
                        if (curl_errno($ch)) {
                            echo curl_error($ch);
                            echo "\n<br />";
                            $contents = '';
                        } else {
                            curl_close($ch);
                        }
                        if (!is_string($contents) || !strlen($contents)) {
                            echo "Failed to get contents.";
                            $contents = '';
                        }
                        if (strpos($contents, 'encoding="UTF-8"') > 0) {
                            $contents = troca($contents, 'encoding="UTF-8"', 'encoding="ISO-8859-1"');
                            $contents = utf8_decode($contents);
                        }
                    break;
                }
                return ($contents);
            }



            function convert($t) {
                $t .= ' ';
                /**** PT-BR ****/
                $a = array(' às ' => ' à ', ' ás ' => ' à ', ' as' => ' a', ' os' => ' o', ' Os' => ' o', ' As' => ' a', ' aos' => ' ao', 'aces' => 'ace', 'ais' => 'al', 'aos' => 'ao', 'afos' => 'afo', 'ãos' => 'ao', 'ães' => 'ão', 'ares' => 'ar', 'ubes' => 'ube', 'bês' => 'bê', 'bens' => 'bem', 'Bens' => 'Bem', 'Boas' => 'Boa', 'blemas' => 'blema', 'boas' => 'boa', 'cas' => 'ca', 'cias' => 'cia', 'cies' => 'cie', 'cios' => 'cio', 'chas' => 'cha', 'cas' => 'ca', 'cos' => 'co', 'ços' => 'ço', 'ças' => 'ça', 'çõs' => 'ção', 'ças' => 'ça', 'coes' => 'cao', 'ções' => 'ção', 'dados' => 'dado', 'des' => 'de', 'dios' => 'dio', 'deos' => 'deo', 'dos' => 'do', 'das' => 'da', 'dias' => 'dia', 'nios' => 'nio', 'dores' => 'dor', 'eias' => 'eia', 'eis' => 'el', 'eios' => 'eio', 'fas' => 'fa', 'fias' => 'fia', 'fías' => 'fia', 'fins' => 'fim', 'Fins' => 'Fim', 'fis' => 'fil', 'fios' => 'fio', 'gens' => 'gem', 'gias' => 'gia', 'gios' => 'gio', 'gos' => 'go', 'guas' => 'gua', 'gos' => 'go', 'iais' => 'ial', 'ioes' => 'iao', 'ões' => 'ão', 'ices' => 'ice', 'jos' => 'jo', 'jós' => 'jó', 'leis' => 'lei', 'lhos' => 'lho', 'lhas' => 'lha', 'las' => 'la', 'les' => 'le', 'leos' => 'leo', 'los' => 'lo', 'lores' => 'lor', 'mas' => 'ma', 'mes' => 'me', 'mias' => 'mia', 'mías' => 'mía', 'mos' => 'mo', 'mulas' => 'mula', 'nas' => 'na', 'nes' => 'ne', 'nos' => 'no', 'nhas' => 'nha', 'nhos' => 'nho', 'nais' => 'nal', 'nias' => 'ina', 'pias' => 'pia', 'pas' => 'pa', 'pes' => 'pe', 'pios' => 'pio', 'pos' => 'po', 'quais' => 'qual', 'ques' => 'que', 'ras' => 'ra', 'res' => 're', 'ros' => 'ro', 'rais' => 'ral', 'reas' => 'rea', 'rias' => 'ria', 'rías' => 'ria', 'rios' => 'rio', 'rois' => 'rol', 'ros' => 'ro', 'roes' => 'rao', 'soes' => 'sao', 'sas' => 'sa', 'ses' => 'se', 'temas' => 'tema', 'seus' => 'sel', 'sos' => 'so', 'soas' => 'soa', 'tas' => 'ta', 'tes' => 'te', 'tens' => 'tem', 'tins' => 'tim', 'tios' => 'tio', 'tras' => 'tra', 'toes' => 'tao', 'tos' => 'to', 'uais' => 'ual', 'uias' => 'uia', 'uns' => 'um', 'vas' => 'va', 'ves' => 've', 'veis' => 'vel', 'vis' => 'vil', 'vos' => 'vo', 'xos' => 'xo', 'xoes' => 'xao', 'zes' => 'z', );
                foreach ($a as $key => $value) {
                    $t = troca($t, $key . ' ', $value . ' ');
                }

                while (strpos($t, '  ')) {
                    $t = troca($t, '  ', ' ');
                }

                $t = trim($t);

                return ($t);
            }

            function ucase($t) {
                $t = trim($t);
                $t = ucwords($t);
                $t = troca($t, ' A ', ' a ');
                $t = troca($t, ' Ao ', ' ao ');
                $t = troca($t, ' E ', ' e ');
                $t = troca($t, ' O ', ' o ');
                $t = troca($t, ' Com ', ' com ');
                $t = troca($t, ' Em ', ' em ');
                $t = troca($t, ' Na ', ' na ');
                $t = troca($t, ' No ', ' no ');
                $t = troca($t, ' Da ', ' da ');
                $t = troca($t, ' Das ', ' das ');
                $t = troca($t, ' De ', ' de ');
                $t = troca($t, ' Do ', ' do ');
                $t = troca($t, ' Nas ', ' no ');
                $t = troca($t, ' Nos ', ' no ');
                $t = troca($t, ' Para ', ' para ');
                $t = troca($t, ' Por ', ' por ');
                $t = troca($t, ' Dos ', ' dos ');
                $t = troca($t, ' Of ', ' of ');
                $t = troca($t, ' Ou ', ' ou ');

                /* SPANISH */
                $t = troca($t, ' Las ', ' la ');
                $t = troca($t, ' Los ', ' lo ');
                $t = troca($t, ' La ', ' la ');

                /* ENGLISH */
                $t = troca($t, ' The ', ' the ');
                $t = troca($t, ' At ', ' at ');
                $t = troca($t, ' And ', ' and ');
                $t = troca($t, ' For ', ' for ');
                $t = troca($t, ' To ', ' to ');
                $t = troca($t, ' In ', ' in ');
                $t = troca($t, ' On ', ' on ');
                $t = troca($t, ' On ', ' on ');

                $t = troca($t, 'cs ', 'c ');
                $t = troca($t, 'ces ', 'ce ');
                $t = troca($t, 'cles ', 'cle ');
                $t = troca($t, 'ems ', 'em ');
                $t = troca($t, 'ges ', 'ge ');
                $t = troca($t, 'isms ', 'ism ');
                $t = troca($t, 'ians ', 'iam ');

                $t = troca($t, 'ions ', 'iom ');
                $t = troca($t, 'nes ', 'ne ');
                $t = troca($t, 'oups ', 'oup ');
                $t = troca($t, 'ries ', 'ry ');
                $t = troca($t, 'tals ', 'tal ');
                $t = troca($t, 'ties ', 'ty ');
                $t = troca($t, 'umns ', 'umn ');
                $t = troca($t, 'yses ', 'ys ');
                $t = troca($t, 'ysis ', 'ys ');

                /************** Espanol ************/
                $t = troca($t, ' En ', ' en ');

                return ($t);
            }

            function form_focus($id)
            {
                $sx = '<script>';
                $sx .= '$("#'.$id.'").focus();';
                $sx .= '</script>';
                return($sx);
            }

            function dias_mes($mes,$year='')
                {
                if ($year == '') { $year = date("Y"); }
                $dias = 31;
                $mes = round($mes);
                if (($mes == 4) or ($mes == 6) or ($mes == 4) or ($mes == 9) or ($mes == 11))
                    {
                        $dias = 30;
                    }
                if ($mes == 2)
                    {
                        $dias = 28;
                        if (round($year/4) == ($year / 4)) { $dias++; }
                    }
                return($dias);
                }
            ?>
