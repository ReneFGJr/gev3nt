<?php

namespace App\Models;

use CodeIgniter\Model;

class ChapaModel extends Model
{
	protected $table = 'chapas';
	protected $primaryKey = 'id_chapa';
	protected $allowedFields = ['nome', 'descricao'];
}
