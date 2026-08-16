<?php
namespace App\Models;

use CodeIgniter\Model;

class LabelModel extends Model
{
    protected $table = 'labels';
    protected $primaryKey = 'id_label';
    protected $allowedFields = [
        'nome',
        'instituicao',
        'status',
    ];
    protected $returnType = 'array';
}