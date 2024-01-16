<?php

namespace App\Controllers;

use App\Models\CountriesModel;
use App\Models\HotelsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Hotels extends BaseController
{
	public function index()
	{

		$model = model(HotelsModel::class);

		try{

			$data = [
				'title' => 'Hotel Information',
				'hotels_trending' => $model->getTrendingHotels(),
				'hotels_room_service' => $model->getHotelsWithRoomService(),
				'hotels_pool' => $model->getHotelsWithPool(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching hotels from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotels from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('hotels/index')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country']);

		return redirect()->to('hotels/' . strtolower($post['country']));
	}

	public function search($country = null)
	{
    helper('form');

		$model = model(HotelsModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 5;

		try{

			$totalRows = count($model->getHotels($country));
			$data = [
				'title' => 'Hotel By Country',
				'country' => $country,
				'num_results' => $totalRows,
				'hotels' => $model->getHotels($country, $perPage, $page),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];
		}
		catch (\Throwable $e) {
			log_message('error', 'Error fetching hotels from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotels from database : ' . $e->getMessage()]);
		}

		if (! $this->request->is('post')) {
			return view('templates/header', $data)
				. view('hotels/search')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['name']);

		return redirect()->to('hotels/search-name/' . $country . '/' . strtolower($post['name']));
	}

	public function search_name($country = null, $name = null)
	{
		$model = model(HotelsModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 6;

		try {
			
			$totalRows = count($model->getHotelsSearch($country, $name));

			$data = [
				'title' => 'Hotels',
				'country' => $country,
				'num_results' => $totalRows,
				'hotels' => $model->getHotelsSearch($country, $name, $perPage, $page),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];

		} catch (\Throwable $e) {
			log_message('error', 'Error fetching attractions from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching attractions from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			 . view('hotels/search_name')
			 . view('templates/footer');
	}

	public function view($country = null, $slug = null)
	{

		$model = model(HotelsModel::class);

		$page = (int) ($this->request->getGet('page') ?? 1);
		$pager = service('pager');
		$perPage = 5;

		try{

			$totalRows = $model->getNumHotelReviews($slug);

			$data = [
				'title' => 'Hotel',
				'country' => $country,
				'hotel' => $model->getHotel($slug),
				'hotel_amenities' => $model->getHotelAmenities($slug),
				'hotel_room_features' => $model->getHotelRoomFeatures($slug),
				'hotel_room_types' => $model->getHotelRoomTypes($slug),
				'reviews' => $model->getHotelReviews($slug, $perPage, $page),
				'num_reviews' => $model->getNumHotelReviews($slug),
				'avg_review' => $model->getAvgHotelReviews($slug),
				'pager' => $pager->makeLinks($page, $perPage, $totalRows),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching hotels from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotels from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('hotels/view')
			. view('templates/footer');
	}

	public function create($country, $hotel_id)
	{

		$model = model(HotelsModel::class);

		try{

			$data = [
				'title' => 'Create Hotel Review',
				'hotel_id' => $hotel_id,
				'country' => $country,
				'hotel' => $model->getHotel($hotel_id),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching hotel data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotel data from database : ' . $e->getMessage()]);
		}

		$session = session();

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('hotels/create_review')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['star-rating', 'visit-date', 'review', 'review-title']);
		$datetime = date('Y-m-d H:i:s');
		$user_id = $session->get('user_id');

		try{

			$model->createReview($hotel_id, $user_id, $post['review-title'], $post['review'], $post['star-rating'], $post['visit-date'], $datetime);

		} catch (\Throwable $e){
			log_message('error', 'Error creating hotel review : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error creating hotel review : ' . $e->getMessage()]);
		}

		return redirect()->to('/hotels/view' . '/' . $country . '/' . $hotel_id);
	}

	public function dashboard()
	{
		$model = model(HotelsModel::class);

		try{

			$data = [
				'title' => 'Hotel Dashboard',
				'hotels' => $model->getHotels(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching hotels from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotels from database : ' . $e->getMessage()]);
		}

		return view('templates/header', $data)
			. view('hotels/dashboard')
			. view('templates/footer');
	}

	public function edit_hotel($id = null)
	{
		helper('form');

		$model = model(HotelsModel::class);
		$country_model = model(CountriesModel::class);
		
		try{

			$data = [
				'title' => 'Edit Hotel',
				'hotel' => $model->getHotel($id),
				'countries' => $country_model->getCountries(),
				'amenities' => $model->getAmenities(),
				'room_types' => $model->getRoomTypes(),
				'room_features' => $model->getRoomFeatures(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching hotel data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotel data from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('hotels/edit')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country', 'name', 'street_address', 'city', 'postal_code', 'description', 'website', 'email', 'contact_no', 'price', 'images', 'amenities', 'room_types', 'room_features']);

		if (! $this->validateData($post, [
            'country' => 'required',
            'name' => 'required|is_unique[hotels.name, hotel_id, '.$id.']',
            'street_address' => 'required|min_length[8]',
            'city' => 'required',
			'postal_code' => 'required',
			'description' => 'required',
			'price' => 'required|decimal'
        ])) {

			$data['validation'] = $this->validator;

            return view('templates/header', $data)
                . view('hotels/edit')
                . view('templates/footer');
        }

		$post['hotel_id'] = $id;

		try{

			$model->updateHotel($post);

		} catch (\Throwable $e){
			log_message('error', 'Error updating hotel from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error updating hotel from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/hotels/dashboard');
	}

	public function create_hotel()
	{
		helper('form');

		$model = model(HotelsModel::class);
		$country_model = model(CountriesModel::class);

		try{

			$data = [
				'title' => 'Create Hotel',
				'countries' => $country_model->getCountries(),
				'amenities' => $model->getAmenities(),
				'room_types' => $model->getRoomTypes(),
				'room_features' => $model->getRoomFeatures(),
			];

		} catch (\Throwable $e){
			log_message('error', 'Error fetching hotel data from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error fetching hotel data from database : ' . $e->getMessage()]);
		}

		if (!$this->request->is('post')) {
			return view('templates/header', $data)
				. view('hotels/create')
				. view('templates/footer');
		}

		$post = $this->request->getPost(['country', 'name', 'street_address', 'city', 'postal_code', 'description', 'website', 'email', 'contact_no', 'price', 'images', 'amenities', 'room_types', 'room_features']);

		if (! $this->validateData($post, [
            'country' => 'required',
            'name' => 'required|is_unique[hotels.name]',
            'street_address' => 'required|min_length[8]',
            'city' => 'required',
			'postal_code' => 'required',
			'description' => 'required',
			'price' => 'required|decimal'
        ])) {

			$data['validation'] = $this->validator;

            return view('templates/header', $data)
                . view('hotels/create')
                . view('templates/footer');
        }

		try{

			$model->createHotel($post);

		} catch (\Throwable $e){
			log_message('error', 'Error creating hotel : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error creating hotel : ' . $e->getMessage()]);
		}

		return redirect()->to('/hotels/dashboard');
	}

	public function delete_hotel($id = null)
	{
		$model = model(HotelsModel::class);

		try{

			$model->deleteHotel($id);

		} catch (\Throwable $e){
			log_message('error', 'Error deleting hotel from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error deleting hotel from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/hotels/dashboard');
	}

	public function delete_review($id = null)
	{
		$model = model(HotelsModel::class);

		try{

			$model->deleteReview($id);

		} catch (\Throwable $e){
			log_message('error', 'Error deleting hotel review from database : {exception}', ['exception' => $e]);
			return view('errors/html/error_404', ['message' => 'Error deleting hotel review from database : ' . $e->getMessage()]);
		}

		return redirect()->to('/reviews');
	}
}
