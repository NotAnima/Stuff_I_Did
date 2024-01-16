<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Forms extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'form_id' => [
        'type' => 'INT',
        'auto_increment' => true,
        'null' => false,
      ],
      'form_name' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => false,
        'unique' => true,
      ],
      'form_description' => [
        'type' => 'TEXT',
        'null' => true,
      ],
      'form_fields' =>[
        'type' => 'TEXT',
        'null' => true,
      ],
      'form_version' => [
        'type' => 'FLOAT',
        'null' => false,
        'default' => '1.0',
      ],
      'created_date' => [
        'type' => 'date',
        'null' => true,
      ],
      'validation_rules' => [
        'type' => 'TEXT',
      ],
      'slug' => [
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => false,
        'unique' => true,
      ],
      'uuid' => [
        'type' => 'VARCHAR',
        'constraint' => 36,
        'null' => false,
      ],
    ]);

    $this->forge->addKey('form_id', true);
    $this->forge->createTable('Forms');
  }

  public function down()
  {
    $this->forge->dropTable('Forms'); 
  }
}
