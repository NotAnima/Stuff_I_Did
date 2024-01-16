<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Libraries\FormGenerator;

class FormsAPI extends ResourceController
{
    protected $form;

    use ResponseTrait;

    public function getForms()
    {
        $this->form = new FormGenerator(service('request'));

        $response = [
			'status' => 200,
			'error' => null,
			'messages' => 'Forms Found',
			'data' => $this->form->getForms(),
		];

        return $this->respond($response);
    }

    public function deleteForm($form_id)
    {
        $this->form = new FormGenerator(service('request'));

        $result = $this->form->deleteForm($form_id);

        if ($result) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Form successfully deleted',
            ];
        } else {
            $response = [
                'status' => 400,
                'error' => 'An error has occurred, Form ID may be invalid',
                'messages' => 'Invalid Form ID',
            ];
        }

        return $this->respond($response);
    }

    public function updateForm($form_id)
    {
        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);

        $put = [
            'form' => $this->request->getVar('form'),
            'validation_rules' => $this->request->getVar('validation_rules'),
        ];

        $form_name = $form_model->getFormName($form_id);
        $form = $this->form->encrypt($put['form']);
        $form_rules = serialize($put['validation_rules']);
        $form_rules = $this->form->encrypt($form_rules);
        $result = $this->form->updateForm($form_name, $form, $form_rules);

        if ($result === true) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Successfully Updated Form',
                'testing' => $put['form'],
            ];
        } else {
            $response = [
                'status' => 400,
                'error' => null,
                'messages' => 'Failed to Update Form',
            ];
        }

        return $this->respond($response);
    }

    public function postForm()
    {
        $this->form = new FormGenerator(service('request'));

        $post = [
            'form_name' => $this->request->getVar('form_name'),
            'form_description' => $this->request->getVar('form_description'),
            'form' => $this->request->getVar('form'),
            'validation_rules' => $this->request->getVar('validation_rules'),
        ];

        $result = $this->form->save($post['form_name'], $post['form_description'], $post['form'], $post['validation_rules']);

        if ($result === true) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Successfully Created Form',
            ];
        } else {
            $response = [
                'status' => 400,
                'error' => null,
                'messages' => 'Failed to Create Form',
            ];
        }

        return $this->respond($response);
    }


    public function getFormSubmissions($form_id)
    {
        $this->form = new FormGenerator(service('request'));

        $data = $this->form->getFormSubmissions($form_id);

        if ($data) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Form Submissions Found',
                'data' => $data,
            ];

        } else {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'No such Form ID or no Form Submissions Found',
                'data' => $data
            ];
        }

        return $this->respond($response);
    }

    public function postFormSubmission($form_id)
    {
        $this->form = new FormGenerator(service('request'));

        $model = model(FormModel::class);

        $form_name = $model->getFormName($form_id);

        if ($this->form->submit()) {
            if ($this->form->post($form_name)) {
                $response = [
                    'status' => 200,
                    'error' => null,
                    'messages' => 'Successfully submitted form',
                ];
            } else {
                $response = [
                    'status' => 400,
                    'error' => null,
                    'messages' => 'Failed to submit form',
                ];
            }
        } else {
            $response = [
                'status' => 400,
                'error' => null,
                'messages' => 'Invalid request',
            ];
        }

        return $this->respond($response);
    }

    public function deleteFormSubmission($form_id, $form_submission_id)
    {
        $this->form = new FormGenerator(service('request'));

        $result = $this->form->deleteFormSubmission($form_id, $form_submission_id);

        if ($result) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Form Submission successfully deleted',
            ];
        } else {
            $response = [
                'status' => 400,
                'error' => 'An error has occurred, Form ID or Form Submission ID may be invalid',
                'messages' => 'Invalid Form ID or Form Submission ID',
            ];
        }

        return $this->respond($response);
    }

    public function getFormHistory($form_id)
    {
        $this->form = new FormGenerator(service('request'));

        $data = $this->form->getFormHistory($form_id);

        if ($data) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Form History Found',
                'data' => $data,
            ];

        } else {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'No such Form ID or no Form History Found',
                'data' => $data
            ];
        }

        return $this->respond($response);
    }

    public function deleteFormHistory($form_history_id)
    {
        $this->form = new FormGenerator(service('request'));

        $data = $this->form->deleteFormHistory($form_history_id);

        if ($data) {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'Successfully deleted Form History',
            ];

        } else {
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => 'No such Form History Found',
            ];
        }

        return $this->respond($response);
    }
}
