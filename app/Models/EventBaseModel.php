<?php
namespace App\Models;

use CodeIgniter\Model;

class EventBaseModel extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'id_e';
    protected $allowedFields = [
        'e_name',
        'e_url',
        'e_description',
        'e_active',
        'e_logo',
        'e_data_i',
        'e_data_f',
        'e_sigin_until',
        'e_background',
        'e_assinatura',
        'e_cidade',
    ];
    protected $returnType = 'array';
}
