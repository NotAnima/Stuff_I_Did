<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormSubmissions extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'form_submission_id' => [
        'type' => 'INT',
        'auto_increment' => true,
        'null' => false,
      ],
      'form_id' => [
        'type' => 'INT',
        'null' => false,
      ],
      'form_history_id' => [
        'type' => 'INT',
        'null' => false,
      ],
      'submission_date' => [
        'type' => 'DATE',
        'null' => false,
      ],
      'serialized_data' => [
        'type' => 'TEXT',
        'null' => false,
      ],
      'serialized_forms' => [
        'type' => 'TEXT',
        'null' => false,
      ],
    ]);

    $this->forge->addKey('form_submission_id', true);
    $this->forge->addForeignKey('form_id', 'Forms', 'form_id', '', 'CASCADE');
    $this->forge->addForeignKey('form_history_id', 'FormHistory', 'form_history_id', '', 'CASCADE');
    $this->forge->createTable('FormSubmissions');
  }

  public function down()
  {
    $this->forge->dropTable('FormSubmissions'); 
  }
}
