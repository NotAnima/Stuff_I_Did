<?php 

namespace App\Controllers;

use App\Libraries\FormGenerator;
use App\Models\FormSubmissionModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use DOMDocument;
use DOMXPath;

class FormSubmissions extends BaseController
{
    protected $form;

    public function index($form_id = null, $form_history_id = null)
    {
        $this->form = new FormGenerator(service('request'));

        $submissions = null;
        $form_submissions = null;
        $history = array();
        $header = array();
        $row = array();

        $form_model = model(FormModel::class);
        $form_name = $form_model->getFormName($form_id);

        $form_history = $this->form->get_form_history($form_name);

        if (isset($form_history_id)) {
            $submissions = array();
            $form_submissions = $this->form->get($form_name, $form_history_id);
            
            if (!empty($form_submissions)) {

              foreach ($form_submissions as $submission_item) {
                  $serialized_data = $submission_item['serialized_data'];
                  $serialized_data = $this->form->decrypt($serialized_data);
                  $submissions[] = unserialize($serialized_data);
              }

              foreach ($submissions as $submission) {
                  $row[] = $submission;
                  foreach ($submission as $col_header => $data) {
                      if (! in_array($col_header, $header) && $col_header != 'csrf_token' && $col_header != 'honeypot') {
                          $header[] = $col_header;
                      }
                  }
              }
            }
        }

        foreach ($form_history as $history_item) {
            $history[] = array(
                'form_version' => $history_item['form_version'],
                'form_history_id' => $history_item['form_history_id'],
            );
        }

        $data = [
            'title' => 'Form Submissions',
			'current_form_id' => $form_id,
			'current_form_history_id' => $form_history_id,
			'forms' => $form_model->getForms(),
			'form_versions' => $history,
			'headers' => $header,
			'rows' => $row,
			'submissions' => $submissions,
			'form_submissions' => $form_submissions,
        ];

        return view('templates/header', $data)
            . view('form_submissions/index')
            . view('templates/footer');
    }

    public function view($form_submission_id = null)
    {
        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);
        $form_submission_model = model(FormSubmissionModel::class);

        $data = [
            'title' => 'Form Submission',
            'forms' => $form_model->getForms(),
        ];

		$data['form'] = $this->form->getFormSubmission($form_submission_id);
		$data['files'] = $this->form->getFormSubmissionFiles($form_submission_id);

		return view('templates/header', $data)
		. view('form_submissions/view')
		. view('templates/footer');
    }

    public function edit($form_submission_id = null)
    {
        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);
        $form_submission_model = model(FormSubmissionModel::class);

        $data = [
            'title' => 'Form Submission',
            'forms' => $form_model->getForms(),
        ];

        $form_id = $form_submission_model->getFormID($form_submission_id)['form_id'];
		$form_submission = $form_submission_model->getFormSubmission($form_submission_id)['serialized_data'];
		$form_history_id = $form_submission_model->getFormSubmission($form_submission_id)['form_history_id'];
		$form_submission = $this->form->decrypt($form_submission);
		$form_submission = unserialize($form_submission);

		$form_name = $form_model->getFormName($form_id);
		$form = $this->form->load_form($form_name);
		$dom = new DOMDocument();
		$dom->loadHTML($form);
		$xpath = new DOMXPath($dom);

		$form_elements = $xpath->query("//form");
		$form_element = $form_elements->item(0);
		$form_element->setAttribute('action', current_url());
		
		if (! empty($form_submission)) {
			foreach ($form_submission as $index => $submission) {
				$elements = $xpath->query("//input[@name='$index']");

				if ($elements->length > 0) {
					$input_element = $elements->item(0);
					if ($input_element->getAttribute('type') != 'checkbox') {
						$input_element->setAttribute('value', $submission);
					} else {
						$input_element->setAttribute('checked', $submission);
					}
					
				} else {
					$select_elements = $xpath->query("//select[@name='$index']");
					if ($select_elements->length > 0) {
						$option_elements = $xpath->query("//option[@value='$submission']");
						$selected_option = $option_elements->item(0);
						$selected_option->setAttribute('selected', 'selected');
					}

					$textarea_elements = $xpath->query("//textarea[@name='$index']");
					if ($textarea_elements->length > 0) {
						$textarea_element = $textarea_elements->item(0);
						$textarea_element->nodeValue = $submission;
					}
				}
			}
		}

		$updated_form = $dom->saveHTML();
		$data['form'] = $updated_form;

		if ($this->form->submit()) {
			if ($this->form->update($form_submission_id)) {
				return redirect()->to('/form-submissions/' . $form_id . '/' . $form_history_id);
			}
		}

		return view('templates/header', $data)
		. view('form_submissions/view')
		. view('templates/footer');
    }

    public function delete($form_submission_id = null)
    {
        $form_submission_model = model(FormSubmissionModel::class);

		$form_id = $form_submission_model->getFormSubmission($form_submission_id)['form_id'];
		$form_history_id = $form_submission_model->getFormSubmission($form_submission_id)['form_history_id'];

		$form_submission_model->where('form_submission_id', $form_submission_id)->delete();

		return redirect()->to('/form-submissions/' . $form_id . '/' . $form_history_id);    
    }

    public function print($form_submission_id = null)
    {
        $this->form = new FormGenerator(request('service'));

        $form_model = model(FormModel::class);
		$form_submission_model = model(FormSubmissionModel::class);

		$data = [
			'title' => 'Form Submission',
			'forms' => $form_model->getForms(),
		];

		$form_id = $form_submission_model->getFormID($form_submission_id)['form_id'];
		$form_submission = $form_submission_model->getFormSubmission($form_submission_id)['serialized_data'];
		$form_submission = $this->form->decrypt($form_submission);
		$form_submission = unserialize($form_submission);

		$form_name = $form_model->getFormName($form_id);
		$form = $this->form->load_form($form_name);
		$dom = new DOMDocument();
		$dom->loadHTML($form);
		$xpath = new DOMXPath($dom);
		
		if (! empty($form_submission)) {
			foreach ($form_submission as $index => $submission) {
				$elements = $xpath->query("//input[@name='$index']");

				if ($elements->length > 0) {
					$input_element = $elements->item(0);
					if ($input_element->getAttribute('type') != 'checkbox') {
						$input_element->setAttribute('value', $submission);
						$input_element->setAttribute('disabled', 'disabled');
					} else {
						$input_element->setAttribute('checked', $submission);
						$input_element->setAttribute('disabled', 'disabled');
					}
					
				} else {
					$select_elements = $xpath->query("//select[@name='$index']");
					if ($select_elements->length > 0) {
						$option_elements = $xpath->query("//option[@value='$submission']");
						$selected_option = $option_elements->item(0);
						$selected_option->setAttribute('selected', 'selected');
						$select_elements->item(0)->setAttribute('disabled', 'disabled');
					}

					$textarea_elements = $xpath->query("//textarea[@name='$index']");
					if ($textarea_elements->length > 0) {
						$textarea_element = $textarea_elements->item(0);
						$textarea_element->setAttribute('disabled', 'disabled');
						$textarea_element->nodeValue = $submission;
					}
				}
			}
		}

		$updated_form = $dom->saveHTML();
		$data['form'] = $updated_form;

		return view('templates/header', $data)
		. view('form_submissions/print')
		. view('templates/footer');
    }
}


?>
