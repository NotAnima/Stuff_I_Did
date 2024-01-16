<?php

namespace App\Models;

use CodeIgniter\Model;

class FormHistoryModel extends Model
{
  protected $table = 'FormHistory';

  protected $primaryKey = 'form_history_id';

  protected $allowedFields = ['form_id', 'form_version', 'form_fields', 'validation_rules'];

  public function getFormsHistory($form_id = false)
  {
    if ($form_id === false) {
        return $this->findAll();
    }

    return $this->where(['form_id' => $form_id])->findAll();
  }

  public function getFormHistoryID($form_id = false, $form_version = false){
    d($form_id);
    d($form_version);
    return $this->where(['form_id' => (int) $form_id, 'form_version' => (float) $form_version])->first();
  }

  public function getFormHistoryFields($form_history_id){
    return $this->where(['form_history_id' => $form_history_id])->first();
  }
}
