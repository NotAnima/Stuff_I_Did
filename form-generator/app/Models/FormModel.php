<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
	protected $table = 'Forms';

	protected $primaryKey = 'form_id';

	protected $allowedFields = ['form_name', 'form_description', 'form_fields', 'form_version', 'created_date', 'validation_rules' ,'slug'];

	public function getForms($id = false)
	{
		if ($id === false) {
			return $this->findAll();
		}

		return $this->where(['form_id' => $id])->first();
	}

	public function getFormID($name = null)
	{
		return $this->select('form_id')->where(['form_name' => $name])->first();
	}

	public function getFormName($id = null)
	{
		return $this->select('form_name')->where(['form_id' => $id])->first();
	}

	public function getFormVersion($name = null)
	{
		return $this->select('form_version')->where(['form_name' => $name])->first();
	}
}
