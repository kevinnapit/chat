<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsOnlineToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'is_online' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'is_online');
    }
}
