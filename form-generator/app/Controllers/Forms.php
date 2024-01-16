<?php

namespace App\Controllers;

use App\Libraries\FormGenerator;
use CodeIgniter\Exceptions\PageNotFoundException;

class Forms extends BaseController
{
    protected $form;

    public function view($form_id = null, $form_history_id = null)
    {
        $this->form = new FormGenerator(service('request'));
        $this->form->set_wrapper('bootstrap');

        helper('form');
        $form_model = model(FormModel::class);
        $form_history_model = model(FormHistoryModel::class);

        $form_name = $form_model->getFormName($form_id)['form_name'];
        $form_latest_version = $form_model->getFormVersion($form_name)['form_version'];
        $form_current_version = null;

        $form_history = $this->form->get_form_history($form_name);
        
        if (empty($form_name)) {
            throw new PageNotFoundException('Cannot find form '. $form_id);
        }

        foreach ($form_history as $history_item) {
            $history[] = array(
                'form_version' => $history_item['form_version'],
                'form_history_id' => $history_item['form_history_id'],
            );
        }

        $form = $this->form->load_form($form_name);

        if (isset($form_history_id)) {
            $form = $this->form->load_form($form_name, $form_history_id);
            $form_current_version = $form_history_model->getFormHistoryFields($form_history_id)['form_version'];
        }

        $data = [
            'form' => $form,
            'current_form_id' => $form_id,
            'form_latest_version' => $form_latest_version,
            'form_current_version' => $form_current_version,
            'form_history_id' => $form_history_id,
            'forms' => $form_model->getForms(),
            'form_versions' => $history,
            'title' => $form_name,
            'errors' => $this->form->error_messages(),
        ];

        $this->form->upload_accepted_types = 'pdf';

        if ($this->form->submit()) {
            $validation_rules = $this->form->load_validation_rules($form_name);
            $this->form->validate_form($validation_rules);
            if ($this->form->post($form_name)) {
                return redirect()->to('/dashboard');
            }
            $data['errors'] = $this->form->error_messages();
        }

        return view('templates/header', $data)
            . view('forms/view')
            . view('templates/footer');
    }

    public function edit($id = null)
    {
        helper('form');

        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);
        $form_history_model = model(FormHistoryModel::class);
        
        $form_name = $form_model->getFormName($id);

        $form = $form_model->getForms($id);

        $data = [
            'form' => $this->form->load_edit_form($form_name),
            'form_rules' => $this->form->load_validation_rules($form_name),
            'forms' => $form_model->getForms(),
            'form_id' => $id,
        ];

        if (empty($data['form'])) {
            throw new PageNotFoundException('Cannot find form ' . $id);
        }

        if (! $this->request->is('post')) {
            return view('templates/header', $data)
                . view('forms/edit')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['form-edit', 'rules-edit']);

        $form_fields = $this->form->encrypt($post['form-edit']);

        $form_rules = json_decode($post['rules-edit'], true);
        $form_rules = serialize($form_rules);

        $validation_rules = $this->form->encrypt($form_rules);

        $this->form->updateForm($form_name, $form_fields, $validation_rules);

        return redirect()->to('/dashboard');
    }

    public function delete_confirmation($id = null)
    {
        $form_model = model(FormModel::class);

        $data = [
            'forms' => $form_model->getForms(),
            'id' => $id,
        ];

        return view('templates/header', $data)
            . view('forms/delete_confirmation')
            . view('templates/footer');
    }

    public function delete($id = null)
    {
        $form_model = model(FormModel::class);

        $form_model->where('form_id', $id)->delete();

        return redirect()->to('/dashboard');
    }

    public function revert($form_id, $form_history_id)
    {
        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);
        $form_history_model = model(FormHistoryModel::class);

        $form = $form_model->getForms($form_id);
        $form_name = $form_model->getFormName($form_id);
        $form_fields = $this->form->load_form($form_name, $form_history_id);
        $form_fields = $this->form->encrypt($form_fields);

        $form_history_model->save([
            'form_id' => $form['form_id'],
            'form_version' => $form['form_version'] + 0.1,
            'form_fields' => $form_fields,
        ]);

        $form_model->update($form_id, [
            'form_name' => $form['form_name'],
            'form_description' => $form['form_description'],
            'form_fields' => $form_fields,
            'form_version' => $form['form_version'] + 0.1,
            'created_date' => $form['created_date'],
            'validation_rules' => $form['validation_rules'],
            'slug' => url_title($form['form_name'], '-', true),
        ]);

        return redirect()->to('/dashboard');
    }

    public function print($id = null)
    {
        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);

        $form_name = $form_model->getFormName($id)['form_name'];
        $data = [
            'form' => $this->form->load_form($form_name),
            'forms' => $form_model->getForms(),
            'title' => $form_name,
        ];

        return view('templates/header', $data)
            . view('forms/print')
            . view('templates/footer');
    }

    public function custom_form()
    {
        $this->form = new FormGenerator(service('request'));

        $form_model = model(FormModel::class);

        $this->form->set_wrapper('bootstrap');

        $rules = [
            'first_name' => ['First Name', 'required|min_length[3]'],
            'last_name' => ['Last Name' ,'required|min_length[3]'],
        ];

        $form = $this->form->open_file_upload();
        $form .= $this->form->csrf_placeholder();
        $form .= $this->form->honeypot();
        $form .= $this->form->text("first_name", 'First Name');
        $form .= $this->form->text("last_name", "Last Name");
        $form .= $this->form->file('signature', 'Upload Signature');
        $form .= $this->form->button();

        $form .= $this->form->close();

        $this->form->save("one more another testing form", "Just another form", $form, $rules);
        // $this->form->save('just another test again', 'File validation test new', $form);

        $data = [
            'forms' => $form_model->getForms(),
            'form' => $form,
            'errors' => null,
        ];
        
        $this->form->required = '*';
        $this->form->upload_accepted_types = 'tsv';

        if ($this->form->submit())
        {
            $first_name = $this->form->validate_post('first_name', 'First Name', 'required|min_length[3]');
            $last_name = $this->form->validate_post('last_name', 'Last Name', 'required|min_length[3]');
            $file = $this->form->validate_post('signature', 'Signature', 'required', true);
            // $this->form->validate_and_upload_files('signature', 'Signature', true);
            if ($this->form->errors() != false) {
                $data['errors'] = $this->form->error_messages();
            }
        }

        return view('templates/header', $data)
            . view('forms/custom_form')
            . view('templates/footer');
    }


    public function finance_form() 
	{
		$form_model = model(FormModel::class);

        $this->form = new FormGenerator(service('request'));
        $this->form->set_wrapper('bootstrap');

		$this->form->upload_accepted_types = 'images';

        if ($this->form->submit())
        {
			# Validation Rules
			$this->form->validate_post('first-name-1', 'First Name', 'required');
			$data = $this->form->validate('First Name 1(required), Last Name 1(required), Your Signature(required|file)');
			// $this->form->validate_post('filing_status', 'Filing Status', 'required');
            // $this->form->validate_post('last-name-1', 'Last Name', 'required');
			// $this->form->validate_post('social-security-1', 'Social Security Number', 'required');

			// $this->form->validate_post('address', 'Address', 'required');
			// $this->form->validate_post('apt-no', 'Apartment Number', 'required');
			// $this->form->validate_post('city', 'City', 'required');
            // $this->form->validate_post('state', 'State', 'required');
			// $this->form->validate_post('zip', 'Zip', 'required');

			// $this->form->validate_post('income-1a', '1a)', 'required');
			// $this->form->validate_post('income-1b', '1b)', 'required');
			// $this->form->validate_post('income-1c', '1c)', 'required');
			// $this->form->validate_post('income-1d', '1d)', 'required');
			// $this->form->validate_post('income-1f', '1f)', 'required');
			// $this->form->validate_post('income-1g', '1g)', 'required');
			// $this->form->validate_post('income-1h', '1h)', 'required');
			// $this->form->validate_post('income-1i', '1i)', 'required');
			// $this->form->validate_post('income-1z', '1z)', 'required');

			// $this->form->validate_post('income-2a', '2a)', 'required');
			// $this->form->validate_post('income-2b', '2b)', 'required');
			// $this->form->validate_post('income-3a', '3a)', 'required');

			// $this->form->validate_post('income-3b', '3b)', 'required');
			// $this->form->validate_post('income-4a', '4a)', 'required');
			// $this->form->validate_post('income-4b', '4b)', 'required');
			// $this->form->validate_post('income-5a', '5a)', 'required');
			// $this->form->validate_post('income-5b', '5b)', 'required');

			// $this->form->validate_post('income-6a', '6a)', 'required');
			// $this->form->validate_post('income-6b', '6b)', 'required');
			// $this->form->validate_post('income-6c', '6c)', 'required');

			// $this->form->validate_post('income-9', '9)', 'required');
			// $this->form->validate_post('income-10', '10)', 'required');
			// $this->form->validate_post('income-11', '11)', 'required');
			// $this->form->validate_post('income-12', '12)', 'required');
			// $this->form->validate_post('income-13', '13)', 'required');
			// $this->form->validate_post('income-14', '14)', 'required');
			// $this->form->validate_post('income-15', '15)', 'required');

			// $this->form->validate_post('tax-16', '16)', 'required');
			// $this->form->validate_post('tax-17', '17)', 'required');
			// $this->form->validate_post('tax-18', '18)', 'required');
			// $this->form->validate_post('tax-19', '19)', 'required');
			// $this->form->validate_post('tax-20', '20)', 'required');
			// $this->form->validate_post('tax-21', '21)', 'required');
			// $this->form->validate_post('tax-22', '22)', 'required');
			// $this->form->validate_post('tax-23', '23)', 'required');
			// $this->form->validate_post('tax-24', '24)', 'required');

			// $this->form->validate_post('tax-25a', '25a)', 'required');
			// $this->form->validate_post('tax-25b', '25b)', 'required');
			// $this->form->validate_post('tax-25c', '25c)', 'required');
			// $this->form->validate_post('tax-25d', '25d)', 'required');
			// $this->form->validate_post('tax-26', '26)', 'required');
			// $this->form->validate_post('tax-27', '27)', 'required');
			// $this->form->validate_post('tax-28', '28)', 'required');
			// $this->form->validate_post('tax-29', '29)', 'required');
			// $this->form->validate_post('tax-30', '30)', 'required');
			// $this->form->validate_post('tax-31', '31)', 'required');
			// $this->form->validate_post('tax-32', '32)', 'required');
			// $this->form->validate_post('tax-33', '33)', 'required');

			// $this->form->validate_post('amnount-you-owe-37', '37)', 'required');
			// $this->form->validate_post('amount-you-owe-38', '38)', 'required');

			// $this->form->validate_post('your-signature', 'Your Siganture', 'required', true);
			// $this->form->validate_post('your-signature-date', 'Your Siganture Date', 'required');
			// $this->form->validate_post('your-occupation', 'Your Occupation', 'required');

			// $this->form->validate_post('your-phone-no', 'Phone Number', 'required');
			// $this->form->validate_post('your-email', 'Your Email', 'required');



            $form_data = $this->form->post();
            if ($form_data == false) {
                $data['errors'] = $this->form->error_messages();
            }
        }


        $form = $this->form->open_file_upload();

        $form .= $this->form->heading('1040-form', '1040 Form');

        $filingStatusOptions = [
			null => 'Select an option',
			'single' => 'Single',
			'married-filing-jointly' => 'Married Filing Jointly',
			'married-filing-separetely' => 'Married Filing Seperately (MFS)',
			'head-of-household' => 'Head of Household (HOH)',
			'qualifying-surviving-spouse' => 'Qualifying Surviving Spouse (QSS)',
		];

        $form .= $this->form->select('filing_status', 'Filing Status', null, null, null, null, $filingStatusOptions);
		$form .= $this->form->text('filing-status-spouse', 'If you selected MFS, enter the name of your spouse. If you selected HOH or QSS, enter the child\'s name if the qualifying person is a child but not your dependent', null, null);
		$form .= $this->form->text('first_name_1', 'Your first name and middle initial', null, null);
		$form .= $this->form->text('last_name_1', 'Last name', null, null);
		$form .= $this->form->number('social-security-1', 'Your social security number', null, null);
		$form .= $this->form->text('first-name-2', 'If joint return, spouse\'s first name and middle initial', null, null);
		$form .= $this->form->text('last-name-2', 'Last name', null, null);
		$form .= $this->form->number('social-security-2', 'Spouse\'s social security number', null, null);

        $form .= $this->form->text('address', 'Home address (number and street).', null, null);
		$form .= $this->form->text('apt-no', 'Apt. no.', null, null);
		$form .= $this->form->text('city', 'City, town, or post office', null, null);
		$form .= $this->form->text('state', 'State', null, null);
		$form .= $this->form->text('zip', 'Zip code', null, null);
		$form .= $this->form->open_div();
		$form .= $this->form->label('foreign-country', 'If you have a foreign address, also complete the fields below:');
		$form .= $this->form->close_div();
		$form .= $this->form->text('foreign-country', 'Foreign Country Name', null, null);
		$form .= $this->form->text('foreign-state', 'Foreign province/state/country', null, null);
		$form .= $this->form->text('foreign-postal', 'Foreign postal code', null, null);

        $form .= $this->form->heading('predidential-election-campaign', 'Presidential Election Campaign');

		$form .= $this->form->label('presdential-election-campaign', 'Check here if you, or your spouse is filing jointly, want $3 to go to this fund. Checking a box below will not change your tax or refund.', null, null);
		$form .= $this->form->line_break();
		$form .= $this->form->select_multiple('presidential-election-campaign', 'Select if you, or your spouse is filing jointly, want $3 to go to this fund. Selecting a value will not change your tax or refund', null, null, 'class="form-select"', null, ["none" => "None", "you" => "You", "spouse" => "Spouse"]);

		$form .= $this->form->heading('digital-assets', 'Digital Assets');
		$form .= $this->form->checkbox('digital-assets', 'At any time during 2022, did you: (a) receive (as a reward, award, or payment for property or service); or (b) sell, exchange, gift, or otherwaise dispose of a digital asset (or a financial interest in a digital asset)? (See instructions.)');

		$form .= $this->form->heading('standard-deduction', 'Standard Deduction', null, null);
		$form .= $this->form->select_multiple('digital-assets', 'Someone can claim', null, null, 'class="form-select"', null, ["none" => "None", "you" => "You as a dependent", "spouse" => "Your spouse as a dependent", "alien" => "Spouse itemizes on a separate return or you were a dual-status alien"]);

		$form .= $this->form->heading('age-blindness', 'Age/Blindness', null, null);
		$form .= $this->form->select_multiple('age-blindness', 'You:', null, null, 'class="form-select"', null, ["you-born-before" => 'Were born before January 2, 1958', "you-blind" => "Are blind"]);
		$form .= $this->form->select_multiple('age-blindness', 'Spouse:', null, null, 'class="form-select"', null, ["spouse-born-before" => 'Was born before January 2, 1958', "spouse-blind" => "Is blind"]);


		$form .= $this->form->heading('dependents', 'Dependents', null, null);
		$form .= $this->form->open_tag('table', null, 'class="table"');
		$form .= $this->form->open_tag('thead');
		$form .= $this->form->open_tag('tr');

		$form .= $this->form->open_tag('th', "First Name", "scope='col'");
		$form .= $this->form->close_tag('th');

		$form .= $this->form->open_tag('th', "Last Name", "scope='col'");
		$form .= $this->form->close_tag('th');

		$form .= $this->form->open_tag('th', "Social Security Number", "scope='col'");
		$form .= $this->form->close_tag('th');

		$form .= $this->form->open_tag('th', "Relationship to you", "scope='col'");
		$form .= $this->form->close_tag('th');

		$form .= $this->form->open_tag('th', "Qualifies for child tax credit", "scope='col'");
		$form .= $this->form->close_tag('th');

		$form .= $this->form->open_tag('th', "Qualitifies for Credit for other dependents", "scope='col'");
		$form .= $this->form->close_tag('th');

		$form .= $this->form->close_tag('tr');
		$form .= $this->form->close_tag('thead');

		$form .= $this->form->open_tag('tbody');

		$form .= $this->form->open_tag('tr');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-first-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-last-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-social-sec-num[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-relationship[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-child-tax-credit[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->close_tag('tr');

		$form .= $this->form->open_tag('tr');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-first-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-last-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-social-sec-num[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-relationship[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-child-tax-credit[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->close_tag('tr');

		$form .= $this->form->open_tag('tr');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-first-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-last-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-social-sec-num[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-relationship[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-child-tax-credit[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->close_tag('tr');

		$form .= $this->form->open_tag('tr');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-first-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-last-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-social-sec-num[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-relationship[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-child-tax-credit[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->close_tag('tr');

		$form .= $this->form->open_tag('tr');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-first-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-last-name[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-social-sec-num[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->text('dependents-relationship[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-child-tax-credit[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->open_tag('td');
		$form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		$form .= $this->form->close_tag('td');

		$form .= $this->form->close_tag('tr');

		$form .= $this->form->close_tag('tbody');
		$form .= $this->form->close_tag('table');
		
		$form .= $this->form->line_break();
		$form .= $this->form->line_break();

		$form .= $this->form->heading('income', 'Income');
		$form .= $this->form->text('income-1a', '1a) Total amount from Form(s) W-2, box 1 (see instructions):', null, null);
		$form .= $this->form->text('income-1b', '1b) Household employee wages not reported on Form(s) W-2:', null, null);
		$form .= $this->form->text('income-1c', '1c) Tip income not reported on line 1a(see instructions):', null, null);
		$form .= $this->form->text('income-1d', '1d) Medicaid waiver payments not reported on Form(s) W-2 (see instructions):', null, null);
		$form .= $this->form->text('income-1e', '1e) Taxable dependent care benefits from Form 2441, line 26:', null, null);
		$form .= $this->form->text('income-1f', '1f) Employer-provided adoption benefits from Form 8839, line 29:', null, null);
		$form .= $this->form->text('income-1g', '1g) Wages from Form 8919, line 6:', null, null);
		$form .= $this->form->text('income-1h', '1h) Other earned income (see instructions):', null, null);
		$form .= $this->form->text('income-1i', '1i) Nontaxable combat pay election (see instructions):', null, null);
		$form .= $this->form->text('income-1z', '1z) Add lines 1a through 1h:', null, null);
		$form .= $this->form->text('income-2a', '2a) Tax-exempt interest:', null, null);
		$form .= $this->form->text('income-2b', '2b) Taxable interest:', null, null);
		$form .= $this->form->text('income-3a', '3a) Qualified dividends:', null, null);
		$form .= $this->form->text('income-3b', '3b) Ordinary dividends:', null, null);
		$form .= $this->form->text('income-4a', '4a) IRA distributions:', null, null);
		$form .= $this->form->text('income-4b', '4b) Taxable amount:', null, null);
		$form .= $this->form->text('income-5a', '5a) Pensions and annuities:', null, null);
		$form .= $this->form->text('income-5b', '5b) Taxable amount:', null, null);
		$form .= $this->form->text('income-6a', '6a) Social security benefits:', null, null);
		$form .= $this->form->text('income-6b', '6b) Taxable amount:', null, null);
		$form .= $this->form->checkbox('income-6c', '6c) If you elect to use the lump-sum election method, check here (see instructions):');
		$form .= $this->form->text('income-6c', null, null, null, 'class="form-control" placeholder="6c"');
		$form .= $this->form->checkbox('income-7', '7) Capital gain or (loss). Attach Schedule D if required. If not required, check here:');
		$form .= $this->form->text('income-7', null, null, null, 'class="form-control" placeholder="7"');
		$form .= $this->form->text('income-8', '8) Other income from Schedule 1, line 10:', null, null);
		$form .= $this->form->text('income-9', '9) Add lines 1z, 2b, 3b, 4b, 5b, 6b, 7, and 8. This is your total income:', null, null);
		$form .= $this->form->text('income-10', '10) Adjustments to income from Schedule 1, line 26:', null, null);
		$form .= $this->form->text('income-11', '11) Subtract line 10 from line 9. This is your adjusted gross income:', null, null);
		$form .= $this->form->text('income-12', '12) Standard deduction or itemized deductions (from Schedule A):', null, null);
		$form .= $this->form->text('income-13', '13) Qualified business income deduction from Form 8995 or Form 8995-A:', null, null);
		$form .= $this->form->number('income-14', '14) Add lines 12 and 13:', null, null);
		$form .= $this->form->number('income-15', '15) Subtract line 14 from line 11. If zero or less, enter -0-. This is your taxable income:', null, null);

		$form .= $this->form->heading('tax-and-credits', 'Tax and Credits');
		$form .= $this->form->text('tax-16', '16) Tax(see instructions). Check if any form Form(s):', null, null);
		$form .= $this->form->checkbox('tax-16-1', '8814');
		$form .= $this->form->checkbox('tax-16-2', '4972');
        $form .= $this->form->open_div('d-flex');
		$form .= $this->form->checkbox('tax-16-3-chkbox', '');
		$form .= $this->form->text('tax-16-3-txt', '');
        $form .= $this->form->close_div();
		$form .= $this->form->line_break();
		$form .= $this->form->number('tax-17', '17) Amount from Schedule 2, line 3:', null, null);
		$form .= $this->form->number('tax-18', '18) Add lines 16 and 17:', null, null);
		$form .= $this->form->number('tax-19', '19) Child tax credit or credit for other dependants from Schedule 8812:', null, null);
		$form .= $this->form->number('tax-20', '20) Amount from Schedule 3, line 8:', null, null);
		$form .= $this->form->number('tax-21', '21) Add lines 19 and 20:', null, null);
		$form .= $this->form->number('tax-22', '22) Subtract line 21 from line 18. If zero or less enter -0-:', null, null);
		$form .= $this->form->number('tax-23', '23) Other taxes, including self-employment taxm frin Schedule 2, line 21:', null, null);
		$form .= $this->form->number('tax-24', '24) Add lines 22 and 23. This is your total tax:', null, null);

		$form .= $this->form->heading('payments', 'Payments');
		$form .= $this->form->label('federal-tax-withheld', 'Federal income tax withheld from:', null, null);
		$form .= $this->form->line_break();
		$form .= $this->form->number('tax-25a', '25a) Form(s) W-2:', null, null);
		$form .= $this->form->number('tax-25b', '25b) Form(s) 1099:', null, null);
		$form .= $this->form->number('tax-25c', '25c) Other forms (see instructions):', null, null);
		$form .= $this->form->number('tax-25d', '25d) Add lines 25a through 25c:', null, null);
		$form .= $this->form->number('tax-26', '26) 2022 estimated tax payments and amount applied from 2021 return:', null, null);
		$form .= $this->form->number('tax-27', '27) Earned income credit (EIC):', null, null);
		$form .= $this->form->number('tax-28', '28) Additional child tax credit from Schedule 8812:', null, null);
		$form .= $this->form->number('tax-29', '29) American opportunity credit from Form 8863, line 8:', null, null);
		$form .= $this->form->number('tax-30', '30) Reserved for future use:', null, null, 'class="form-control" disabled');
		$form .= $this->form->number('tax-31', '31) Amount from Schedule 3, line 15:', null, null);
		$form .= $this->form->number('tax-32', '32) Add lines 27, 28, 29, 31. These are your total other payments and refundable credits:', null, null);
		$form .= $this->form->number('tax-33', '33) Add lines 25d, 26, 32. These are your total payments:', null, null);

		$form .= $this->form->heading('refund', 'Refund');
		$form .= $this->form->number('refund-34', '34) If line 33 is more than line 24, subtract line 24 from 33. This is the amount you overpaid:', null, null);
		$form .= $this->form->label('refund-35a-lbl', 'Amount of line 34 you want refunded to you.', null, null);
		$form .= $this->form->checkbox('refund-35a-chkbox', 'If Form 8888 is attached, check here');
		$form .= $this->form->text('refund-35a-txt', '');
		$form .= $this->form->line_break();
		$form .= $this->form->number('refund-35b', '35b) Routing number:', null, null);
		$form .= $this->form->label('refund-35c-lbl', 'Type:', null, null);
		$form .= $this->form->checkbox('refund-35c-checking-chkbox', 'Checking');
		$form .= $this->form->checkbox('refund-35c-savings-chkbox', 'Savings');
		$form .= $this->form->number('refund-35d', '35d) Account number:', null, null);
		$form .= $this->form->number('refund-36', '36) Amount of line 34 you want applied to your 2023 estimated tax:', null, null);

		$form .= $this->form->heading('amount-you-owe', 'Amount You Owe');
		$form .= $this->form->number('amount-you-owe-37', '37) Subtract line 33 from line 24. This is the amount you owe. For details on how to pay, go to www.irs/gov/Payments or see instructions:', null, null);
		$form .= $this->form->number('amount-you-owe-38', '38) Estimated tax penalty (see instructions):', null, null);

		$form .= $this->form->heading('third-party-designee', 'Third Party Designee');
		$form .= $this->form->label('third-party-designee-lbl', 'Do you want to allow another person to discuss this return with the IRS? See instructions:', null, null);
		$form .= $this->form->checkbox('third-party-designee-yes', 'Yes. Complete below.');
		$form .= $this->form->checkbox('third-party-designee-no', 'No');
		$form .= $this->form->line_break();
		$form .= $this->form->text('third-party-designee-name', 'Designee\'s name', null, null);
		$form .= $this->form->text('third-party-designee-phoneno', 'Phone no.', null, null);
		$form .= $this->form->text('third-party-designee-pin', 'Personal identification number (PIN)', null, null);

		$form .= $this->form->heading('sign-here', 'Sign Here');
		$form .= $this->form->label('sign-here-lbl', 'Under penalties of perjury, I declare that I have examined this return and accompanying schedules and statements, and to the best of my knowledge and belief, they are true, correct, and complete. Declaration of preparer (other than taxpayer) is based on all information of which preparer has any knowledge.', null, null);
		$form .= $this->form->file('your_signature', 'Your signature');
		$form .= $this->form->date('your-signature-date', 'Date', null, null);
		$form .= $this->form->text('your-occupation', 'Your occupation', null, null);
		$form .= $this->form->number('your-identity-protection-pin', 'If the IRS sent you an Identity Protection Pin, enter it here (see instructions):', null, null);
		$form .= $this->form->file('spouse-signature', 'Spouse\'s signature. If a joint return, both must sign');
		$form .= $this->form->date('spouse-signature-date', 'Date', null, null);
		$form .= $this->form->text('spouse-occupation', 'Spouse\'s occupation', null, null);
		$form .= $this->form->number('spouse-identity-protection-pin', 'If the IRS sent you an Identity Protection Pin, enter it here (see instructions):', null, null);
		$form .= $this->form->number('your-phone-no', 'Phone no.:', null, null);
		$form .= $this->form->email('your-email', 'Email address:', null, null);

		$form .= $this->form->heading('paid-preparer', 'Paid Preparer Use Only');
		$form .= $this->form->text('preparer-name', 'Preparer\'s name', null, null);
		$form .= $this->form->file('preparer-signature', 'Preparer\'s signature');
		$form .= $this->form->date('preparer-signature-date', 'Date', null, null);
		$form .= $this->form->date('preparer-signature-ptin', 'PTIN', null, null);
		$form .= $this->form->label('preparer-check', 'Check if:', null, null);
		$form .= $this->form->checkbox('preparer-self-employed', 'Self-employed.');
		$form .= $this->form->text('preparer-firm-name', 'Firm\'s name', null, null);
		$form .= $this->form->text('preparer-firm-address', 'Firm\'s address', null, null);
		$form .= $this->form->number('firm-phone-no', 'Phone no.:', null, null);
		$form .= $this->form->text('preparer-firm-ein', 'Firm\'s EIN', null, null);

        $form .= $this->form->button();

		$data['forms'] = $form_model->getForms();
        $data['form'] = $form;

		return view('templates/header', $data)
			. view('user/1040')
			. view('templates/footer');
	}

	public function report_form()
	{
		$form_model = model(FormModel::class);

		$this->form = new FormGenerator(service('request'));

		// $form = $this->form->load_form('simple contact form');

		// if ($this->form->submit()) {
		// 	$validation_rules = $this->form->load_validation_rules('simple contact form');
		// 	$this->form->validate_form($validation_rules);

		// 	if ($this->form->post('simple contact form')) {
		// 		return redirect()->to('/dashboard');
		// 	}
		// 	$data['errors'] = $this->form->error_messages();
		// }

		$this->form->set_wrapper('bootstrap');

		$form = $this->form->open_file_upload();

		$form .= $this->form->text('email', 'Email Address');
		$form .= $this->form->textarea('message', 'Message');
		$form .= $this->form->file('signature', 'Signature');
		$form .= $this->form->button();

		$form .= $this->form->close();

		// $this->form->send_email("yujietan84@gmail.com", "Hello Test Email", "Hello this is for Web Programming Recording", "yujietan84@gmail.com", "Yu Jie");

		$validation_rules = [
			'email' => ["Email","required|valid_email"],
			'message' => ['Message','required|min_length[5]'],
			'signature' => ['Signature','required|file'],
		];

		// $this->form->save('simple contact form', 'Just a Simple Contact Form', $form, $validation_rules);

		// if ($this->form->submit())
		// {
		// 	$data = $this->form->validate('Email(valid_email), Message');
		// 	if ($this->form->ok())
		// 	{

		// 	}
		// }

		$data = [
			'forms' => $form_model->getForms(),
			'form' => $form,
			'errors' => $this->form->error_messages(),
		];

		return view('templates/header', $data)
			. view('user/report_form')
			. view('templates/footer');
	}
}

?>
