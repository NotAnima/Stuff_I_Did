<?php

namespace App\Controllers;

use App\Libraries\FormGenerator;
use App\Models\FormModel;
use App\Models\FormHistoryModel;
use App\Models\FormSubmissionModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use DOMDocument;
use DOMXPath;

class Users extends BaseController
{
	protected $form;

	function __construct()
	{
		$this->form = new FormGenerator(service('request'));
	}

	public function index()
	{
		$model = model(FormModel::class);

		$data = [
			'title' => 'Form Generator Dashboard',
			'forms' => $model->getForms(),
		];
		return view('templates/header', $data)
			. view('user/dashboard')
			. view('templates/footer');
	}

	public function newform()
	{
		$this->form->set_wrapper('bootstrap');
		$form = $this->form->open();

		$form .= $this->form->text('first-name', 'First Name:');
		$form .= $this->form->text('email', 'Email Address');
		$form .= $this->form->textarea('message', 'Message');
		$form .= $this->form->button();

		$form .= $this->form->close();

		$validation_rules = [
			'Email' => "required|valid_email",
			'Message' => 'required|min_length[5]',
		];
		$this->form->save('simple email form', 'Just a Simple Form', $form, $validation_rules);
		$data['form'] = $form;
		$data['title'] = 'Forms';
		return view('/user/form', $data);
	}

	public function form()
	{
		$model = model(FormModel::class);
		$this->form->set_wrapper('bootstrap');
		$form = $this->form->open();
		$filingStatusOptions = [
			'single' => 'Single',
			'married-filing-jointly' => 'Married Filing Jointly',
			'married-filing-separetely' => 'Married Filing Seperately (MFS)',
			'head-of-household' => 'Head of Household (HOH)',
			'qualifying-surviving-spouse' => 'Qualifying Surviving Spouse (QSS)',
		];

		// $this->form->send_email("yujietan84@gmail.com", "Testing", "Hello from Form generator", "yujietan84@gmail.com", "its ya boy top g");
		d($this->form->errors);
		d($this->form->success);
		$form .= $this->form->select('filing_status', 'Filing Status', null, null, null, null, $filingStatusOptions);
		// $form .= $this->form->text('filing-status-spouse', 'If you selected MFS, enter the name of your spouse. If you selected HOH or QSS, enter the child\'s name if the qualifying person is a child but not your dependent', null, null);
		// $form .= $this->form->text('first-name-1', 'Your first name and middle initial', null, null);
		// $form .= $this->form->text('last-name-1', 'Last name', null, null);
		// $form .= $this->form->number('social-security-1', 'Your social security number', null, null);
		// $form .= $this->form->text('first-name-2', 'If joint return, spouse\'s first name and middle initial', null, null);
		// $form .= $this->form->text('last-name-2', 'Last name', null, null);
		// $form .= $this->form->number('social-security-2', 'Spouse\'s social security number', null, null);

		// $form .= $this->form->text('address', 'Home address (number and street).', null, null);
		// $form .= $this->form->text('apt-no', 'Apt. no.', null, null);
		// $form .= $this->form->text('city', 'City, town, or post office. If you have a foreign address, also complete the fields below', null, null);
		// $form .= $this->form->text('state', 'State', null, null);
		// $form .= $this->form->text('zip', 'Zip code', null, null);
		// $form .= $this->form->text('foreign-country', 'Foreign Country Name', null, null);
		// $form .= $this->form->text('foreign-state', 'Foreign province/state/country', null, null);
		// $form .= $this->form->text('foreign-postal', 'Foreign postal code', null, null);

		// $form .= $this->form->heading('predidential-election-campaign', 'Presidential Election Campaign');

		// $form .= $this->form->label('presdential-election-campaign', 'Check here if you, or your spouse is filing jointly, want $3 to go to this fund. Checking a box below will not change your tax or refund.', null, null);
		// $form .= $this->form->line_break();
		// $form .= $this->form->select_multiple('presidential-election-campaign', 'Select if you, or your spouse is filing jointly, want $3 to go to this fund. Selecting a value will not change your tax or refund', null, null, 'class="form-select"', null, ["none" => "None", "you" => "You", "spouse" => "Spouse"]);

		// $form .= $this->form->heading('digital-assets', 'Digital Assets');
		// $form .= $this->form->checkbox('digital-assets', 'At any time during 2022, did you: (a) receive (as a reward, award, or payment for property or service); or (b) sell, exchange, gift, or otherwaise dispose of a digital asset (or a financial interest in a digital asset)? (See instructions.)');

		// $form .= $this->form->heading('standard-deduction', 'Standard Deduction', null, null);
		// $form .= $this->form->select_multiple('digital-assets', 'Someone can claim', null, null, 'class="form-select"', null, ["none" => "None", "you" => "You as a dependent", "spouse" => "Your spouse as a dependent", "alien" => "Spouse itemizes on a separate return or you were a dual-status alien"]);

		// $form .= $this->form->heading('age-blindness', 'Age/Blindness', null, null);
		// $form .= $this->form->select_multiple('age-blindness', 'You:', null, null, 'class="form-select"', null, ["you-born-before" => 'Were born before January 2, 1958', "you-blind" => "Are blind"]);
		// $form .= $this->form->select_multiple('age-blindness', 'Spouse:', null, null, 'class="form-select"', null, ["spouse-born-before" => 'Was born before January 2, 1958', "spouse-blind" => "Is blind"]);


		// $form .= $this->form->heading('dependents', 'Dependents', null, null);
		// $form .= $this->form->open_tag('table', null, 'class="table"');
		// $form .= $this->form->open_tag('thead');
		// $form .= $this->form->open_tag('tr');

		// $form .= $this->form->open_tag('th', "First Name", "scope='col'");
		// $form .= $this->form->close_tag('th');

		// $form .= $this->form->open_tag('th', "Last Name", "scope='col'");
		// $form .= $this->form->close_tag('th');

		// $form .= $this->form->open_tag('th', "Social Security Number", "scope='col'");
		// $form .= $this->form->close_tag('th');

		// $form .= $this->form->open_tag('th', "Relationship to you", "scope='col'");
		// $form .= $this->form->close_tag('th');

		// $form .= $this->form->open_tag('th', "Qualifies for child tax credit", "scope='col'");
		// $form .= $this->form->close_tag('th');

		// $form .= $this->form->open_tag('th', "Qualitifies for Credit for other dependents", "scope='col'");
		// $form .= $this->form->close_tag('th');

		// $form .= $this->form->close_tag('tr');
		// $form .= $this->form->close_tag('thead');

		// $form .= $this->form->open_tag('tbody');

		// $form .= $this->form->open_tag('tr');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-first-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-last-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-social-sec-num[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-relationship[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-child-tax-credit[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->close_tag('tr');

		// $form .= $this->form->open_tag('tr');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-first-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-last-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-social-sec-num[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-relationship[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-child-tax-credit[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->close_tag('tr');

		// $form .= $this->form->open_tag('tr');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-first-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-last-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-social-sec-num[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-relationship[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-child-tax-credit[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->close_tag('tr');

		// $form .= $this->form->open_tag('tr');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-first-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-last-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-social-sec-num[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-relationship[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-child-tax-credit[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->close_tag('tr');

		// $form .= $this->form->open_tag('tr');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-first-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-last-name[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-social-sec-num[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->text('dependents-relationship[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-child-tax-credit[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->open_tag('td');
		// $form .= $this->form->checkbox('dependents-credit-for-other-dependents[]');
		// $form .= $this->form->close_tag('td');

		// $form .= $this->form->close_tag('tr');

		// $form .= $this->form->close_tag('tbody');
		// $form .= $this->form->close_tag('table');

		// $form .= $this->form->line_break();
		// $form .= $this->form->line_break();

		// $form .= $this->form->heading('income', 'Income');
		// $form .= $this->form->text('income-1a', '1a) Total amount from Form(s) W-2, box 1 (see instructions):', null, null);
		// $form .= $this->form->text('income-1b', '1b) Household employee wages not reported on Form(s) W-2:', null, null);
		// $form .= $this->form->text('income-1c', '1c) Tip income not reported on line 1a(see instructions):', null, null);
		// $form .= $this->form->text('income-1d', '1d) Medicaid waiver payments not reported on Form(s) W-2 (see instructions):', null, null);
		// $form .= $this->form->text('income-1e', '1e) Taxable dependent care benefits from Form 2441, line 26:', null, null);
		// $form .= $this->form->text('income-1f', '1f) Employer-provided adoption benefits from Form 8839, line 29:', null, null);
		// $form .= $this->form->text('income-1g', '1g) Wages from Form 8919, line 6:', null, null);
		// $form .= $this->form->text('income-1h', '1h) Other earned income (see instructions):', null, null);
		// $form .= $this->form->text('income-1i', '1i) Nontaxable combat pay election (see instructions):', null, null);
		// $form .= $this->form->text('income-1z', '1z) Add lines 1a through 1h:', null, null);
		// $form .= $this->form->text('income-2a', '2a) Tax-exempt interest:', null, null);
		// $form .= $this->form->text('income-2b', '2b) Taxable interest:', null, null);
		// $form .= $this->form->text('income-3a', '3a) Qualified dividends:', null, null);
		// $form .= $this->form->text('income-3b', '3b) Ordinary dividends:', null, null);
		// $form .= $this->form->text('income-4a', '4a) IRA distributions:', null, null);
		// $form .= $this->form->text('income-4b', '4b) Taxable amount:', null, null);
		// $form .= $this->form->text('income-5a', '5a) Pensions and annuities:', null, null);
		// $form .= $this->form->text('income-5b', '5b) Taxable amount:', null, null);
		// $form .= $this->form->text('income-6a', '6a) Social security benefits:', null, null);
		// $form .= $this->form->text('income-6b', '6b) Taxable amount:', null, null);
		// $form .= $this->form->checkbox('income-6c', '6c) If you elect to use the lump-sum election method, check here (see instructions):');
		// $form .= $this->form->text('income-6c', null, null, null, 'class="form-control" placeholder="6c"');
		// $form .= $this->form->checkbox('income-7', '7) Capital gain or (loss). Attach Schedule D if required. If not required, check here:');
		// $form .= $this->form->text('income-7', null, null, null, 'class="form-control" placeholder="7"');
		// $form .= $this->form->text('income-8', '8) Other income from Schedule 1, line 10:', null, null);
		// $form .= $this->form->text('income-9', '9) Add lines 1z, 2b, 3b, 4b, 5b, 6b, 7, and 8. This is your total income:', null, null);
		// $form .= $this->form->text('income-10', '10) Adjustments to income from Schedule 1, line 26:', null, null);
		// $form .= $this->form->text('income-11', '11) Subtract line 10 from line 9. This is your adjusted gross income:', null, null);
		// $form .= $this->form->text('income-12', '12) Standard deduction or itemized deductions (from Schedule A):', null, null);
		// $form .= $this->form->text('income-13', '13) Qualified business income deduction from Form 8995 or Form 8995-A:', null, null);
		// $form .= $this->form->number('income-14', '14) Add lines 12 and 13:', null, null);
		// $form .= $this->form->number('income-15', '15) Subtract line 14 from line 11. If zero or less, enter -0-. This is your taxable income:', null, null);

		// $form .= $this->form->heading('tax-and-credits', 'Tax and Credits');
		// $form .= $this->form->text('tax-16', '16) Tax(see instructions). Check if any form Form(s):', null, null);
		// $form .= $this->form->checkbox('tax-16-1', '8814');
		// $form .= $this->form->checkbox('tax-16-2', '4972');
		// $form .= $this->form->checkbox('tax-16-3-chkbox', '');
		// $form .= $this->form->text('tax-16-3-txt', '');
		// $form .= $this->form->line_break();
		// $form .= $this->form->number('tax-17', '17) Amount from Schedule 2, line 3:', null, null);
		// $form .= $this->form->number('tax-18', '18) Add lines 16 and 17:', null, null);
		// $form .= $this->form->number('tax-19', '19) Child tax credit or credit for other dependants from Schedule 8812:', null, null);
		// $form .= $this->form->number('tax-20', '20) Amount from Schedule 3, line 8:', null, null);
		// $form .= $this->form->number('tax-21', '21) Add lines 19 and 20:', null, null);
		// $form .= $this->form->number('tax-22', '22) Subtract line 21 from line 18. If zero or less enter -0-:', null, null);
		// $form .= $this->form->number('tax-23', '23) Other taxes, including self-employment taxm frin Schedule 2, line 21:', null, null);
		// $form .= $this->form->number('tax-24', '24) Add lines 22 and 23. This is your total tax:', null, null);

		// $form .= $this->form->heading('payments', 'Payments');
		// $form .= $this->form->label('federal-tax-withheld', 'Federal income tax withheld from:', null, null);
		// $form .= $this->form->line_break();
		// $form .= $this->form->number('tax-25a', '25a) Form(s) W-2:', null, null);
		// $form .= $this->form->number('tax-25b', '25b) Form(s) 1099:', null, null);
		// $form .= $this->form->number('tax-25c', '25c) Other forms (see instructions):', null, null);
		// $form .= $this->form->number('tax-25d', '25d) Add lines 25a through 25c:', null, null);
		// $form .= $this->form->number('tax-26', '26) 2022 estimated tax payments and amount applied from 2021 return:', null, null);
		// $form .= $this->form->number('tax-27', '27) Earned income credit (EIC):', null, null);
		// $form .= $this->form->number('tax-28', '28) Additional child tax credit from Schedule 8812:', null, null);
		// $form .= $this->form->number('tax-29', '29) American opportunity credit from Form 8863, line 8:', null, null);
		// $form .= $this->form->number('tax-30', '30) Reserved for future use:', null, null, 'class="form-control" disabled');
		// $form .= $this->form->number('tax-31', '31) Amount from Schedule 3, line 15:', null, null);
		// $form .= $this->form->number('tax-32', '32) Add lines 27, 28, 29, 31. These are your total other payments and refundable credits:', null, null);
		// $form .= $this->form->number('tax-33', '33) Add lines 25d, 26, 32. These are your total payments:', null, null);

		// $form .= $this->form->heading('refund', 'Refund');
		// $form .= $this->form->number('refund-34', '34) If line 33 is more than line 24, subtract line 24 from 33. This is the amount you overpaid:', null, null);
		// $form .= $this->form->label('refund-35a-lbl', 'Amount of line 34 you want refunded to you. If Form 8888 is attached, check here:', null, null);
		// $form .= $this->form->checkbox('refund-35a-chkbox', '');
		// $form .= $this->form->text('refund-35a-txt', '');
		// $form .= $this->form->line_break();
		// $form .= $this->form->number('refund-35b', '35b) Routing number:', null, null);
		// $form .= $this->form->label('refund-35c-lbl', 'Type:', null, null);
		// $form .= $this->form->checkbox('refund-35c-checking-chkbox', 'Checking');
		// $form .= $this->form->checkbox('refund-35c-savings-chkbox', 'Savings');
		// $form .= $this->form->number('refund-35d', '35d) Account number:', null, null);
		// $form .= $this->form->number('refund-36', '36) Amount of line 34 you want applied to your 2023 estimated tax:', null, null);

		// $form .= $this->form->heading('amount-you-owe', 'Amount You Owe');
		// $form .= $this->form->number('amount-you-owe-37', '37) Subtract line 33 from line 24. This is the amount you owe. For details on how to pay, go to www.irs/gov/Payments or see instructions:', null, null);
		// $form .= $this->form->number('amount-you-owe-38', '38) Estimated tax penalty (see instructions):', null, null);

		// $form .= $this->form->heading('third-party-designee', 'Third Party Designee');
		// $form .= $this->form->label('third-party-designee-lbl', 'Do you want to allow another person to discuss this return with the IRS? See instructions:', null, null);
		// $form .= $this->form->checkbox('third-party-designee-yes', 'Yes. Complete below.');
		// $form .= $this->form->checkbox('third-party-designee-no', 'No');
		// $form .= $this->form->line_break();
		// $form .= $this->form->text('third-party-designee-name', 'Designee\'s name', null, null);
		// $form .= $this->form->text('third-party-designee-phoneno', 'Phone no.', null, null);
		// $form .= $this->form->text('third-party-designee-pin', 'Personal identification number (PIN)', null, null);

		// $form .= $this->form->heading('sign-here', 'Sign Here');
		// $form .= $this->form->label('sign-here-lbl', 'Under penalties of perjury, I declare that I have examined this return and accompanying schedules and statements, and to the best of my knowledge and belief, they are true, correct, and complete. Declaration of preparer (other than taxpayer) is based on all information of which preparer has any knowledge.', null, null);
		// $form .= $this->form->text('your-signature', 'Your signature', null, null);
		// $form .= $this->form->date('your-signature-date', 'Date', null, null);
		// $form .= $this->form->text('your-occupation', 'Your occupation', null, null);
		// $form .= $this->form->number('your-identity-protection-pin', 'If the IRS sent you an Identity Protection Pin, enter it here (see instructions):', null, null);
		// $form .= $this->form->text('spouse-signature', 'Spouse\'s signature. If a joint return, both must sign', null, null);
		// $form .= $this->form->date('spouse-signature-date', 'Date', null, null);
		// $form .= $this->form->text('spouse-occupation', 'Spouse\'s occupation', null, null);
		// $form .= $this->form->number('spouse-identity-protection-pin', 'If the IRS sent you an Identity Protection Pin, enter it here (see instructions):', null, null);
		// $form .= $this->form->number('your-phone-no', 'Phone no.:', null, null);
		// $form .= $this->form->email('your-email', 'Email address:', null, null);

		// $form .= $this->form->heading('paid-preparer', 'Paid Preparer Use Only');
		// $form .= $this->form->text('preparer-name', 'Preparer\'s name', null, null);
		// $form .= $this->form->text('preparer-signature', 'Preparer\'s signature', null, null);
		// $form .= $this->form->date('preparer-signature-date', 'Date', null, null);
		// $form .= $this->form->date('preparer-signature-ptin', 'PTIN', null, null);
		// $form .= $this->form->label('preparer-check', 'Check if:', null, null);
		// $form .= $this->form->checkbox('preparer-self-employed', 'Self-employed.');
		// $form .= $this->form->text('preparer-firm-name', 'Firm\'s name', null, null);
		// $form .= $this->form->text('preparer-firm-address', 'Firm\'s address', null, null);
		// $form .= $this->form->number('firm-phone-no', 'Phone no.:', null, null);
		// $form .= $this->form->text('preparer-firm-ein', 'Firm\'s EIN', null, null);

		// $form .= $this->form->radio('are_you_ok', 'Are you ok ?');

		// $options = [
		// 	'cat' => 'The Cat in the Hat',
		// 	'lorax' => 'The Lorax',
		// 	'yertle' => 'Yertle the Turtle',
		// 	'grinch' => 'The Grinch Who Stole Christmas',
		// ];

		// $form .= $this->form->select('books', 'Books', null, null, null, 'yertle', $options);
		// $form .= $this->form->file('image', 'Image', null, null, null);

		// $form .= $this->form->field_text('first_name', 'First Name', ['required' => true]);
		// $form .= $this->form->text('full_name', 'Full Name', null, null, 'placeholder="Full Name" class="form-control"');
		// $form .= $this->form->field_text('last_name', '', ['placeholder' => 'Last Name']);
		// $form .= $this->form->field_dropdown('ok_ddl', 'Are you ok?', ['values' => 'yes', 'no']);
		// $form .= $this->form->field_checkbox('ok_checkbox', 'Are you ok?', ['values' => 'yes', 'no']);
		// $form .= $this->form->field_radio('ok_radio', 'Are you ok?', ['values' => 'yes', 'no']);
		// $form .= $this->form->field_email('email', 'Email');
		// $form .= $this->form->field_datetime('date', 'Date');
		// $form .= $this->form->field_password('password', 'Password', ['required' => true]);
		// $form .= $this->form->field_file_upload('file upload', 'Select a File');
		// $form .= $this->form->field_color('favcolor', 'Select your favourite color');
		// $form .= $this->form->field_number('number', 'How ok are you?', ['min' => '1', 'max' => '5']);
		// $form .= $this->form->field_range('range', 'How ok are you?', ['min' => '1', 'max' => '5', 'show_value' => true]);
		// $form .= $this->form->field_submit('Submit');
		// $form .= $this->form->field_reset();
		// $form .= $this->form->field_hidden('hidden_field', 'Are you ok?', ['value' => 'yes']);

		// $form = $this->form->open();
		$form .= $this->form->text("name", "First Name");
		$form .= $this->form->text("last_name", "Last Name");
		// $form .= $this->form->color("color", "Favourite Color");
		// $form .= $this->form->textarea("text", "Write about urself");
		// $form .= $this->form->open_div();
		// $form .= $this->form->checkbox("checkbox", "Are u alright?");
		// $form .= $this->form->close_div();
		// $options = [
		// 	'cat' => 'The Cat in the Hat',
		// 	'lorax' => 'The Lorax',
		// 	'yertle' => 'Yertle the Turtle',
		// 	'grinch' => 'The Grinch Who Stole Christmas',
		// ];

		// $form .= $this->form->select('books', 'Books', null, null, null, 'yertle', $options);

		// $form .= $this->form->file("image", "Upload an Image");
		// $form .= $this->form->button();
		$form .= $this->form->checkbox('nigger', 'Are you a nigger?');
		$form .= $this->form->button();
		$form .= $this->form->close();

		// $this->form->save("test checkbox form", "Testing of Form with checkbox", $form);

		$form_name = 'f1040 form';
		$form_description = 'This is a US 2022 f1040 tax return form';
		// $this->form->save($form_name, $form_description, $form);
		$data['form'] = $form;
		$data['title'] = 'Forms';
		$data['forms'] = $model->getForms();
		return view('/user/form', $data);
	}

	public function templates()
	{
		$this->form->set_wrapper('bootstrap');
		$form1 = $this->form->open();
		$form1 .= $this->form->create("email, username, password, create|button");
		$form1 .= $this->form->close();

		$form2 = $this->form->open();
		$form2 .= $this->form->create("email, password, login|button");
		$form2 .= $this->form->close();

		$form3 = $this->form->open();
		$form3 .= $this->form->create("name, email, subject, message|textarea, submit");
		$form3 .= $this->form->close();

		$form4 = $this->form->open();
		$form4 .= $this->form->create("first name, last name, email, contact phone, submit");
		$form4 .= $this->form->close();

		$form5 = $this->form->open();
		$form5 .= $this->form->create("title, description|textarea, date, start time, end time, participants, location, meeting link|url, create|button");
		$form5 .= $this->form->close();

		$data['form1'] = $form1;
		$data['form2'] = $form2;
		$data['form3'] = $form3;
		$data['form4'] = $form4;
		$data['form5'] = $form5;
		$data['title'] = 'Form Templates Examples';

		return view('/user/templates', $data);
	}
}
