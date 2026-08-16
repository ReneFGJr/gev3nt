<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLabelsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_label' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'instituicao' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id_label', true);
        $this->forge->addKey('nome');
        $this->forge->addKey('status');
        $this->forge->createTable('labels');
    }

    public function down()
    {
        $this->forge->dropTable('labels', true);
    }
}