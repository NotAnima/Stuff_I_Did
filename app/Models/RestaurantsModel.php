<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantsModel extends Model
{
    protected $table = 'eateries';

    public function getRestaurants($country = false, $perPage = null, $page = null)
    {
        $db = db_connect();
        if ($country === false) {
            $sql = 
            "
            SELECT e.eatery_id, c.country_name, e.name, e.street_address, e.city, e.postal_code, e.about, e.website, e.email, e.contact_no, e.price_range, e.menu, e.images 
            FROM eateries AS e, country AS c 
            WHERE e.country_id = c.country_id
            ";
            $result = $db->query($sql)->getResultArray();
            return $result;
        }

        if ($perPage === null && $page === null) {
            $sql =  
            "
            SELECT e.eatery_id, e.name, e.street_address, e.city, e.about, e.email, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count, GROUP_CONCAT(DISTINCT c.cuisine_type ORDER BY c.cuisine_type ASC SEPARATOR ', ') AS cuisines
            FROM country, eateries AS e
            LEFT JOIN eateryreview AS r ON e.eatery_id = r.eatery_id
            LEFT JOIN eaterycuisine AS ec ON ec.eatery_id = e.eatery_id
            LEFT JOIN cuisine AS c ON ec.cuisine_id = c.cuisine_id
            WHERE country.country_id = e.country_id AND country.country_name = ? GROUP BY e.eatery_id ORDER BY rating DESC
            ";

            $result = $db->query($sql, [(ucfirst($country))])->getResultArray();
            return $result;
        }

        $sql =  
        "
        SELECT e.eatery_id, e.name, e.street_address, e.city, e.about, e.email, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count, GROUP_CONCAT(DISTINCT c.cuisine_type ORDER BY c.cuisine_type ASC SEPARATOR ', ') AS cuisines
        FROM country, eateries AS e
        LEFT JOIN eateryreview AS r ON e.eatery_id = r.eatery_id
        LEFT JOIN eaterycuisine AS ec ON ec.eatery_id = e.eatery_id
        LEFT JOIN cuisine AS c ON ec.cuisine_id = c.cuisine_id
        WHERE country.country_id = e.country_id AND country.country_name = ? GROUP BY e.eatery_id ORDER BY rating DESC, e.eatery_id ASC LIMIT ? OFFSET ?
        ";

        $result = $db->query($sql, [(ucfirst($country)), $perPage, ($perPage * $page) - $perPage])->getResultArray();
        return $result;
    }

    public function getRestaurantsSearch($country, $name, $perPage = null, $page = null)
    {
        $db = db_connect();

        if ($perPage === null && $page === null)
        {
            $sql =
            '
            SELECT e.eatery_id, e.name, e.street_address, e.city, e.about, e.email, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count, GROUP_CONCAT(DISTINCT c.cuisine_type ORDER BY c.cuisine_type ASC SEPARATOR ", ") AS cuisines
            FROM country, eateries AS e
            LEFT JOIN eateryreview AS r ON e.eatery_id = r.eatery_id
            LEFT JOIN eaterycuisine AS ec ON ec.eatery_id = e.eatery_id
            LEFT JOIN cuisine AS c ON ec.cuisine_id = c.cuisine_id
            WHERE country.country_id = e.country_id AND country.country_name = ? AND 
            (e.name LIKE "%'.$db->escapeLikeString($name).'%" OR e.street_address LIKE "%'.$db->escapeLikeString($name).'%" OR e.city LIKE "%'.$db->escapeLikeString($name).'%" OR c.cuisine_type LIKE "%'.$db->escapeLikeString($name).'%")
            GROUP BY e.eatery_id ORDER BY rating DESC
            ';

            $result = $db->query($sql, [(ucfirst($country))])->getResultArray();

            return $result;
        }

        $sql =
        '
        SELECT e.eatery_id, e.name, e.street_address, e.city, e.about, e.email, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count, GROUP_CONCAT(DISTINCT c.cuisine_type ORDER BY c.cuisine_type ASC SEPARATOR ", ") AS cuisines
        FROM country, eateries AS e
        LEFT JOIN eateryreview AS r ON e.eatery_id = r.eatery_id
        LEFT JOIN eaterycuisine AS ec ON ec.eatery_id = e.eatery_id
        LEFT JOIN cuisine AS c ON ec.cuisine_id = c.cuisine_id
        WHERE country.country_id = e.country_id AND country.country_name = ? AND 
        (e.name LIKE "%'.$db->escapeLikeString($name).'%" OR e.street_address LIKE "%'.$db->escapeLikeString($name).'%" OR e.city LIKE "%'.$db->escapeLikeString($name).'%" OR c.cuisine_type LIKE "%'.$db->escapeLikeString($name).'%")
        GROUP BY e.eatery_id ORDER BY rating DESC LIMIT ? OFFSET ?
        ';

        $result = $db->query($sql, [(ucfirst($country)), $perPage, ($perPage * $page) - $perPage])->getResultArray();

        return $result;

    }

    public function getRestaurant($slug) {

        $db = db_connect();
        $sql = 
        "
        SELECT e.eatery_id, country.country_name, e.name, e.street_address, e.city, e.postal_code, e.about, e.website, e.email, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, GROUP_CONCAT(DISTINCT c.cuisine_type ORDER BY c.cuisine_type ASC SEPARATOR ', ') AS cuisines 
        FROM country, eateries AS e 
        LEFT JOIN eaterycuisine AS ec ON ec.eatery_id = e.eatery_id
        LEFT JOIN cuisine AS c ON ec.cuisine_id = c.cuisine_id 
        LEFT JOIN eateryreview AS r ON r.eatery_id = e.eatery_id
        WHERE e.eatery_id = ? AND e.country_id = country.country_id;
        ";

        $result = $db->query($sql, [(int) $slug])->getRowArray(0);
        return $result;
    }

    public function getTopRestaurants()
    {
        $db = db_connect();
        $sql = "SELECT * FROM eateries LIMIT 4";
        $result = $db->query($sql)->getResultArray();

        return $result;
    }

    public function getRestaurantReviews($slug, $perPage = null, $page = null)
    {
        $db = db_connect();
        
        if ($perPage === null && $page === null) {
            $sql = 
            "
            SELECT u.username, r.review_title, r.review, r.rating, r.visit_date, r.created_on 
            FROM eateryreview AS r, eateries AS e, users AS u 
            WHERE r.eatery_id = e.eatery_id AND r.user_id = u.user_id AND e.eatery_id = ?
            ";
            $query = $db->query($sql, [(int) $slug])->getResultArray();
            
            return $query;
        }

        $sql = 
        "
        SELECT u.username, r.review_title, r.review, r.rating, r.visit_date, r.created_on 
        FROM eateryreview AS r, eateries AS e, users AS u 
        WHERE r.eatery_id = e.eatery_id AND r.user_id = u.user_id AND e.eatery_id = ? ORDER BY r.created_on DESC
        LIMIT ? OFFSET ?
        ";
        $query = $db->query($sql, [(int) $slug, $perPage, ($perPage * $page) - $perPage])->getResultArray();
        
        return $query;
    }

    public function getNumRestaurantReviews($slug)
    {
        $db = db_connect();
        $sql = "SELECT u.username, r.review_title, r.review, r.rating, r.visit_date, r.created_on FROM eateryreview AS r, eateries AS e, users AS u WHERE r.eatery_id = e.eatery_id AND r.user_id = u.user_id AND e.eatery_id = ?";
        $query = $db->query($sql, (int) $slug)->getNumRows();

        return $query;
    }

    public function getAvgRestaurantReviews($slug)
    {
        $db = db_connect();
        $sql = "SELECT ROUND(AVG(r.rating), 1) AS average FROM eateryreview AS r, eateries AS e WHERE r.eatery_id = e.eatery_id AND e.eatery_id = ?";
        $query = $db->query($sql, (int) $slug)->getFirstRow('array');

        return $query;
    }

    public function getTrendingRestaurants()
    {
        $db = db_connect();
        $sql = 
        "
        SELECT country.country_name, e.eatery_id, e.country_id, e.name, e.street_address, e.city, e.postal_code, e.about, e.website, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM eateries AS e, eateryreview AS r, country
        WHERE e.eatery_id = r.eatery_id AND country.country_id = e.country_id
        GROUP BY e.eatery_id ORDER BY rating DESC LIMIT 4;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getChineseRestaurants()
    {
        $db = db_connect();
        $sql = 
        "
        SELECT country.country_name, e.eatery_id, e.country_id, e.name, e.street_address, e.city, e.postal_code, e.about, e.website, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM eateries AS e, eaterycuisine AS ec, cuisine AS c, eateryreview AS r, country
        WHERE e.eatery_id = ec.eatery_id AND ec.cuisine_id = c.cuisine_id AND c.cuisine_type = 'Chinese' AND e.eatery_id = r.eatery_id AND country.country_id = e.country_id
        GROUP BY e.eatery_id ORDER BY rating DESC LIMIT 4;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getItalianRestaurants()
    {
        $db = db_connect();
        $sql = 
        "
        SELECT country.country_name, e.eatery_id, e.country_id, e.name, e.street_address, e.city, e.postal_code, e.about, e.website, e.contact_no, e.price_range, e.menu, e.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM eateries AS e, eaterycuisine AS ec, cuisine AS c, eateryreview AS r, country
        WHERE e.eatery_id = ec.eatery_id AND ec.cuisine_id = c.cuisine_id AND c.cuisine_type = 'Italian' AND e.eatery_id = r.eatery_id AND country.country_id = e.country_id
        GROUP BY e.eatery_id ORDER BY rating DESC LIMIT 4;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function createReview($eatery_id, $user_id, $review_title, $review, $rating, $visit_date, $created_on)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            INSERT INTO eateryreview (eatery_id, user_id, review_title, review, rating, visit_date, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

            $db->query($sql, [(int) $eatery_id, (int) $user_id, $review_title, $review, $rating, $visit_date, $created_on]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to create restaurants review', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function getCuisines()
    {
        $db = db_connect();

        $sql =
        "
        SELECT * FROM cuisine;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function createRestaurant($data)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            INSERT INTO eateries (country_id, name, street_address, city, postal_code, about, website, email, contact_no, price_range, menu, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $db->query($sql, [(int) $data['country'], $data['name'], $data['street_address'], $data['city'], $data['postal_code'], $data['about'], $data['website'], $data['email'], $data['contact_no'], $data['price_range'], $data['menu'], $data['images']]);

            $sql_restaurant_id =
            "
            SELECT * FROM eateries WHERE name = ?
            ";

            $restaurant = $db->query($sql_restaurant_id, $data['name'])->getRowArray(0);
            $restaurant_id = $restaurant['eatery_id'];

            $cuisines = $data['cuisines'];

            for ($i = 0; $i < count($cuisines); $i++)
            {
                $cuisines_sql =
                "
                INSERT INTO eaterycuisine (eatery_id, cuisine_id) VALUES (?, ?)
                ";

                $db->query($cuisines_sql, [(int) $restaurant_id, (int) $cuisines[$i]]);
            }

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to create restaurants', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function updateRestaurant($data)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            UPDATE eateries SET country_id = ?, name = ?, street_address = ?, city = ?, postal_code = ?, about = ?, website = ?, email = ?, contact_no = ?, price_range = ?, menu = ?, images = ? WHERE eatery_id = ?
            ";

            $db->query($sql, [(int) $data['country'], $data['name'], $data['street_address'], $data['city'], $data['postal_code'], $data['about'], $data['website'], $data['email'], $data['contact_no'], $data['price_range'], $data['menu'], $data['images'], (int) $data['eatery_id']]);

            # Remove all old cuisines
            $sql_remove_old_cuisines =
            "
            DELETE FROM eaterycuisine WHERE eatery_id = ?
            ";

            $db->query($sql_remove_old_cuisines, [(int) $data['eatery_id']]);

            if ($data["cuisines"] != null) {

                $cuisines = $data['cuisines'];

                for ($i = 0; $i < count($cuisines); $i++)
                {
                    $cuisines_sql =
                    "
                    INSERT INTO eaterycuisine (eatery_id, cuisine_id) VALUES (?, ?)
                    ";

                    $db->query($cuisines_sql, [(int) $data['eatery_id'], (int) $cuisines[$i]]);
                }
            }

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to edit restaurants', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function deleteRestaurant($id)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            DELETE FROM eateries WHERE eatery_id = ?
            ";

            $db->query($sql, [(int) $id]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to delete restaurants', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function deleteReview($id = null)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            DELETE FROM eateryreview WHERE eatery_review = ?
            ";

            $db->query($sql, [(int) $id]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to delete restaurants review', ['exception' => $e]);
            throw $e;

        }

        return;
    }
}


?>
