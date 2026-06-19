<?php
namespace App\Models;

use CodeIgniter\Model;

class EventPermissionModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'event_permissions';
    protected $primaryKey = 'id_ep';
    protected $allowedFields = [
        'ep_event_id',
        'ep_user_id',
        'ep_can_manage',
        'ep_created',
    ];
    protected $returnType = 'array';
}