<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormHistory extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'form_history_id' => [
        'type' => 'INT',
        'auto_increment' => true,
        'null' => false,
      ],
      'form_id' => [
        'type' => 'INT',
        'null' => false,
      ],
      'form_version' => [
        'type' => 'decimal(10,1)',
        'null' => false,
      ],
      'form_fields' =>[
        'type' => 'TEXT',
        'null' => true,
      ],
    ]); 

    $this->forge->addKey('form_history_id', true);
    $this->forge->addForeignKey('form_id', 'Forms', 'form_id', '', 'CASCADE');
    $this->forge->createTable('FormHistory');
  }

  public function down()
  {
    $this->forge->dropTable('FormHistory'); 
  }
}
