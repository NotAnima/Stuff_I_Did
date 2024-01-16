<?php

namespace App\Controllers;

use App\Models\RestaurantsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Restaurants extends BaseController
{
	public function index()
	{
		$session = session();

		$model = model(RestaurantsModel::class);

		try{

			$data = [
				'title' => 'Restaurants',
				'trending_restaurants' => $model->getTrendingRestaurants(),
				'chinese_restaurants' => $model->getChineseRestaurants(),
				'italian_restaurants' => $model->getItalianRestaurants(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurants from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('restaurants/index')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country']);

		return redirect()->to('restaurants/' . strtolower($post['country']));
	}

	public function search($country = null)
	{
		$model = model(RestaurantsModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 5;

		try{

		$totalRows = count($model->getRestaurants($country));

			$data = [
				'title' => 'Restaurant By Country',
				'country' => $country,
				'num_results' => $totalRows,
				'restaurants' => $model->getRestaurants($country, $perPage, $page),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurants from database : ' . $e->getMessage()]);
		}

		if (! $this->request->is('post')) {
			return view('templates/header', $data)
				. view('restaurants/search')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['name']);

		return redirect()->to('restaurants/search-name/' . $country . '/' . strtolower($post['name']));
	}

	public function search_name($country = null, $name = null)
	{
		$model = model(RestaurantsModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 6;

		try {

			$totalRows = count($model->getRestaurantsSearch($country, $name));

			$data = [
				'title' => 'Restaurants Country',
				'country' => $country,
				'num_results' => $totalRows,
				'restaurants' => $model->getRestaurantsSearch($country, $name, $perPage, $page),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];
		} catch (\Throwable $e) {
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('restaurants/search_name')
			. view('templates/footer');
	}

	public function view($country = null, $slug = null)
	{

		$model = model(RestaurantsModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 10;

		try{

			$totalRows = count($model->getRestaurantReviews($slug));

			$data = [
				'title' => 'Restaurant Information',
				'country' => $country,
				'restaurant' => $model->getRestaurant($slug),
				'reviews' => $model->getRestaurantReviews($slug, $perPage, $page),
				'num_reviews' => $model->getNumRestaurantReviews($slug),
				'avg_review' => $model->getAvgRestaurantReviews($slug),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurants from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('restaurants/view')
			. view('templates/footer');
	}

	public function create($country, $eatery_id)
	{

		$model = model(RestaurantsModel::class);

		try{

			$data = [
				'title' => 'Review',
				'eatery_id' => $eatery_id,
				'country' => $country,
				'restaurant' => $model->getRestaurant($eatery_id),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurant data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurant data from database : ' . $e->getMessage()]);
		}

		$session = session();

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('restaurants/create_review')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['star-rating', 'visit-date', 'review', 'review-title']);
		$datetime = date('Y-m-d H:i:s');
		$user_id = $session->get('user_id');

		try{

			$model->createReview($eatery_id, $user_id, $post['review-title'], $post['review'], $post['star-rating'], $post['visit-date'], $datetime);

		} catch (\Throwable $e){
			log_message('error', 'Error creating restaurant review : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error creating restaurant review : ' . $e->getMessage()]);
		}

		return redirect()->to('/restaurants/view' . '/' . $country . '/' . $eatery_id);
	}

	public function dashboard()
	{
		$model = model(RestaurantsModel::class);

		try{

			$data = [
				'title' => 'Restaurant Dashboard',
				'restaurants' => $model->getRestaurants(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurants from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('restaurants/dashboard')
			. view('templates/footer');
	}

	public function edit_restaurant($id = null)
	{
		helper('form');

		$model = model(RestaurantsModel::class);
		$country_model = model(CountriesModel::class);

		try{

			$data = [
				'title' => 'Edit Restaurant',
				'restaurant' => $model->getRestaurant($id),
				'countries' => $country_model->getCountries(),
				'cuisines' => $model->getCuisines(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurant data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurant data from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('restaurants/edit')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country', 'name', 'street_address', 'city', 'postal_code', 'about', 'website', 'email', 'contact_no', 'price_range', 'menu', 'images', 'cuisines']);

		if (! $this->validateData($post, [
            'country' => 'required',
            'name' => 'required|is_unique[eateries.name, eatery_id, '.$id.']',
            'street_address' => 'required|min_length[8]',
            'city' => 'required',
			'postal_code' => 'required',
			'about' => 'required',
        ])) {

			$data['validation'] = $this->validator;

            return view('templates/header', $data)
                . view('restaurants/edit')
                . view('templates/footer');
        }

		$post['eatery_id'] = $id;

		try{

			$model->updateRestaurant($post);

		} catch (\Throwable $e){
			log_message('error', 'Error updating restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error updating restaurants from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/restaurants/dashboard');
	}

	public function create_restaurant()
	{
		helper('form');

		$model = model(RestaurantsModel::class);
		$country_model = model(CountriesModel::class);

		try{

			$data = [
				'title' => 'Create Restaurant',
				'countries' => $country_model->getCountries(),
				'cuisines' => $model->getCuisines(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching restaurant data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching restaurant data from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('restaurants/create')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country', 'name', 'street_address', 'city', 'postal_code', 'about', 'website', 'email', 'contact_no', 'price_range', 'menu', 'images', 'cuisines']);

		if (! $this->validateData($post, [
            'country' => 'required',
            'name' => 'required|is_unique[eateries.name]',
            'street_address' => 'required|min_length[8]',
            'city' => 'required',
			'postal_code' => 'required',
			'about' => 'required',
        ])) {

			$data['validation'] = $this->validator;

            return view('templates/header', $data)
                . view('restaurants/create')
                . view('templates/footer');
        }

		try{

			$model->createRestaurant($post);

		} catch (\Throwable $e){
			log_message('error', 'Error creating restaurants : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error creating restaurants : ' . $e->getMessage()]);
		}

		return redirect()->to('/restaurants/dashboard');
	}

	public function delete_restaurant($id = null)
	{
		$model = model(RestaurantsModel::class);

		try{

			$model->deleteRestaurant($id);

		} catch (\Throwable $e){
			log_message('error', 'Error deleting restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error deleting restaurants from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/restaurants/dashboard');
	}

	public function delete_review($id = null)
	{
		$model = model(RestaurantsModel::class);

		try{

			$model->deleteReview($id);

		} catch (\Throwable $e){
			log_message('error', 'Error deleting restaurants from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error deleting restaurants from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/reviews');
	}
}
