<?php

namespace App\Controllers;

use App\Models\ThingsToDoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ThingsToDo extends BaseController
{
	public function index()
	{
		$model = model(ThingstoDoModel::class);

		try{

			$data = [
				'trending_attractions' => $model->getTrendingThingsToDo(),
				'attraction_types' => $model->getAttractionTypes(),
				'title' => 'Things to Do',
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('things-to-do/index')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country']);

		return redirect()->to('things-to-do/' . strtolower($post['country']));
	}

	public function search($country = null)
	{

		$model = model(ThingsToDoModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 6;

		try{

			$totalRows = count($model->getThingsToDo($country));

			$data = [
				'title' => 'Things to Do Country',
				'country' => $country,
				'num_results' => $totalRows,
				'things_to_do' => $model->getThingsToDo($country, $perPage, $page),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('things-to-do/search')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['name']);

		return redirect()->to('things-to-do/search-name/' . $country  . '/' . strtolower($post['name']));
	}

	public function search_name($country = null, $name = null)
	{

		$model = model(ThingsToDoModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 6;

		try{

			$totalRows = count($model->getThingsToDoSearch($country, $name));

			$data = [
				'title' => 'Things to Do Country',
				'country' => $country,
				'num_results' => $totalRows,
				'things_to_do' => $model->getThingsToDoSearch($country, $name, $perPage, $page),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('things-to-do/search_name')
			. view('templates/footer');
	}

	public function view($country = null, $slug = null)
	{

		$model = model(ThingsToDoModel::class);
		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 10;

		try{

			$totalRows = count($model->getThingToDoReviews($slug));

			$data = [
				'title' => 'Things to Do',
				'country' => $country,
				'thing_to_do' => $model->getThingToDo($slug),
				'reviews' => $model->getThingToDoReviews($slug, $perPage, $page),
				'num_reviews' => $model->getNumThingToDoReviews($slug),
				'avg_review' => $model->getAvgThingToDoReviews($slug),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];
			
		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('things-to-do/view')
			. view('templates/footer');
	}

	public function create($country, $attraction_id)
	{
		$model = model(ThingsToDoModel::class);

		try{

			$data = [
				'title' => 'Review',
				'attraction_id' => $attraction_id,
				'country' => $country,
				'restaurant' => $model->getThingToDo($attraction_id),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions data from database : ' . $e->getMessage()]);
		}

		$session = session();

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('things-to-do/create_review')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['star-rating', 'review', 'review-title']);
		$datetime = date('Y-m-d H:i:s');
		$user_id = $session->get('user_id');

		try{

			$model->createReview($attraction_id, $user_id, $post['review-title'], $post['review'], $post['star-rating'], $datetime);

		} catch (\Throwable $e){
			log_message('error', 'Error creating attractions review : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error creating attractions review : ' . $e->getMessage()]);
		}

		return redirect()->to('/things-to-do/view' . '/' . $country . '/' . $attraction_id);
	}

	public function create_thing_to_do()
	{
		helper('form');

		$model = model(ThingsToDoModel::class);
		$country_model = model(CountriesModel::class);

		try{

			$data = [
				'title' => 'Create Thing To Do',
				'countries' => $country_model->getCountries(),
				'attraction_types' => $model->getAttractionTypes(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions data from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('things-to-do/create')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country', 'name', 'street_address', 'city', 'postal_code', 'description', 'website', 'email', 'contact_no', 'price', 'images', 'attraction_type']);

		if (! $this->validateData($post, [
            'country' => 'required',
            'name' => 'required|is_unique[attractions.name]',
            'street_address' => 'required|min_length[8]',
            'city' => 'required',
			'postal_code' => 'required',
        ])) {

			$data['validation'] = $this->validator;

            return view('templates/header', $data)
                . view('things-to-do/create')
                . view('templates/footer');
        }

		try{

			$model->createThingToDo($post);

		} catch (\Throwable $e){
			log_message('error', 'Error creating attractions : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error creating attractions : ' . $e->getMessage()]);
		}

		return redirect()->to('/things-to-do/dashboard');
	}

	public function dashboard()
	{
		$model = model(ThingsToDoModel::class);

		try{

			$data = [
				'title' => 'Attraction Dashboard',
				'things_to_do' => $model->getThingsToDo(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('things-to-do/dashboard')
			. view('templates/footer');
	}

	public function edit_thing_to_do($id = null)
	{
		helper('form');

		$model = model(ThingsToDoModel::class);
		$country_model = model(CountriesModel::class);

		try{

			$data = [
				'title' => 'Update Thing To Do',
				'thing_to_do' => $model->getThingToDo($id),
				'countries' => $country_model->getCountries(),
				'attraction_types' => $model->getAttractionTypes(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching attractions data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions data from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('things-to-do/edit')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country', 'name', 'street_address', 'city', 'postal_code', 'description', 'website', 'email', 'contact_no', 'price', 'images', 'attraction_type']);

		if (! $this->validateData($post, [
            'country' => 'required',
            'name' => 'required|is_unique[attractions.name, attraction_id, '.$id.']',
            'street_address' => 'required|min_length[8]',
            'city' => 'required',
			'postal_code' => 'required',
        ])) {

			$data['validation'] = $this->validator;

            return view('templates/header', $data)
                . view('things-to-do/edit')
                . view('templates/footer');
        }

		$post['attraction_id'] = $id;

		try{

			$model->updateThingToDo($post);

		} catch (\Throwable $e){
			log_message('error', 'Error updating attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error updating attractions from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/things-to-do/dashboard');
	}

	public function delete_thing_to_do($id = null)
	{
		$model = model(ThingsToDoModel::class);

		try{

			$model->deleteThingToDo($id);

		} catch (\Throwable $e){
			log_message('error', 'Error deleting attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error deleting attractions from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/things-to-do/dashboard');
	}

	public function delete_review($id = null)
	{
		$model = model(ThingsToDoModel::class);

		try{

			$model->deleteReview($id);

		} catch (\Throwable $e){
			log_message('error', 'Error deleting attractions review from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error deleting attractions review from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/reviews');
	}
}
