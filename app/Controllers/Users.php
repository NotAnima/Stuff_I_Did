<?php

namespace App\Controllers;
use App\Models\GuidesModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PragmaRX\Google2FA\Google2FA;

class Users extends BaseController {
    public function signup() {

        helper('form');

        $data = [
            'title' => 'Sign Up',
        ];

        if (! $this->request->is('post')) {
            return view('templates/header', $data)
            . view('users/signup')
            . view('templates/footer');
        }

        $post = $this->request->getPost(['email', 'username', 'password', 'confirm-password']);

        if (! $this->validateData($post, [
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'confirm-password' => 'required|matches[password]',
        ])) {
            return view('templates/header', $data)
                . view('users/signup')
                . view('templates/footer');
        }

        $google2fa = new Google2FA();

        $secret_key = $google2fa->generateSecretKey();

        $model = model(UsersModel::class);
        $model->save([
            'username' => $post['username'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'email' => $post['email'],
            'type' => 'user',
            'secretkey' => $secret_key
        ]);

        $session = session();

        $session->set(['secretkey' => $secret_key]);

        return redirect()->to('signup/2fa');
    }

    public function signup_2fa()
    {
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $session = session();

        $inlineUrl = $google2fa->getQRCodeInline(
            'Company Name',
            'company@email.com',
            $session->get('secretkey')
        );

        $session->remove('secretkey');

        $data = [
            'inline_url' => $inlineUrl,
            'title' => 'Sign Up 2FA',
        ];

        return view('templates/header', $data)
            . view('users/signup_2fa')
            . view('templates/footer');
    }

    public function signin() {

        helper('form');

        $data = [
            'title' => 'Sign In',
        ];

        $session = session();

        $model = model(UsersModel::class);
        
        if (! $this->request->is('post')) {
            return view('templates/header', $data)
                . view('users/signin')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['username', 'password']);

        $retrieved_user = $model->where('username', $post['username'])->first();

        if (!$retrieved_user) {

            $session->setFlashdata('msg', 'Invalid Username or Password');
            return view('templates/header', $data)
                . view('users/signin')
                . view('templates/footer');
            }

        $retrieved_password = $retrieved_user['password'];
        $authenticate_password = password_verify($post['password'], $retrieved_password);

        if ($authenticate_password) {
            $ses_data = [
                'user_id' => $retrieved_user['user_id'],
                'username' => $retrieved_user['username'],
                'email' => $retrieved_user['email'],
                'type' => $retrieved_user['type'],
            ];

            $session->set($ses_data);
            return view('templates/home_header', $data)
                . view('users/signin_2fa')
                . view('templates/footer');
        }

        $session->setFlashdata('msg', 'Invalid Username or Password');
        return view('templates/header', $data)
        . view('users/signin')
        . view('templates/footer');
    }

    public function signin_2fa()
    {

        helper('form');

        $data = [
            'title' => 'Sign in 2FA',
        ];

        if (! $this->request->is('post')) {
            return view('templates/header', $data)
                . view('users/signin_2fa')
                . view('templates/footer');
        }

        $model = model(UsersModel::class);

        $post = $this->request->getPost(['2fa']);

        $google2fa = new \PragmaRX\Google2FA\Google2FA();

        $session = session();

        $retrieved_user = $model->where('username', $session->get('username'))->first();

        $secret_key = $retrieved_user['secretkey'];


        if ($google2fa->verifyKey($secret_key, $post['2fa'])) {
            // Code is Valid
            $ses_data = [
                'isLoggedIn' => TRUE,
            ];

            $session->set($ses_data);

            return redirect()->to('/');
        }

        // Code in invalid

        $session->setFlashdata('msg', 'Invalid Code Entered');

        return view('templates/header', $data)
            . view('users/signin_2fa')
            . view('templates/footer');
    }


    public function reviews() {
        
        $model = model(UsersModel::class);
        $session = session();

        $page = (int) ($this->request->getGet('page') ?? 1);
        $pager = service('pager');
        $perPage = 10;

        $totalRows = count($model->getReviews($session->get('username')));
        
        $data = [
            'title' => 'User Reviews',
            'current_user' => $session->get('username'),
            'reviews' => $model->getReviews($session->get('username'), $perPage, $page),
            'pager' => $pager->makeLinks($page, $perPage, $totalRows),
        ];

        return view('templates/header', $data)
            . view('users/reviews')
            . view('templates/footer');
    }

    public function logout() {

        session_unset();

        return redirect()->to('/home');
    }

    public function trips() {

        $session = session();
        $model = model(GuidesModel::class);
        $username = $session->get('username');

        $page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 6;
        $totalRows = $model->userDocCount($username);

        $user_trips = $model->getGuideUser($username, $page);
 
        $data = [
            'title' => 'User Trips',
            'current_user' => $username,
            'pager' => $pager->makeLinks($page, $perPage, $totalRows)
        ];

        if(! empty($user_trips) && is_array($user_trips)){
            $data['guides'] = $user_trips;
        }

        return view('templates/header', $data)
            . view('users/trips')
            . view('templates/footer');
    }

    public function deleteReview($id = null)
    {
        
    }
}

?>