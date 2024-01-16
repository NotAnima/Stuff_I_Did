<?php

namespace App\Libraries;

use App\Database\Migrations\FormHistory;
use App\Database\Migrations\FormSubmissions;
use App\Models\FormModel;
use App\Models\FormHistoryModel;
use App\Models\FormSubmissionModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;

use DOMDocument;
use DOMXPath;

class FormGenerator
{
	use ResponseTrait;

	/*****Validation variables*****/
	protected $validation = true;

	public $salt;

	public $errors = array();

	public $format_rule_dates = 'M d, Y';

	public $delimiter = array(',', '|');

	public $sanitize_html = false;

	public $required = false;

	protected $required_fields;

	protected $encrypt_form_results = true;

	// Upload File Variables
	public $upload_dir = 'uploads/';

	public $upload_accepted_mimes;
	public $upload_accepted_types;
	# Max file size for uploaded files is 2MB
	public $upload_max_filesize = 2091752;

	// Encryption variables
	protected $ciphering = 'AES-128-CTR';

	protected $options = 0;

	protected $encryption_iv = '1234567891011121';

	protected $encryption_key = "GeeksforGeeks";


	/****Validation variables end****/

	public $success = array();

	private $wrapper = 'default';

	public function encryption_form_results($encrypt)
	{
		if ($encrypt === false) {
			$this->encrypt_form_results = false;
		} else {
			$this->encrypt_form_results = true;
		}
	}

	public function is_encrypted()
	{
		return $this->encrypt_form_results;
	}

	public function submit($form_id = null)
	{

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->check_for_csrf();
			if ($this->check_for_honeypot()) {
				if ($_POST['honeypot'] != '') {
					$this->add_to_errors('Invalid request');
				}
			}

			return true;
		}

		return false;
	}

	private function check_for_honeypot()
	{
		if (array_key_exists('honeypot', $_POST)) {
			return true;
		}
		return false;
	}

	public function set_wrapper($wrapper)
	{
		$this->wrapper = $wrapper;
	}

	public function ok()
	{
		if (isset($_POST['csrf_token']) && !isset($_SESSION['formgen']['token'])) {
			return false;
		}

		if (empty($this->errors)) {
			return true;
		}

		return false;
	}

	protected function _upload_files($name)
	{
		if (!empty($this->errors)) {
			return false;
		}

		$files = array();

		if (!empty($_FILES[$name]['tmp_name'] && !empty($_FILES[$name]['tmp_name'][0]))) {

			# If more than 1 file
			if (is_array($_FILES[$name]['tmp_name']) && count($_FILES[$name]['tmp_name']) > 1) {

				for ($i = 0; $i < count($_FILES[$name]['tmp_name']); $i++) {

					if (!empty($_FILES[$name]['tmp_name']) && is_uploaded_file($_FILES[$name]['tmp_name'][$i])) {

						$handle['key'] = $name;
						$handle['name'] = $_FILES[$name]['name'][$i];
						$handle['size'] = $_FILES[$name]['size'][$i];
						$handle['type'] = $_FILES[$name]['type'][$i];
						$handle['tmp_name'] = $_FILES[$name]['tmp_name'][$i];

						array_push($files, $this->_process_file($handle));
					}
				}

				return $files;
			} else {
				# if only 1 file
				if (!empty($_FILES[$name]['tmp_name'][0]) && is_uploaded_file($_FILES[$name]['tmp_name'][0])) {

					$handle['key'] = $name;
					$handle['name'] = $_FILES[$name]['name'][0];
					$handle['size'] = $_FILES[$name]['size'][0];
					$handle['type'] = $_FILES[$name]['type'][0];
					$handle['tmp_name'] = $_FILES[$name]['tmp_name'][0];
				} elseif (!empty($_FILES[$name]['tmp_name']) && is_uploaded_file($_FILES[$name]['tmp_name'])) {
					$handle['key'] = $name;
					$handle['name'] = $_FILES[$name]['name'];
					$handle['size'] = $_FILES[$name]['size'];
					$handle['type'] = $_FILES[$name]['type'];
					$handle['tmp_name'] = $_FILES[$name]['tmp_name'];
				}

				return $this->_process_file($handle);
			}
		}
		return false;
	}

	protected function _process_file($handle)
	{
		$handle['ext'] = $this->_get_file_extension($handle);

		if ($handle['ext'] == 'jpeg') {
			$handle['name'] = rtrim($handle['filename'], 'jpeg') . 'jpg';
			$handle['ext'] = 'jpg';
		}

		if (!$this->_check_upload_accepted_types($handle)) {
			return false;
		}

		if ($this->_check_filesize($handle)) {
			return false;
		}

		# add a trailing slash if $upload_dir doesn't have one
		if (substr($this->upload_dir, -1) != '/') {
			$this->upload_dir = $this->upload_dir . '/';
		}

		$upload_directory = $this->upload_dir . uniqid() . '.' . $handle['ext'];
		if (@move_uploaded_file($handle['tmp_name'], $upload_directory)) {
			$handle['destination_dir'] = $upload_directory;
			return $handle;
		} else {

			$this->errors['upload-error-move'] = 'There was an error uploading a file: it could not be moved to the final destination. Please check the directory permissions on ' . $this->upload_dir . ' and try again.';

			return true;
		}
	}

	protected function _check_filesize($handle)
	{
		$kb = 1024;
		$mb = $kb * 1024;
		d($handle['size']);

		if ($handle['size'] > $this->upload_max_filesize) {

			# convert bytes to megabytes because it's more human readable
			$size = round($this->upload_max_filesize / $mb, 2) . ' MB';

			$this->errors['file-size'] = 'File size exceeded. The file can not be larger than ' . $size;

			return true;
		} else {
			return false;
		}
	}


	protected function _check_upload_accepted_types($handle)
	{

		# get the accepted file types
		# check the extension or mime type

		if (!$this->_upload_accepted_types() && !$this->_upload_accepted_mimes()) {
			$this->errors['accepted-types'] = 'Oops! You must specify the allowed file types using either $upload_accepted_types or $upload_accepted_mimes.';
			return false;
		}

		# see if it's in the accepted upload types
		if ($this->upload_accepted_types && !in_array($handle['ext'], $this->_upload_accepted_types())) {
			$this->errors['accepted-types'] = 'Oops! The file was not uploaded because it is in an unsupported file type.';
			return false;
		}

		$parts = @getimagesize($handle['tmp_name']);

		# see if it's in the accepted mime types
		if ($this->upload_accepted_mimes && !in_array($parts['mime'], $this->_upload_accepted_mimes())) {
			$this->errors['accepted-types'] = 'Oops! The file was not uploaded because it is an unsupported mime type.';
			return false;
		}

		return true;
	}

	protected function _upload_accepted_types()
	{
		if ($this->upload_accepted_types) {
			# we're allowing jpg, gif and png
			if ($this->upload_accepted_types == 'images') {
				return array('jpg', 'jpeg', 'gif', 'png');
			}

			# explode the accepted file types into an array
			$types = explode(',', str_replace('.', '', $this->upload_accepted_types));
			return $types;
		} else {
			return false;
		}
	}

	protected function _upload_accepted_mimes()
	{
		if ($this->upload_accepted_mimes) {

			# we're allowing jpg, gif and png
			if ($this->upload_accepted_mimes == 'images') {
				return array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
			}

			# explode the accepted file types into an array
			$types = explode(',', $this->upload_accepted_mimes);
			return $types;
		} else {
			return false;
		}
	}

	protected function _get_file_extension($handle)
	{
		return strtolower(ltrim(strrchr($handle['name'], '.'), '.'));
	}

	protected function _validate_file($name, $label = '', $rules = [])
	{
		if (!isset($_FILES[$name]) && in_array('required', $rules)) {
			$data = [
				'name' => $name,
				'label' => $label,
			];
			$this->_validation_message($data, 'is required');

			return;
		}

		if (!empty($_FILES)) {
			if (!$this->upload_accepted_types && !$this->upload_accepted_mimes) {
				$this->add_to_errors('Please specify the accepted file types with $uploaded_accepted_mimes or $upload_accepted_types.');
				return false;
			}

			$files = array();

			if (!empty($_FILES[$name]['tmp_name'] && !empty($_FILES[$name]['tmp_name'][0]))) {

				# If more than 1 file
				if (is_array($_FILES[$name]['tmp_name']) && count($_FILES[$name]['tmp_name']) > 1) {

					for ($i = 0; $i < count($_FILES[$name]['tmp_name']); $i++) {

						if (!empty($_FILES[$name]['tmp_name']) && is_uploaded_file($_FILES[$name]['tmp_name'][$i])) {

							$handle['key'] = $name;
							$handle['name'] = $_FILES[$name]['name'][$i];
							$handle['size'] = $_FILES[$name]['size'][$i];
							$handle['type'] = $_FILES[$name]['type'][$i];
							$handle['tmp_name'] = $_FILES[$name]['tmp_name'][$i];

							$handle['ext'] = $this->_get_file_extension($handle);

							if ($handle['ext'] == 'jpeg') {
								$handle['name'] = rtrim($handle['filename'], 'jpeg') . 'jpg';
								$handle['ext'] = 'jpg';
							}

							if (!$this->_check_upload_accepted_types($handle)) {
								return false;
							}

							if ($this->_check_filesize($handle)) {
								return false;
							}

							array_push($files, $handle);
						}
					}

					return $files;
				} else {
					# if only 1 file
					if (!empty($_FILES[$name]['tmp_name'][0]) && is_uploaded_file($_FILES[$name]['tmp_name'][0])) {

						$handle['key'] = $name;
						$handle['name'] = $_FILES[$name]['name'][0];
						$handle['size'] = $_FILES[$name]['size'][0];
						$handle['type'] = $_FILES[$name]['type'][0];
						$handle['tmp_name'] = $_FILES[$name]['tmp_name'][0];
					} elseif (!empty($_FILES[$name]['tmp_name']) && is_uploaded_file($_FILES[$name]['tmp_name'])) {
						$handle['key'] = $name;
						$handle['name'] = $_FILES[$name]['name'];
						$handle['size'] = $_FILES[$name]['size'];
						$handle['type'] = $_FILES[$name]['type'];
						$handle['tmp_name'] = $_FILES[$name]['tmp_name'];
					}

					$handle['ext'] = $this->_get_file_extension($handle);

					if ($handle['ext'] == 'jpeg') {
						$handle['name'] = rtrim($handle['filename'], 'jpeg') . 'jpg';
						$handle['ext'] = 'jpg';
					}

					if (!$this->_check_upload_accepted_types($handle)) {
						return false;
					}

					if ($this->_check_filesize($handle)) {
						return false;
					}

					return $handle;
				}
			}

			return false;
		}
	}

	public function post($form_name = null)
	{

		# If form being submitted is from database
		$uploaded_files = NULL;
		$current_date = date('Y-m-d');

		$submission_model = model(FormSubmissionModel::class);
		$history_model = model(FormHistoryModel::class);
		$form_model = model(FormModel::class);

		if (!empty($_FILES) && empty($this->errors)) {

			if (!$this->upload_accepted_types && !$this->upload_accepted_mimes) {
				$this->add_to_errors('Please specify the accepted file types with $uploaded_accepted_mimes or $upload_accepted_types.');
				return false;
			}

			foreach ($_FILES as $name => $file) {
				if ($return = $this->_upload_files($name)) {
					$uploaded_files[$return['destination_dir']] = $return['ext'];
				}
			}
		}

		if (empty($this->errors)) {

			$form_id = $form_model->getFormID($form_name);
			$current_version = $form_model->getFormVersion($form_name);
			$form_history_id = $history_model->getFormHistoryID($form_id['form_id'], $current_version['form_version'])['form_history_id'];
			unset($_POST['csrf_token']);
			unset($_POST['honeypot']);
			$form_results = serialize($_POST);
			if ($this->encrypt_form_results) {
				$form_result = openssl_encrypt($form_results, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);
			}
			$data = [
				'form_id' => $form_id,
				'form_history_id' => $form_history_id,
				'submission_date' => $current_date,
				'serialized_data' => $form_result,
				'serialized_files' => serialize($uploaded_files),
			];

			$submission_model->save($data);
			return true;
		}

		return false;
	}

	public function update($form_submission_id, $validation_rules = null)
	{
		$uploaded_files = NULL;
		$current_date = date('Y-m-d');

		$submission_model = model(FormSubmissionModel::class);
		$history_model = model(FormHistoryModel::class);
		$form_model = model(FormModel::class);

		if (!empty($_FILES) && empty($this->errors)) {

			foreach ($_FILES as $file) {
				$fileName = $file["name"];
				$fileType = $file["type"];
				$fileTmpName = $file["tmp_name"];
				$fileError = $file["error"];
				$extension = pathinfo($file['name'], PATHINFO_EXTENSION);

				if ($fileError === UPLOAD_ERR_OK) {

					$destinationDir = "uploads/";

					if (!is_dir($destinationDir)) {
						mkdir($destinationDir, 0770, true);
					}

					$new_unique_file_name = uniqid() . '.' . $extension;

					$destinationPath = $destinationDir . $new_unique_file_name;
					move_uploaded_file($fileTmpName, $destinationPath);
					$uploaded_files[$destinationPath] = $fileType;
				} else {
					$this->add_to_errors("File upload unsuccessful");
				}
			}
		}
		if (empty($this->errors)) {

			$form_id = $submission_model->getFormId($form_submission_id);
			$form_name = $form_model->getFormName($form_id['form_id']);
			$current_version = $form_model->getFormVersion($form_name);
			$form_history_id = $history_model->getFormHistoryID($form_id['form_id'], $current_version['form_version'])['form_history_id'];
			$update_data = [
				'form_id' => $form_id['form_id'],
				'form_history_id' => $form_history_id,
				'submission_date' => $current_date,
				'serialized_data' => openssl_encrypt(serialize($_POST), $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv),
				'serialized_files' => serialize($uploaded_files),
			];

			$submission_model->set($update_data)->where('form_submission_id', $form_submission_id)->update();
			return true;
		}
		return false;
	}

	public function csrf_placeholder()
	{
		return "<input type=\"hidden\" name=\"csrf_token\" value=\"<!-- csrf_token -->\">\r\n\r\n";
	}

	private function insert_csrf_token($timeout = 3600)
	{
		if (session_status() == PHP_SESSION_NONE) {
			$this->add_to_errors('CSRF requires session_start() at the top of the script');
		}

		if (empty($_SESSION['formgen']['token'])) {
			$_SESSION['formgen']['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		}

		$string = $_SESSION['formgen']['token'] . '|' . (time() + $timeout);

		return $string;
	}

	public function csrf($timeout = 3600)
	{
		if (session_status() == PHP_SESSION_NONE) {
			$this->add_to_errors('CSRF requires session_start() at the top of the script');
		}

		if (empty($_SESSION['formgen']['token'])) {
			$_SESSION['formgen']['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		}

		$string = $_SESSION['formgen']['token'] . '|' . (time() + $timeout);

		return "<input type=\"hidden\" name=\"csrf_token\" value=\"{$string}\">\r\n\r\n";
	}

	private function check_for_csrf()
	{
		if (isset($_POST['csrf_token']) && isset($_SESSION['formgen']['token'])) {
			$parts = explode('|', $_POST['csrf_token']);

			if (hash_equals((string) $_SESSION['formgen']['token'], strval($parts[0]))) {

				if (time() >= $parts[1]) {
					$this->add_to_errors("Your session has expired. Please refresh the page.");

					$_SESSION['formgen']['token'] = null;
				}
			}
		}
	}

	public function errors()
	{
		if (!empty($this->errors)) {
			return $this->errors;
		} else {
			return false;
		}
	}

	public function success()
	{
		if (!empty($this->success)) {
			return $this->success;
		} else {
			return false;
		}
	}

	public function add_to_errors($str)
	{
		array_push($this->errors, $str);
	}

	public function add_to_success($str)
	{
		array_push($this->success, $str);
	}

	public function save($form_name, $form_description, $form, $validation_rules = null)
	{
		$formModel = model(FormModel::class);
		$formHistoryModel = model(FormHistoryModel::class);
		$current_date = date('Y-m-d');
		$slug = url_title($form_name, '-', true);

		$rules = array();

		if (isset($validation_rules)) {
			foreach ($validation_rules as $key => $rule) {
				$rules[$key] = $rule;
			}
		}

		try {

			$iv_length = openssl_cipher_iv_length($this->ciphering);

			$form_fields = openssl_encrypt($form, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);

			$form_rules = serialize($rules);
			$form_rules = openssl_encrypt($form_rules, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);

			$formModel->save([
				'form_name' => $form_name,
				'form_description' => $form_description,
				'form_fields' => $form_fields,
				'created_date' => $current_date,
				'validation_rules' => $form_rules,
				'slug' => $slug,
			]);

			$form_id = $formModel->getFormID($form_name);

			$data['form'] = $formModel->getForms($form_id);

			$formHistoryModel->save([
				'form_id' => $data['form']['form_id'],
				'form_version' => $data['form']['form_version'],
				'form_fields' => $form_fields,
				'validation_rules' => $form_rules,
			]);
		} catch (\Exception $e) {
			exit($e->getMessage());

			return false;
		}

		return true;
	}

	public function load_edit_form($form_name, $form_history_id = null)
	{
		$form_model = model(FormModel::class);
		$form_history_model = model(FormHistoryModel::class);

		$form_id = $form_model->getFormID($form_name);

		$form = $form_model->getForms($form_id)['form_fields'];

		if (isset($form_history_id)) {
			$form_history_fields = $form_history_model->getFormHistoryFields($form_history_id);
			$form = $form_history_fields['form_fields'];
		}

		$form = openssl_decrypt($form, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);

		return $form;
	}

	public function load_form($form_name, $form_history_id = null)
	{
		$form_model = model(FormModel::class);
		$form_history_model = model(FormHistoryModel::class);

		$form_id = $form_model->getFormID($form_name);

		$form = $form_model->getForms($form_id)['form_fields'];

		if (isset($form_history_id)) {
			$form_history_fields = $form_history_model->getFormHistoryFields($form_history_id);
			$form = $form_history_fields['form_fields'];
		}

		$form = openssl_decrypt($form, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);

		if ($this->check_form_contains_csrf_name($form)) {
			$form = str_replace("<!-- csrf_token -->", $this->insert_csrf_token(), $form);
		}

		return $form;
	}

	public function load_validation_rules($form_name)
	{
		$form_model = model(FormModel::class);

		$form_id = $form_model->getFormID($form_name);

		$form_rules = $form_model->getForms($form_id)['validation_rules'];

		$form_rules = openssl_decrypt($form_rules, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);

		$form_rules = unserialize($form_rules);

		return $form_rules;
	}

	public function validate_form($rules_array = [])
	{
		if (!empty($rules_array) && is_array($rules_array)) {
			foreach ($rules_array as $key => $rule) {
				$this->validate_post($key, $rule[0], $rule[1]);
			}
		}
		return;
	}

	private function check_form_contains_csrf_name($form)
	{
		$needle = "<!-- csrf_token -->";
		if (strpos($form, $needle) !== false) {
			return true;
		}
		return false;
	}

	public function get($form_name, $form_history_id = null)
	{
		$formModel = model(FormModel::class);
		$submissionModel = model(FormSubmissionModel::class);

		$form_id = $formModel->getFormID($form_name);

		if (isset($form_history_id)) {
			$form_submissions = $submissionModel->getFormSubmissions($form_id, $form_history_id);
		} else {
			$form_submissions = $submissionModel->getFormSubmissions($form_id);
			foreach ($form_submissions as $key => $submission) {
				$form_submissions[$key]['serialized_data'] = openssl_decrypt($form_submissions[$key]['serialized_data'], $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);
			}
		}

		return $form_submissions;
	}

	public function getFormSubmission($form_submission_id)
	{
		$form_model = model(FormModel::class);
		$form_submission_model = model(FormSubmissionModel::class);

		$form_id = $form_submission_model->getFormID($form_submission_id)['form_id'];
		$form_submission = $form_submission_model->getFormSubmission($form_submission_id)['serialized_data'];
		$form_submission = $this->decrypt($form_submission);
		$form_submission = unserialize($form_submission);

		$form_name = $form_model->getFormName($form_id);
		$form = $this->load_form($form_name);

		$dom = new DOMDocument();
		$dom->loadHTML($form);
		$xpath = new DOMXPath($dom);

		if (!empty($form_submission)) {
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

		return $updated_form;
	}

	public function getFormSubmissionFiles($form_submission_id)
	{
		$form_submission_model = model(FormSubmissionModel::class);
		$form_files = $form_submission_model->getFormSubmission($form_submission_id)['serialized_files'];

		$form_files = unserialize($form_files);

		return $form_files;
	}

	public function decrypt($data)
	{
		return openssl_decrypt($data, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);
	}

	public function encrypt($data)
	{
		return openssl_encrypt($data, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);
	}

	public function get_form_history($form_name)
	{
		$formModel = model(FormModel::class);
		$historyModel = model(FormHistoryModel::class);

		$form_id = $formModel->getFormID($form_name);

		$form_history = $historyModel->getFormsHistory($form_id);

		return $form_history;
	}

	public function label($name, $label_text, $id = null, $additional = null)
	{
		$data = [
			'name' => $name,
			'label_text' => $label_text,
			'id' => $id,
			'additional' => $additional,
		];

		return $this->label_wrapper($data, $this->wrapper);
	}

	private function label_wrapper($data, $wrapper)
	{

		$return = null;

		if ($wrapper === 'bootstrap') {

			if (isset($data['type'])) {
				if ($data['type'] === 'checkbox' || $data['type'] === 'radio') {
					$return .= '<label for="' . $data['name'] . '" class="form-check-label" ';
				}
			} else {
				$return .= '<label for="' . $data['name'] . '" class="form-label" ';
			}
		} else {
			$return .= '<label for="' . $data['name'] . '" ';
		}

		if (isset($data['id'])) {
			$return .= ' id="' . $data['id'] . '" ';
		}

		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		$return .= '>' . $data['label_text'] . '</label>';

		return $return;
	}

	public function open($action = null, $name = null, $id = null, $method = null, $additional = null)
	{
		$output = '<form ';
		if (isset($action)) {
			$output = $output . 'action="' . $action . '" ';
		}
		if (isset($name)) {
			$output = $output . 'name="' . $name . '" ';
		}
		if (isset($id)) {
			$output = $output . 'id="' . $id . '" ';
		}
		if (isset($method)) {
			$output = $output . 'method="' . $method . '" ';
		} else {
			$output = $output . 'method="post" ';
		}
		if (isset($additional)) {
			$output = $output . $additional;
		}
		$output = $output . ">";

		return $output;
	}

	public function open_file_upload($action = null, $name = null, $id = null, $method = null, $additional = null)
	{
		$output = '<form enctype="multipart/form-data" ';
		if (isset($action)) {
			$output = $output . 'action="' . $action . '" ';
		}
		if (isset($name)) {
			$output = $output . 'name="' . $name . '" ';
		}
		if (isset($id)) {
			$output = $output . 'id="' . $id . '" ';
		}
		if (isset($method)) {
			$output = $output . 'method="' . $method . '" ';
		} else {
			$output = $output . 'method="post" ';
		}
		if (isset($additional)) {
			$output = $output . $additional;
		}
		$output = $output . ">";

		return $output;
	}

	public function close()
	{
		$output = '</form>';

		return $output;
	}

	// Formr Text Inputs

	public function text($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'text',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;

		// $output = null;
		// $input = '<input type="text" name="' . $name . '" id="' . $id . '" ';
		// if (isset($label)) {
		// 	$output .= $this->label($name, $label);
		// 	d($output);
		// }
		// if (isset($default_value)) {
		// 	$input = $input . 'value="' . $default_value . '" ';
		// }
		// if (isset($id)) {
		// 	$input = $input . 'id="' . $id . '" ';
		// }
		// if (isset($additional)) {
		// 	$input = $input . $additional;
		// }
		// $input = $input . ">";
		// $output = $output . $input;

		// return $output;
	}

	private function text_wrapper($data, $wrapper)
	{

		$return = null;

		if ($wrapper === 'bootstrap') {
			$return .= '<input type="' . $data['type'] . '" name="' . $data['name'] . '" class="form-control" ';
		} else {
			$return .= '<input type="' . $data['type'] . '" name="' . $data['name'] . '" ';
		}

		if (isset($data['multiple'])) {
			$return .= 'multiple ';
		}

		if (isset($data['default_value'])) {
			$return .= 'value="' . $data['default_value'] . '" ';
		}
		if (isset($data['id'])) {
			$return .= 'id="' . $data['id'] . '" ';
		}

		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		$return .= '>';

		return $return;
	}

	public function color($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'color',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function date($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'date',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function datetime($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'datetime-local',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function email($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'email',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function hidden($name, $value)
	{

		$input = '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '">';

		return $input;
	}

	public function honeypot()
	{
		$input = '<input type="text" name="honeypot" value="" style="display: none">';

		return $input;
	}

	public function month($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'month',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function number($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'number',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function password($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'password',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function range($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'range',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function search($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'search',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function tel($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'tel',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function textarea($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->textarea_wrapper($data, $this->wrapper);

		return $return;
	}

	private function textarea_wrapper($data, $wrapper)
	{

		$return = null;

		if ($wrapper === 'bootstrap') {
			$return .= '<textarea name="' . $data['name'] . '" class="form-control" ';
		} else {
			$return .= '<textarea name="' . $data['name'] . '" ';
		}

		if (isset($data['id'])) {
			$return .= 'id="' . $data['id'] . '" ';
		}

		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		if (isset($data['default_value'])) {
			$return .= '>' . $data['default_value'] . '';
		} else {
			$return .= '>';
		}

		$return .= '</textarea>';

		return $return;
	}

	public function time($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'time',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function url($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'url',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	public function week($name, $label = null, $default_value = null, $id = null, $additional = null)
	{

		$return = null;
		$data = [
			'type' => 'week',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);

		return $return;
	}

	// Formr Checkboxes & Radios

	public function checkbox($name, $label = null, $default_value = null, $id = null, $additional = null, $checked = null)
	{

		$return = null;

		$data = [
			'name' => $name,
			'type' => 'checkbox',
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
			'checked' => $checked,
		];

		$return .= $this->checkbox_wrapper($data, $this->wrapper);

		if (isset($label)) {
			$return .= $this->label_wrapper(['name' => $name, 'label_text' => $label, 'type' => 'checkbox'], $this->wrapper);
		}

		$return .= "</div>";

		return $return;
	}

	private function checkbox_wrapper($data, $wrapper)
	{

		$return = null;

		if ($wrapper === 'bootstrap') {
			$return .= '<div class="form-check">';
			$return .= '<input type="' . $data['type'] . '" name="' . $data['name'] . '" class="form-check-input" ';
		} else {
			$return .= '<div>';
			$return .= '<input type="' . $data['type'] . '" name="' . $data['name'] . '" ';
		}

		if (isset($data['default_value'])) {
			$return .= 'value="' . $data['default_value'] . '" ';
		}
		if (isset($data['id'])) {
			$return .= 'id="' . $data['id'] . '" ';
		}

		if (isset($data['checked'])) {
			$return .= 'checked="checked" ';
		}

		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		$return .= '>';

		return $return;
	}

	public function radio($name, $label = null, $default_value = null, $id = null, $additional = null, $checked = null)
	{

		$return = null;

		$data = [
			'name' => $name,
			'type' => 'radio',
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
			'checked' => $checked,
		];

		$return .= $this->checkbox_wrapper($data, $this->wrapper);

		if (isset($label)) {
			$return .= $this->label_wrapper(['name' => $name, 'label_text' => $label, 'type' => 'radio'], $this->wrapper);
		}

		return $return;
	}

	// Formr Select Menus

	public function select($name, $label = null, $default_value = null, $id = null, $additional = null, $default_select = null, $options = null)
	{

		$return = null;
		$data = [
			'type' => 'single',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
			'default_select' => $default_select,
			'options' => $options,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->select_wrapper($data, $this->wrapper);

		return $return;
	}

	public function select_multiple($name, $label = null, $default_value = null, $id = null, $additional = null, $default_select = null, $options = null)
	{

		$return = null;
		$data = [
			'type' => 'multiple',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
			'default_select' => $default_select,
			'options' => $options,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->select_wrapper($data, $this->wrapper);

		return $return;
	}

	private function select_wrapper($data, $wrapper)
	{

		$return = null;

		if ($wrapper === 'bootstrap') {
			$return .= '<select name="' . $data['name'] . '" class="form-select" ';
		} else {
			$return .= '<select name="' . $data['name'] . ' ';
		}

		if (isset($data['type']) && $data['type'] === 'multiple') {
			$return .= 'multiple ';
		}

		if (isset($data['default_value'])) {
			$return .= 'value="' . $data['default_value'] . '" ';
		}

		if (isset($data['id'])) {
			$return .= 'id="' . $data['id'] . '" ';
		}

		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		$return .= '>';

		$option = null;

		foreach ($data['options'] as $key => $value) {
			if (isset($data['default_select']) && ($data['default_select'] == $key)) {
				$option .= '<option value="' . $key . '" selected>' . $value . '</option>' . PHP_EOL;
			} else {
				$option .= '<option value="' . $key . '">' . $value . '</option>' . PHP_EOL;
			}
		}

		$return .= $option . "</select>";

		return $return;
	}

	// Formr File Uploads

	public function file($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'file',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);
		return $return;
	}

	public function file_multiple($name, $label = null, $default_value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'file',
			'name' => $name,
			'default_value' => $default_value,
			'id' => $id,
			'additional' => $additional,
			'multiple' => 'multiple',
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->text_wrapper($data, $this->wrapper);
		return $return;
	}

	// Formr Buttons

	public function button($name = null, $label = null, $value = null, $id = null, $additional = null)
	{
		$return = null;
		$data = [
			'type' => 'submit',
			'name' => $name,
			'value' => $value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->button_wrapper($data, $this->wrapper);

		return $return;
	}

	private function button_wrapper($data, $wrapper)
	{

		$return = null;

		if (!isset($data['id']) && !isset($data['value']) && !isset($additional)) {
			if ($wrapper === 'bootstrap') {
				$return .= '<button type="' . $data['type'] . '" id="button" class="btn btn-primary" ';
			} else {
				$return .= '<button type="' . $data['type'] . '" id="button" class="button" ';
			}
		} else {
			if ($wrapper === 'bootstrap') {
				$return .= '<button class="btn btn-primary" ';
			}
			else {
				$return .= '<button ';
			}
		}

		if (isset($data['name'])) {
			$return .= 'name="' . $data['name'] . '" ';
		}
		if (isset($data['id'])) {
			$return .= 'id="' . $data['id'] . '" ';
		}
		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		$return .= '>';
		if (!isset($data['value'])) {
			$return .= "Submit";
		} else {
			$return .= $data['value'];
		}
		$return .= '</button>';

		return $return;
	}

	public function input_submit($name = null, $label = null, $value = null, $id = null, $additional = null)
	{
		$return = null;
		if (!isset($name)) {
			$name = 'submit';
		}
		$data = [
			'type' => 'button',
			'name' => $name,
			'value' => $value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->input_wrapper($data, $this->wrapper);

		return $return;
	}

	private function input_wrapper($data, $wrapper)
	{

		$return = null;

		if (!isset($data['id']) && !isset($data['value']) && !isset($additional)) {
			if ($wrapper === 'bootstrap') {
				$return .= '<input type="' . $data['type'] . '" id="button" class="btn btn-primary" ';
			} else {
				$return .= '<input type="' . $data['type'] . '" id="button" class="button" ';
			}
		} else {
			$return .= '<input ';
		}

		if (isset($data['name'])) {
			$return .= 'name="' . $data['name'] . '" ';
		}
		if (isset($data['id'])) {
			$return .= 'id="' . $data['id'] . '" ';
		}
		if (isset($data['additional'])) {
			$return .= $data['additional'];
		}

		$return .= '>';
		if (!isset($data['value'])) {
			$return .= "Submit";
		} else {
			$return .= $data['value'];
		}
		$return .= '</input>';

		return $return;
	}

	public function reset_button($name = null, $label = null, $value = null, $id = null, $additional = null)
	{
		$return = null;
		if (!isset($name)) {
			$name = 'reset';
		}

		if (!isset($value)) {
			$value = 'Reset';
		}
		$data = [
			'type' => 'reset',
			'name' => $name,
			'value' => $value,
			'id' => $id,
			'additional' => $additional,
		];

		if (isset($label)) {
			$return .= $this->label($name, $label);
		}

		$return .= $this->button_wrapper($data, $this->wrapper);

		return $return;
	}

	/*public function error_message($open_tag = null, $close_tag = null)
	{
		$output = '';
		$errors = $this->validator->getErrors();

		if (isset($open_tag)) {
			$output = $output . $open_tag . PHP_EOL;
		}
		$output = $output . "<ul>";
		foreach ($errors as $error) {
			$output = $output . '<li>' . $error . '</li>';
		}
		$output = $output . "</ul>";

		if (isset($close_tag)) {
			$output = $output . $close_tag;
		}

		return $output;
	}*/

	public function heading($name, $string)
	{
		$output = '<h3>' . $string . '</h3>';

		return $output;
	}

	public function line_break()
	{
		return "<br/>";
	}

	public function open_div($class = null, $additional = null)
	{

		$return = null;
		if (!isset($class)) {
			if ($this->wrapper === 'bootstrap') {
				$return .= '<div class="mb-3" ' . $additional . '>';
			} else {
				$return .= '<div ' . $additional . '>';
			}
		} else {
			if ($this->wrapper === 'bootstrap') {
				$return .= '<div class="mb-3 ' . $class . '" ' . $additional . '>';
			} else {
				$return .= '<div class="' . $class . '" ' . $additional . '>';
			}
		}
		return $return;
	}

	public function close_div()
	{

		$return = '</div>';
		return $return;
	}

	public function open_tag($tag, $value = null, $additional = null)
	{
		$return = null;
		$return .= '<' . $tag . ' ';
		if (isset($additional)) {
			$return .= $additional;
		}
		$return .= '>';

		if (isset($value)) {
			$return .= $value;
		}

		return $return;
	}

	public function close_tag($tag)
	{
		$return = null;
		$return .= '</' . $tag . '>';

		return $return;
	}

	public function send_email($recipient_email, $subject, $body, $sender_email = null, $sender_name = null, $bcc = null, $cc = null)
	{

		$email = \Config\Services::email();

		$email->setTo($recipient_email);
		$email->setSubject($subject);
		$email->setMessage($body);

		if ($sender_email) {
			$email->setFrom($sender_email, $sender_name);
		}

		if ($bcc) {
			$email->setBCC($bcc);
		}

		if ($cc) {
			$email->setCC($cc);
		}

		if ($email->send()) {
			$this->add_to_success("Email successfully sent");
		} else {
			$this->add_to_errors("Email failed to send: " . $email->printDebugger(['headers']));
		}

		return;
	}

	/**
	 * General form creation (does not include checkbox, radio & dropdown)
	 * 
	 * $inputs: Name of text input fields, use "|" to separate input type (default input type is text) 
	 * 
	 * e.g. create("name, address|textarea");
	 */

	public function create($inputs)
	{
		$output = '';
		// split the inputs
		$input_list = explode(',', $inputs);

		foreach ($input_list as $i_item) {
			$output .= '<div class="mb-3">';

			// specified input type
			if (str_contains($i_item, '|')) {
				$i = explode('|', $i_item);
				$i[0] = trim($i[0]);
				$i[1] = trim($i[1]);
				$i_label = ucwords($i[0]);
				$i[0] = str_replace(' ', '-', $i[0]);

				switch ($i[1]) {
					case 'textarea':
						$output .= $this->textarea($i[0], $i_label, null, $i[0]);
						break;

					case 'color':
						$output .= $this->color($i[0], $i_label, null, $i[0]);
						break;

					case 'date':
						$output .= $this->date($i[0], $i_label, null, $i[0]);
						break;

					case 'datetime-local':
						$output .= $this->datetime($i[0], $i_label, null, $i[0]);
						break;

					case 'email':
						$output .= $this->email($i[0], $i_label, null, $i[0]);
						break;

					case 'hidden':
						$output .= $this->hidden($i[0], $i[0]);
						break;

					case 'month':
						$output .= $this->month($i[0], $i_label, null, $i[0]);
						break;

					case 'number':
						$output .= $this->number($i[0], $i_label, null, $i[0]);
						break;

					case 'password':
						$output .= $this->password($i[0], $i_label, null, $i[0]);
						break;

					case 'range':
						$output .= $this->range($i[0], $i_label, null, $i[0]);
						break;

					case 'search':
						$output .= $this->search($i[0], $i_label, null, $i[0]);
						break;

					case 'tel':
						$output .= $this->tel($i[0], $i_label, null, $i[0]);
						break;

					case 'time':
						$output .= $this->time($i[0], $i_label, null, $i[0]);
						break;

					case 'url':
						$output .= $this->url($i[0], $i_label, null, $i[0]);
						break;

					case 'week':
						$output .= $this->week($i[0], $i_label, null, $i[0]);
						break;

					case 'button':
						$output .= $this->button($i[0], null, $i_label, $i[0]);
						break;

					case 'reset':
						$output .= $this->reset_button($i[0], null, $i_label, $i[0]);
						break;

					default:
						$output .= $this->text($i[0], $i_label, null, $i[0]);
						break;
				}
			} else {
				$i_item = trim($i_item);
				$i_label = ucwords($i_item);
				$i_item = str_replace(' ', '-', $i_item);

				// check for special input types derived from input names
				if (preg_match("/\bemail\b/i", $i_item)) {
					$output .= $this->email($i_item, $i_label, null, $i_item);
				} else if (preg_match("/\bpassword\b/i", $i_item)) {
					$output .= $this->password($i_item, $i_label, null, $i_item);
				} else if (preg_match("/\bdate\b/i", $i_item)) {
					$output .= $this->date($i_item, $i_label, null, $i_item);
				} else if (preg_match("/\bphone\b/i", $i_item)) {
					$output .= $this->tel($i_item, $i_label, null, $i_item);
				} else if (preg_match("/\btime\b/i", $i_item)) {
					$output .= $this->time($i_item, $i_label, null, $i_item);
				} else if (preg_match("/\bsubmit\b/i", $i_item)) {
					$output .= $this->button($i_item, null, $i_label, $i_item);
				} else {
					// general input
					$output .= $this->text($i_item, $i_label, null, $i_item);
				}
			}

			$output .= '</div>';
		}

		return $output;
	}


	/*****************************************************************/

	/*******************Form Validation Public Functions**************/

	public function validate($string)
	{
		$parts = explode(',', $string);

		foreach ($parts as $label) {
			$key = strtolower(str_replace(' ', '_', trim($label)));

			$rules = null;

			if (preg_match('!\(([^\)]+)\)!', $label, $match)) {
				# get our field's validation rule(s)
				$rules = $match[1];

				# get the text before the double pipe for our new label
				$explode = explode('(', $label, 2);

				# set our new label text
				$label = $explode[0];

				# set our field's name
				$key = strtolower(str_replace(' ', '_', trim($label)));
			}

			if (strpos($key, 'email') !== false) {
				# this is an email address, so let's add the valid_email rule as well
				$array[$key] = $this->validate_post($key, ucwords($key), 'valid_email|' . $rules);
			} else {
				$array[$key] = $this->validate_post($key, $label, $rules);
			}
		}

		return $array;
	}


	public function validate_post($name, $label = '', $rules = '')
	{
		$post = null;
		$return = null;

		if ($this->validation === true) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (isset($_POST[$name]) && $_POST[$name] != '') {
					$post = $_POST[$name];
				}
			}

			if (!is_array($rules)) {
				$rules = explode($this->delimiter[1], $rules ?? '');
			}

			$data['post'] = $post;
			$data['name'] = $name;
			$data['label'] = $label;
			if (in_array('file', $rules)) {
				return $this->_validate_file($name, $label, $rules);
			} else {
				if (!is_array($data['post'])) {

					foreach ($rules as $rule) {
						# process boolean validation rules
						$return = $this->_validate_bool_rules($rule, $data);
					}

					foreach ($rules as $rule) {
						$allow_html = ($rule == 'allow_html') ? true : null;
						# process boolean validation rules
						$return = $this->_validate_string_rules($rule, $data);
					}

					return $this->_clean_value($return['post'], $allow_html); //this allows OR disallow HTML inputs
				} else {
					# incase anything goes wrong with the validation requirement
					return $post;
				}
			}
		}

		/* If post does not want actual validation in the function */ else {
			# return the array without validation
			return $post;
		}
	}

	public function error_messages($open_tag = '', $close_tag = '')
	{
		$return = null;
		if (!empty($this->errors)) {

			foreach ($this->errors as $key => $value) {
				$return .= $this->_error_message($value);
			}
		}

		return $return;
	}

	private function _error_message($message)
	{
		if ($this->wrapper === 'bootstrap') {
			$return = "<div class='alert alert-warning alert-dismissable fade show' role='alert'>\r\n";
		} else {
			$return = '<div>';
		}
		$return .= "{$message}\r\n";
		$return .= "</div>\r\n";

		return $return;
	}

	/********Protected Functions to ONLY be called by FormGenerator Class within*********/

	protected function _validate_bool_rules($rule, $data)
	{
		# the following rules evaluate the posted string

		if ($rule != 'required' && empty($data['post'])) {
			return;
		}

		# this rule must match a user-defined regex
		if (mb_substr($rule, 0, 5) == 'regex') {
			$rule = ltrim($rule, 'regex[');
			$rule = rtrim($rule, ']');

			if (preg_match($rule, $data['post'])) {
				$this->_validation_message($data, 'does not match the required parameters');
			}

			return $data['post'];
		}

		# this rule must *not* match a user-defined regex
		elseif (mb_substr($rule, 0, 9) == 'not_regex') {
			$rule = ltrim($rule, 'not_regex[');
			$rule = rtrim($rule, ']');

			if (!preg_match($rule, $data['post'])) {
				$this->_validation_message($data, 'can not be an exact match');
			}

			return $data['post'];
		}

		# match one field's contents to another
		elseif (mb_substr($rule, 0, 7) == 'matches') {
			preg_match_all("/\[(.*?)\]/", $rule, $matches);
			$match_field = $matches[1][0];

			if ($data['post'] != $_POST[$match_field]) {
				$this->_validation_message($data, ' does not match ' . $match_field);
			}

			return $data['post'];
		}

		# min length
		elseif (mb_substr($rule, 0, 10) == 'min_length' || mb_substr($rule, 0, 3) == 'min') {
			if (empty($data['post']) && !$this->_check_required($data['name'])) {
				return;
			}

			if (!$match = $this->_get_matches($rule)) {
				return $data['post'];
			}

			if (strlen($data['post']) < $match) {
				$this->_validation_message($data, 'must be at least ' . $match . ' characters');
			}

			return $data['post'];
		}

		# max length
		elseif (mb_substr($rule, 0, 10) == 'max_length' || mb_substr($rule, 0, 3) == 'max' || mb_substr($rule, 0, 2) == 'ml') {
			if (!$match = $this->_get_matches($rule)) {
				return $data['post'];
			}

			if ($this->is_not_empty($data['post']) && (strlen($data['post']) > $match)) {
				if ($match == 1 && strlen($data['post']) > 1) {
					$this->_validation_message($data, 'must be 1 character');
				} else {
					$this->_validation_message($data, 'can not be more than ' . $match . ' characters');
				}
			}

			return $data['post'];
		}

		# exact length
		elseif (mb_substr($rule, 0, 12) == 'exact_length' || mb_substr($rule, 0, 5) == 'exact' || mb_substr($rule, 0, 2) == 'el') {
			if (!$match = $this->_get_matches($rule)) {
				return $data['post'];
			}

			if (strlen($data['post']) != $match) {
				$this->_validation_message($data, 'must be exactly ' . $match . ' characters');
			}

			return $data['post'];
		}

		# less than or equal to (number)
		elseif (mb_substr($rule, 0, 18) == 'less_than_or_equal' || mb_substr($rule, 0, 3) == 'lte') {
			if (!is_numeric($data['post'])) {
				if (!empty($data['label'])) {
					$this->errors[$data['name']] = $data['label'] . ' must be a number';
				} else {
					$this->errors[$data['name']] = $data['name'] . ' must be a number';
				}

				return $data['post'];
			}

			if (!$match = $this->_get_matches($rule)) {
				return $data['post'];
			}

			if ($data['post'] > $match) {
				$this->_validation_message($data, 'must be less than, or equal to ' . $match);
			}

			return $data['post'];
		}

		# less than (number)
		elseif (mb_substr($rule, 0, 9) == 'less_than' || mb_substr($rule, 0, 2) == 'lt') {
			if (!is_numeric($data['post'])) {
				if (!empty($data['label'])) {
					$this->errors[$data['name']] = $data['label'] . ' must be a number';
				} else {
					$this->errors[$data['name']] = $data['name'] . ' must be a number';
				}

				return $data['post'];
			}

			if (!$match = $this->_get_matches($rule)) {
				return $data['post'];
			}

			if ($data['post'] >= $match) {
				$this->_validation_message($data, 'must be less than ' . $match);
			}

			return $data['post'];
		}

		# greater than or equal to (number)
		elseif (mb_substr($rule, 0, 21) == 'greater_than_or_equal' || mb_substr($rule, 0, 3) == 'gte') {
			if (!is_numeric($data['post'])) {
				if (!empty($data['label'])) {
					$this->errors[$data['name']] = $data['label'] . ' must be a number';
				} else {
					$this->errors[$data['name']] = $data['name'] . ' must be a number';
				}

				return $data['post'];
			}

			$match = $this->_get_matches($rule);

			if ($data['post'] < $match) {
				$this->_validation_message($data, 'must be greater than, or equal to ' . $match);
			}

			return $data['post'];
		}

		# greater than (number)
		elseif (mb_substr($rule, 0, 12) == 'greater_than' || mb_substr($rule, 0, 2) == 'gt') {
			if (!is_numeric($data['post'])) {
				if (!empty($data['label'])) {
					$this->errors[$data['name']] = $data['label'] . ' must be a number';
				} else {
					$this->errors[$data['name']] = $data['name'] . ' must be a number';
				}

				return $data['post'];
			}

			if (!$match = $this->_get_matches($rule)) {
				return $data['post'];
			}

			if ($data['post'] <= $match) {
				$this->_validation_message($data, 'must be greater than ' . $match);
			}

			return $data['post'];
		}

		# alpha
		elseif ($rule == 'alpha' && !ctype_alpha(str_replace(' ', '', $data['post']))) {

			$this->_validation_message($data, 'may only contain letters');

			return $data['post'];
		}

		# before (the current date)
		elseif ($rule == 'before' && strtotime($data['post']) > strtotime('now')) {

			$this->_validation_message($data, 'must be before ' . date($this->format_rule_dates, strtotime('now')));

			return $data['post'];
		}

		# after (the current date)
		elseif ($rule == 'after' && strtotime($data['post']) < strtotime('now')) {
			$this->_validation_message($data, 'must be after ' . date($this->format_rule_dates, strtotime('now')));
			return $data['post'];
		}

		# alphanumeric
		elseif ($rule == 'alpha_numeric' && !ctype_alnum(str_replace(' ', '', $data['post'])) || $rule == 'an' && !ctype_alnum(str_replace(' ', '', $data['post']))) {
			$this->_validation_message($data, 'may only contain letters and numbers');
			return $data['post'];
		}

		# alpha_dash
		elseif ($rule == 'alpha_dash' && preg_match('/[^A-Za-z0-9_-]/', $data['post']) || $rule == 'ad' && preg_match('/[^A-Za-z0-9_-]/', $data['post'])) {
			$this->_validation_message($data, 'may only contain letters, numbers, hyphens and underscores');
			return $data['post'];
		}

		# numeric
		elseif ($rule == 'numeric' && !is_numeric($data['post'])) {
			$this->_validation_message($data, 'must be a number or a numeric string');
			return $data['post'];
		}

		# integer
		elseif (($rule == 'int' || $rule == 'integer') && !filter_var($data['post'], FILTER_VALIDATE_INT)) {
			$this->_validation_message($data, 'must be a number');
			return $data['post'];
		}

		# valid email
		elseif ($rule == 'valid_email' && !filter_var($data['post'], FILTER_VALIDATE_EMAIL) || $rule == 'email' && !filter_var($data['post'], FILTER_VALIDATE_EMAIL)) {
			$this->_validation_message($data, 'not a valid email address');
			return $data['post'];
		}

		# required
		elseif ($rule == 'required' && !$this->is_not_empty($data['post'])) {
			$this->_validation_message($data, 'is required');
			return $data['post'];
		} elseif ($rule == 'allow_html' || $rule == 'html') {
			return $data['post'];
		} else {
			return $data['post'];
		}
	}

	protected function _validate_string_rules($rule, $string)
	{
		# the following rules manipulate the posted string

		# sanitize string
		if ($rule == 'sanitize_string') {
			return strip_tags($string);
		}

		# sanitize URL
		elseif ($rule == 'sanitize_url') {
			return filter_var($string, FILTER_SANITIZE_URL);
		}

		# sanitize email
		elseif ($rule == 'sanitize_email') {
			return filter_var($string, FILTER_SANITIZE_EMAIL);
		}

		# sanitize integer
		elseif ($rule == 'sanitize_int') {
			return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
		}

		# md5
		elseif ($rule == 'md5') {
			return md5($string . $this->salt);
		}

		# sha1
		elseif ($rule == 'sha1') {
			return sha1($string . $this->salt);
		}

		# php's password_hash() function
		elseif ($rule == 'hash') {
			return password_hash($string, PASSWORD_DEFAULT);
		}

		# strip everything but numbers
		elseif ($rule == 'strip_numeric') {
			return preg_replace("/[^0-9]/", '', $string);
		}

		# create twitter-style username
		elseif ($rule == 'slug') {
			return $this->slug($string);
		} else {
			return $string;
		}
	}

	protected function slug($str)
	{
		# allow only letters, numbers and underscores
		$return = str_replace('-', '_', $str);
		$return = str_replace(' ', '_', $return);
		$return = preg_replace('/[^A-Za-z0-9_]/', '', $return);

		return $return;
	}

	protected function _get_matches($rule)
	{
		preg_match_all("/\[(.*?)\]/", $rule, $matches);

		if (!isset($matches[1][0])) {
			return false;
		} else {
			return $matches[1][0];
		}
	}

	protected function _validation_message($data, $message)
	{
		# determines which message to display during validation
		if (!empty($data['string'])) {
			# display the user-defined validation message
			$this->errors[$data['name']] = $data['string'];
		} else {
			if (!empty($data['label'])) {
				# show the user-defined field name
				$this->errors[$data['name']] = $data['label'] . ' ' . $message;
			} else {
				# fallback to the field name
				$this->errors[$data['name']] = $data['name'] . ' ' . $message;
			}
		}
	}

	protected function _clean_value($str = '', $allow_html = false)
	{
		# return an empty value
		if ($str == '') {
			return '';
		}

		if (is_string($str)) {

			$str = trim($str);

			# perform basic sanitization...
			if ($allow_html == false) {
				# strip html tags and prevent against xss
				$str = strip_tags($str);
			} else {
				# allow html
				if ($this->sanitize_html) {
					$str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
				} else {
					$str = $str;
				}
			}
			return $str;
		} else {
			# clean and return the array
			foreach ($str as $value) {
				if ($allow_html == false) {
					# strip html tags and prevent against xss
					$value = strip_tags($value);
				} else {
					# allow html
					if ($this->sanitize_html) {
						$value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
					} else {
						$value = $value;
					}
				}
			}

			return $value;
		}
	}

	protected function is_not_empty($value)
	{
		# check if value is not empty - including zeros

		if (!empty($value) || (isset($value) && $value === "0") || (isset($value) && $value === 0)) {
			return true;
		} else {
			return false;
		}
	}

	protected function _check_required($name)
	{
		# checks the field name to see if that field is required

		$this->required_fields = array();

		# all fields are required
		if ($this->required === '*') {
			return true;
		}

		# required fields are set. determine which individual fields are required
		if ($this->required == true) {

			# get any required fields
			$required_fields = explode($this->delimiter[0], rtrim($this->required, '[]'));

			# get any omitted fields inside round brackets ()
			if (preg_match_all('#\((([^()]+|(?R))*)\)#', rtrim($this->required, '[]'), $matches)) {
				$fields = implode(',', $matches[1]);
				$omitted_fields = explode($this->delimiter[0], $fields);
			}

			# if the omitted_fields array in not empty...
			if (!empty($omitted_fields)) {
				if (in_array($name, $omitted_fields)) {
					# field name is not required
					return false;
				} else {
					# everything *but* this field is required
					return true;
				}
			}

			# field name is required
			if (in_array($name, $required_fields)) {
				return true;
			}
		} else {
			return false;
		}
	}
	/*****************************************************************/

	/******************* RESTful API for Forms Table **************/

	public function getForms()
	{
		$form_model = model(FormModel::class);

		$data = $form_model->getForms();

		return $data;
	}

	public function deleteForm($form_id)
	{
		$form_model = model(FormModel::class);

		return $form_model->where('form_id', $form_id)->delete();
	}

	public function updateForm($form_name, $form, $validation_rules)
	{
		$form_model = model(FormModel::class);
		$form_history_model = model(FormHistoryModel::class);

		$form_id = $form_model->getFormID($form_name);

		$current_form = $form_model->getForms($form_id);

		try {
			$form_history_model->save([
				'form_id' => $current_form['form_id'],
				'form_version' => $current_form['form_version'] + 0.1,
				'form_fields' => $form,
				'validation_rules' => $current_form['validation_rules'],
			]);

			$form_model->update($form_id, [
				'form_name' => $current_form['form_name'],
				'form_description' => $current_form['form_description'],
				'form_fields' => $form,
				'form_version' => $current_form['form_version'] + 0.1,
				'created_date' => $current_form['created_date'],
				'validation_rules' => $validation_rules,
				'slug' => url_title($current_form['form_name'], '-', true),
			]);
		} catch (\Exception $e) {
			exit($e->getMessage());

			return false;
		}

		return true;
	}

	/*****************************************************************/

	/******************* RESTful API for Form Submission Table **************/
	public function getFormSubmissions($form_id)
	{
		$form_submission_model = model(FormSubmissionModel::class);

		$data = $form_submission_model->getFormSubmissions($form_id);

		return $data;
	}

	public function deleteFormSubmission($form_id, $form_submission_id)
	{
		$form_submission_model = model(FormSubmissionModel::class);

		return $form_submission_model->where(['form_id' => (int) $form_id, 'form_submission_id' => (int) $form_submission_id])->delete();
	}

	/*****************************************************************/

	/******************* RESTful API for Form History Table **************/
	public function getFormHistory($form_id)
	{
		$form_history_model = model(FormHistoryModel::class);

		$data = $form_history_model->getFormsHistory($form_id);

		return $data;
	}

	public function deleteFormHistory($form_history_id)
	{
		$form_history_model = model(FormHistoryModel::class);

		return $form_history_model->where('form_history_id', $form_history_id)->delete();
	}
}
