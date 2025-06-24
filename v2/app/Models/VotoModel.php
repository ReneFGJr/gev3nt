<?php

namespace App\Models;

use CodeIgniter\Model;

class VotoModel extends Model
{
	protected $table = 'votos';
	protected $primaryKey = 'id_voto';
	protected $allowedFields = ['id_socio', 'id_chapa'];
}
