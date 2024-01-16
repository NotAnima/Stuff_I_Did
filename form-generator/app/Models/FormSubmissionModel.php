<?php

namespace App\Models;

use CodeIgniter\Model;

class FormSubmissionModel extends Model
{
	protected $table = 'FormSubmissions';

	protected $allowedFields = ['form_id', 'form_history_id', 'submission_date', 'serialized_data', 'serialized_files'];

	protected $primaryKey = 'form_submission_id';

	public function getFormSubmissions($form_id = false, $history_id = false)
	{
		if ($form_id === false) {
			return $this->findAll();
		} else if ($form_id !== false && $history_id === false) {
			return $this->where(['form_id' => $form_id])->findAll();
		}

		return $this->where(['form_id' => $form_id, 'form_history_id' => $history_id])->findAll();
	}

	public function getFormID($form_submission_id)
	{
		return $this->where('form_submission_id', $form_submission_id)->first();
	}

	public function getFormSubmission($form_submission_id)
	{
		return $this->where('form_submission_id', $form_submission_id)->first();
	}
}
