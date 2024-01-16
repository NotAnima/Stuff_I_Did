<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\ThingsToDoModel;
use App\Models\HotelsModel;
use App\Models\RestaurantsModel;

class Pages extends BaseController
{
    public function index()
    {
        $model = model(ThingstoDoModel::class);
        $hotelModel = model(HotelsModel::class);
        $restaurantModel = model(RestaurantsModel::class);
        $data['title'] = ucfirst('home');
        $data['trending_attractions'] = $model->getTrendingThingsToDo();
        $data['trending_hotels'] = $hotelModel->getTrendingHotels();
        $data['trending_restaurants'] = $restaurantModel->getTrendingRestaurants();
        return view('templates/home_header', $data)
            . view('pages/home')
            . view('templates/footer');
    }

    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }
        $thingstodoModel = model(ThingstoDoModel::class);
        $hotelModel = model(HotelsModel::class);
        $restaurantModel = model(RestaurantsModel::class);
        $data['title'] = ucfirst($page);
        $data['trending_attractions'] = $thingstodoModel->getTrendingThingsToDo();
        $data['trending_hotels'] = $hotelModel->getTrendingHotels();
        $data['trending_restaurants'] = $restaurantModel->getTrendingRestaurants();

        return view('templates/home_header', $data) 
            . view('pages/'. $page)
            . view('templates/footer');
    }
}

?>