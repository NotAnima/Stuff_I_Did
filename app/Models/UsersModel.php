<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';

    protected $allowedFields = ['username', 'password', 'email', 'type', 'secretkey'];

    public function getReviews($username, $perPage = null, $page = null) {
        $db = db_connect();

        if ($perPage === null && $page === null) {
            $sql = 
            "
            SELECT country.country_name, attractions.name, attractions.street_address, attraction_review, attractions.attraction_id, Null as hotel_review, Null as hotel_id, NULL as eatery_review, NULL as eatery_id, review_title, review, rating, NULL as visit_date, created_on FROM attractionreview, users, attractions, country WHERE attractionreview.user_id = users.user_id AND attractions.attraction_id = attractionreview.attraction_id AND attractions.country_id = country.country_id AND users.username = ?
            UNION
            SELECT country.country_name, hotels.name, hotels.street_address, Null as attraction_review, Null as attraction_id, Null as eatery_review, Null as eatery_id, hotel_review, hotels.hotel_id, review_title, review, rating, visit_date, created_on FROM hotelreview, users, hotels, country WHERE hotelreview.user_id = users.user_id AND hotels.hotel_id = hotelreview.hotel_id AND hotels.country_id = country.country_id AND users.username = ?
            UNION
            SELECT country.country_name, eateries.name, eateries.street_address, Null as attraction_review, Null as attraction_id, Null as hotel_review, Null as hotel_id, eatery_review, eateries.eatery_id, review_title, review, rating, visit_date, created_on FROM eateryreview, users, eateries, country WHERE eateryreview.user_id = users.user_id AND eateries.eatery_id = eateryreview.eatery_id AND eateries.country_id = country.country_id AND users.username = ?
            ORDER BY created_on DESC;
            ";
            $query = $db->query($sql, [$username, $username, $username])->getResultArray();

            return $query;
        }

        $sql = 
        "
        SELECT country.country_name, attractionreview.attraction_review, Null AS hotel_review, Null AS eatery_review, attractions.name, attractions.street_address, attractions.attraction_id, Null as hotel_id, NULL as eatery_id, review_title, review, rating, NULL as visit_date, created_on 
        FROM attractionreview, users, attractions, country 
        WHERE attractionreview.user_id = users.user_id AND attractions.attraction_id = attractionreview.attraction_id AND attractions.country_id = country.country_id AND users.username = ?
        UNION
        SELECT country.country_name, NULL AS attraction_review, hotelreview.hotel_review, Null AS eatery_review, hotels.name, hotels.street_address, Null as attraction_id, hotels.hotel_id, NULL AS eatery_id, review_title, review, rating, visit_date, created_on 
        FROM hotelreview, users, hotels, country 
        WHERE hotelreview.user_id = users.user_id AND hotels.hotel_id = hotelreview.hotel_id AND hotels.country_id = country.country_id AND users.username = ?
        UNION
        SELECT country.country_name, Null AS attraction_review, Null AS hotel_review, eateryreview.eatery_review, eateries.name, eateries.street_address, Null as attraction_id, Null as hotel_id, eateries.eatery_id, review_title, review, rating, visit_date, created_on 
        FROM eateryreview, users, eateries, country 
        WHERE eateryreview.user_id = users.user_id AND eateries.eatery_id = eateryreview.eatery_id AND eateries.country_id = country.country_id AND users.username = ?
        ORDER BY created_on DESC LIMIT ? OFFSET ?;
        ";

        $query = $db->query($sql, [$username, $username, $username, $perPage, ($perPage * $page) - $perPage])->getResultArray();

        return $query;
    }
}

?>