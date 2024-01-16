<?php

namespace App\Controllers;

use App\Models\GuidesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Guides extends BaseController {
  public function index($name = null){

    try{

      $model = model(GuidesModel::class);

      $page = (int) ($this->request->getGet('page') ?? 1);
		  $pager = service('pager');
		  $perPage = 12;
      $totalRows = $model->docCount($name);
      $data = [
        'guides' => $model->getGuides($name, $page),
        'title' => 'Guides',
        'pager' => $pager->makeLinks($page, $perPage, $totalRows)
      ];

    } catch (\Throwable $e){
      log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $e]);
      return view('errors/html/error_404', ['message' => 'Error fetching guides from database : ' . $e->getMessage()]);
    }

    if (! $this->request->is('post')) {
      return view('templates/header', $data)
      . view('guides/index')
      . view ('templates/footer');
    }

	  $post = $this->request->getPost(['name']);

	  return redirect()->to('guides/search/' . strtolower($post['name']));

  }

  public function view($id = null) {

    try{
      
      $model = model(GuidesModel::class);
	    $guide = $model->getGuide($id);
      $user = null;
      $user = session()->get('username');
      $data = [
        'guide' => $guide,
        'title' => 'Guides View',
        'id' => $id,
        'user' => $user
      ];
    } catch (\Throwable $e){
      log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $e]);
      return view('errors/html/error_404', ['message' => 'Error fetching guides from database : ' . $e->getMessage()]);
    }

    if (! $this->request->is('post')) {
		return view('templates/header', $data)
        . view('guides/view')
        . view('templates/footer');
    }

	$session = session();

	if (!$session->get('isLoggedIn')) {
		$session->setFlashdata('msg', 'You need to be logged in to send this trip to your email');

		return view('templates/header', $data)
        . view('guides/view')
        . view('templates/footer');
	}

	if (! empty($session->get('email'))) {

		$to = $session->get('email');
		$subject = $guide['title'];
					
		$email = \Config\Services::email();
		$email->setTo($to);
		$email->setFrom('yujietan84@gmail.com', 'CodeIgniter');
		$email->setSubject($subject);
		$email->setMessage(view('guides/email', $data));
		if ($email->send()) {
			return redirect()->to(current_url());
		}
		else {
			$error = $email->printDebugger(['headers']);
		}
	}
	else {
		$session->setFlashdata('msg', 'Unable to send Email');

		return view('templates/header', $data)
		. view('guides/view')
		. view('templates/footer');
	}

  }

  public function create($country, $start_date, $end_date) {
    helper('form');

    $start_date_formatted = strtotime($start_date);
    $end_date_formatted = strtotime($end_date);

    $data = [
      'title' => 'Guide Create',
      'country' => $country,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'start_date_formatted' => $start_date_formatted,
      'end_date_formatted' => $end_date_formatted,
      'days' => ($end_date_formatted - $start_date_formatted)/60/60/24,
    ];

    if (! $this->request->is('post')) {
        // The form is not submitted, so returns the form.
        return view('templates/header', $data)
          . view('guides/create')
          . view('templates/footer');
    }


    $post = $this->request->getPost();

    try{

      foreach ($post as $key => $value){
        if (!is_array($post[$key])){
          $sanitized_value = trim($value);
          $sanitized_value = strip_tags($sanitized_value);
          $sanitized_value = htmlspecialchars($sanitized_value, ENT_QUOTES, 'UTF-8');
          $post[$key] = $sanitized_value;
        }
        else{
          foreach ($post[$key] as $subKey => $subValue){
            $sanitized_subValue = trim($subValue);
            $sanitized_subValue = strip_tags($sanitized_subValue);
            $sanitized_subValue = htmlspecialchars($sanitized_subValue, ENT_QUOTES, 'UTF-8');
            $post[$key][$subKey] = $sanitized_subValue;
          }
        }
      };

      $titles = array();
      $notes = array();

      foreach ($post as $key => $value){
        if (strpos($key, 'title-') === 0){
          $index = substr($key, strlen('title-'));

          $titles[$index] = $value;
        }

        if (strpos($key, 'notes-') === 0){
          $index = substr($key, strlen('notes-'));

          $notes[$index] = $value;
        }
      }

      if (! $this->validateData($post, [
          'title' => 'required|max_length[255]|min_length[3]',
      ])) {
          throw new \Exception("Title is required when creating a guide");
      }
      $guide_title = $post['title'];
      $description = $post['description'];
      $image = $post['image'];
      if ($image === "")
      {
        $image = null;
      }
      $user = session()->get('username');

      $model = model(GuidesModel::class);

      $model->insertGuide($titles, $image, $notes, $guide_title, $description, $user);

    } catch (\Throwable $e){
      log_message('error', 'Error creating guide : {exception}', ['exception' => $e]);
      return view('errors/html/error_404', ['message' => 'Error creating guide : ' . $e->getMessage()]);
    }

    return redirect()->route("guides");
  }

  public function plan_trip_date() {

    $data = [
      'title' => 'Guide date',
    ];

    if (! $this->request->is('post')) {
      // The form is not submitted, so returns the form.
      return view('templates/header', $data)
        . view('guides/plan_trip_date')
        . view('templates/footer');
    }

    $post = $this->request->getPost(['country', 'start-date', 'end-date']);

    if(! $this->validateData($post, [
      'country' => 'required|alpha_numeric_punct',
      'start-date' => 'required',
      'end-date' => 'required',
  ]))
  {
        $post['title'] = 'Guide date';
        return view('templates/header', $post)
      . view('guides/plan_trip_date')
      . view('templates/footer');
  }

    return redirect()->to('/guides/create/' . $post['country'] . '/' . $post['start-date'] . '/' . $post['end-date']);
  }

  public function delete($id = null)
  {
	$model = model(GuidesModel::class);

	$model->deleteGuide($id);

	return redirect()->to('/guides');
  }

  public function update($id = null)
  {
	$model = model(GuidesModel::class);

	try{
      
		$model = model(GuidesModel::class);
		$guide = $model->getGuide($id);
		$data = [
		  'guide' => $guide,
		  'title' => 'Guides View',
		  'id' => $id,
		];

	  } catch (\Throwable $e){
		log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $e]);
		return view('errors/html/error_404', ['message' => 'Error fetching guides from database : ' . $e->getMessage()]);
	  }
  
	  if (! $this->request->is('post')) {
		  return view('templates/header', $data)
		  . view('guides/update')
		  . view('templates/footer');
	  }

    $post = $this->request->getPost();

    try{

      foreach ($post as $key => $value){
        if (!is_array($post[$key])){
          $sanitized_value = trim($value);
          $sanitized_value = strip_tags($sanitized_value);
          $sanitized_value = htmlspecialchars($sanitized_value, ENT_QUOTES, 'UTF-8');
          $post[$key] = $sanitized_value;
        }
        else{
          foreach ($post[$key] as $subKey => $subValue){
            $sanitized_subValue = trim($subValue);
            $sanitized_subValue = strip_tags($sanitized_subValue);
            $sanitized_subValue = htmlspecialchars($sanitized_subValue, ENT_QUOTES, 'UTF-8');
            $post[$key][$subKey] = $sanitized_subValue;
          }
        }
      };

      $titles = array();
      $notes = array();

      foreach ($post as $key => $value){
        if (strpos($key, 'title-') === 0){
          $index = substr($key, strlen('title-'));

          $titles[$index] = $value;
        }

        if (strpos($key, 'notes-') === 0){
          $index = substr($key, strlen('notes-'));

          $notes[$index] = $value;
        }
      }

      $description = $post['description'];
      $guide_title = $post['title'];
      $image = $post['image'];
      if ($image === "")
      {
        $image = null;
      }
      $user = session()->get('username');

      $model = model(GuidesModel::class);

      $model->updateGuide($id, $titles, $image, $notes, $guide_title, $description, $user);

    } catch (\Throwable $e){
      log_message('error', 'Error creating guide : {exception}', ['exception' => $e]);
      return view('errors/html/error_404', ['message' => 'Error creating guide : ' . $e->getMessage()]);
    }

    return redirect()->route("guides");
  }
}
