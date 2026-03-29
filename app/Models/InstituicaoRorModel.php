<?php
namespace App\Models;

use CodeIgniter\Model;

class InstituicaoRorModel extends Model
{
    protected $table = 'instituicoes_ror';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome'];
    protected $returnType = 'array';
}
