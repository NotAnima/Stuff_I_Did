<?php

namespace App\Models;

use CodeIgniter\Model;

class ThingsToDoModel extends Model
{
    protected $table = 'attractions';

    public function getThingsToDo($country = false, $perPage = null, $page = null)
    {
        $db = db_connect();
        if ($country === false) {
            $sql = 
            "
            SELECT a.attraction_id, c.country_name, a.name, a.street_address, a.city, a.postal_code, a.description, a.website, a.email, a.contact_no, a.price, a.images
            FROM country AS c, attractions AS a
            WHERE c.country_id = a.country_id
            ";
            $result = $db->query($sql);
            return $result->getResultArray();
        }

        if ($perPage === null && $page === null)
        {
            $sql =
            "
            SELECT a.attraction_id, a.name, a.street_address, a.city, a.postal_code, GROUP_CONCAT(DISTINCT at.attraction_type_name ORDER BY at.attraction_type_name ASC SEPARATOR ', ') AS attraction_type, a.description, a.website, a.email, a.contact_no, a.price, a.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
            FROM country AS c, attractions AS a
            LEFT JOIN attractionreview AS r ON a.attraction_id = r.attraction_id
            LEFT JOIN attractionattractiontype AS aat ON a.attraction_id = aat.attraction_id
            LEFT JOIN attractiontype AS at ON aat.attraction_type_id = at.attraction_type_id
            WHERE c.country_id = a.country_id AND c.country_name = ? GROUP BY a.attraction_id ORDER BY rating DESC
            ";
    
            $result = $db->query($sql, [(ucfirst($country))])->getResultArray();
            return $result;
        }

        $sql =
        "
        SELECT a.attraction_id, a.name, a.street_address, a.city, a.postal_code, GROUP_CONCAT(DISTINCT at.attraction_type_name ORDER BY at.attraction_type_name ASC SEPARATOR ', ') AS attraction_type, a.description, a.website, a.email, a.contact_no, a.price, a.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM country AS c, attractions AS a
        LEFT JOIN attractionreview AS r ON a.attraction_id = r.attraction_id
        LEFT JOIN attractionattractiontype AS aat ON a.attraction_id = aat.attraction_id
        LEFT JOIN attractiontype AS at ON aat.attraction_type_id = at.attraction_type_id
        WHERE c.country_id = a.country_id AND c.country_name = ?
        GROUP BY a.attraction_id  
        ORDER BY rating DESC, a.attraction_id ASC
        LIMIT ? OFFSET ?;
        ";

        $result = $db->query($sql, [(ucfirst($country)), $perPage, ($perPage * $page) - $perPage])->getResultArray();
        return $result;
    }

    public function getThingsToDoSearch($country, $name, $perPage = null, $page = null)
    {
        $db = db_connect();

        if ($perPage === null && $page === null)
        {
            $sql =
            '
            SELECT a.attraction_id, a.name, a.street_address, a.city, a.postal_code, GROUP_CONCAT(DISTINCT at.attraction_type_name ORDER BY at.attraction_type_name ASC SEPARATOR ", ") AS attraction_type, a.description, a.website, a.email, a.contact_no, a.price, a.images, ROUND(AVG(r.rating), 1) AS rating
            FROM country AS c, attractions AS a
            LEFT JOIN attractionreview AS r ON a.attraction_id = r.attraction_id
            LEFT JOIN attractionattractiontype AS aat ON a.attraction_id = aat.attraction_id
            LEFT JOIN attractiontype AS at ON aat.attraction_type_id = at.attraction_type_id
            WHERE c.country_id = a.country_id AND c.country_name = ? AND 
            (a.name LIKE "%'.$name.'%" OR a.street_address LIKE "%'.$name.'%" OR a.city LIKE "%'.$name.'%" OR at.attraction_type_name LIKE "%'.$name.'%" OR a.description LIKE "%'.$name.'%") 
            GROUP BY a.attraction_id ORDER BY rating DESC
            ';
    
            $result = $db->query($sql, [(ucfirst($country))])->getResultArray();
            return $result;
        }

        $sql =
        '
        SELECT a.attraction_id, a.name, a.street_address, a.city, a.postal_code, GROUP_CONCAT(DISTINCT at.attraction_type_name ORDER BY at.attraction_type_name ASC SEPARATOR ", ") AS attraction_type, a.description, a.website, a.email, a.contact_no, a.price, a.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM country AS c, attractions AS a
        LEFT JOIN attractionreview AS r ON a.attraction_id = r.attraction_id
        LEFT JOIN attractionattractiontype AS aat ON a.attraction_id = aat.attraction_id
        LEFT JOIN attractiontype AS at ON aat.attraction_type_id = at.attraction_type_id
        WHERE c.country_id = a.country_id AND c.country_name = ? AND 
        (a.name LIKE "%'.$name.'%" OR a.street_address LIKE "%'.$name.'%" OR a.city LIKE "%'.$name.'%" OR at.attraction_type_name LIKE "%'.$name.'%" OR a.description LIKE "%'.$name.'%") 
        GROUP BY a.attraction_id ORDER BY rating DESC LIMIT ? OFFSET ?
        ';

        $result = $db->query($sql, [(ucfirst($country)), $perPage, ($perPage * $page) - $perPage])->getResultArray();
        return $result;
    }

    public function getTrendingThingsToDo()
    {
        $db = db_connect();
        $sql =
        "
        SELECT c.country_name, a.attraction_id, a.name, a.street_address, a.city, a.postal_code, a.description, a.website, a.email, a.contact_no, a.price, a.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM country AS c, attractions AS a
        LEFT JOIN attractionreview AS r ON a.attraction_id = r.attraction_id
        WHERE c.country_id = a.country_id GROUP BY a.attraction_id ORDER BY rating DESC LIMIT 4
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getThingToDo($id) {

        $db = db_connect();
        $sql =
        '
        SELECT a.attraction_id, c.country_name, a.name, a.street_address, a.city, a.postal_code, GROUP_CONCAT(DISTINCT at.attraction_type_name ORDER BY at.attraction_type_name ASC SEPARATOR ", ") AS attraction_type, a.description, a.website, a.email, a.contact_no, a.price, a.images, ROUND(AVG(r.rating), 1) AS rating
        FROM country AS c, attractions AS a
        LEFT JOIN attractionattractiontype AS aat ON a.attraction_id = aat.attraction_id
        LEFT JOIN attractiontype AS at ON aat.attraction_type_id = at.attraction_type_id
        LEFT JOIN attractionreview AS r ON a.attraction_id = r.attraction_id
        WHERE c.country_id = a.country_id AND a.attraction_id = ?
        ';

        $result = $db->query($sql, [(int) $id])->getRowArray(0);
        return $result;
    }

    public function getThingToDoReviews($slug, $perPage = null, $page = null) {

        $db = db_connect();

        if ($perPage === null && $page === null) {
            $sql =
            "
            SELECT u.username, r.review_title, r.review, r.rating, r.created_on
            FROM attractionreview AS r, attractions AS a, users AS u
            WHERE r.attraction_id = a.attraction_id AND r.user_id = u.user_id AND a.attraction_id = ?
            ";

            $query = $db->query($sql, [(int) $slug])->getResultArray();

            return $query;
        }

        $sql =
        "
        SELECT u.username, r.review_title, r.review, r.rating, r.created_on
        FROM attractionreview AS r, attractions AS a, users AS u
        WHERE r.attraction_id = a.attraction_id AND r.user_id = u.user_id AND a.attraction_id = ?
        ORDER BY r.created_on DESC
        LIMIT ? OFFSET ?
        ";

        $result = $db->query($sql, [(int) $slug, $perPage, ($perPage * $page) - $perPage])->getResultArray();
        return $result;
    }

    public function getNumThingToDoReviews($slug) {

        $db = db_connect();
        $sql =
        "
        SELECT u.username, r.review_title, r.review, r.rating, r.created_on
        FROM attractionreview AS r, attractions AS a, users AS u
        WHERE r.attraction_id = a.attraction_id AND r.user_id = u.user_id AND a.attraction_id = ?
        ";

        $result = $db->query($sql, (int) $slug)->getNumRows();
        return $result;
    }

    public function createReview($attraction_id, $user_id, $review_title, $review, $rating, $created_on)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            INSERT INTO attractionreview (attraction_id, user_id, review_title, review, rating, created_on) VALUES (?, ?, ?, ?, ?, ?)
            ";

            $db->query($sql, [(int) $attraction_id, (int) $user_id, $review_title, $review, $rating, $created_on]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to create attractions review', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function getAvgThingToDoReviews($slug) {

        $db = db_connect();
        $sql =
        "
        SELECT ROUND(AVG(r.rating), 1) AS average 
        FROM attractionreview AS r, attractions AS a
        WHERE r.attraction_id = a.attraction_id AND a.attraction_id = ?
        ";

        $result = $db->query($sql, (int) $slug)->getRowArray(0);
        return $result;
    }

    public function getAttractionTypes()
    {
        $db = db_connect();
        $sql =
        "
        SELECT * FROM attractiontype
        ";

        $result = $db->query($sql)->getResultArray();
        return $result;
    }

    public function createThingToDo($data)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();
            
            $sql =
            "
            INSERT INTO attractions (country_id, name, street_address, city, postal_code, description, website, email, contact_no, price, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $db->query($sql, [(int) $data['country'], $data['name'], $data['street_address'], $data['city'], $data['postal_code'], $data['description'], $data['website'], $data['email'], $data['contact_no'], $data['price'], $data['images']]);

            $sql_attraction_id =
            "
            SELECT * FROM attractions WHERE name = ?
            ";

            $attraction = $db->query($sql_attraction_id, $data['name'])->getRowArray(0);
            $attraction_id = $attraction['attraction_id'];

            if ($data['attraction_type'] != null) {

                $attraction_types = $data['attraction_type'];

                for ($i = 0; $i < count($attraction_types); $i++)
                {
                    $cuisines_sql =
                    "
                    INSERT INTO attractionattractiontype (attraction_id, attraction_type_id) VALUES (?, ?)
                    ";

                    $db->query($cuisines_sql, [(int) $attraction_id, (int) $attraction_types[$i]]);
                }
            }

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to create attractions', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function updateThingToDo($data)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            UPDATE attractions SET country_id = ?, name = ?, street_address = ?, city = ?, postal_code = ?, description = ?, website = ?, email = ?, contact_no = ?, price = ?, images = ? WHERE attraction_id = ?
            ";

            $db->query($sql, [(int) $data['country'], $data['name'], $data['street_address'], $data['city'], $data['postal_code'], $data['description'], $data['website'], $data['email'], $data['contact_no'], $data['price'], $data['images'], $data['attraction_id']]);

            $sql_remove_old_attraction_types =
            "
            DELETE FROM attractionattractiontype WHERE attraction_id = ?
            ";

            $db->query($sql_remove_old_attraction_types, [(int) $data['attraction_id']]);

            if ($data['attraction_type'] != null) {

            $attraction_types = $data['attraction_type'];

                for ($i = 0; $i < count($attraction_types); $i++)
                {
                    $cuisines_sql =
                    "
                    INSERT INTO attractionattractiontype (attraction_id, attraction_type_id) VALUES (?, ?)
                    ";

                    $db->query($cuisines_sql, [(int) $data['attraction_id'], (int) $attraction_types[$i]]);
                }
            }

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to edit attractions', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function deleteThingToDo($id)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            DELETE FROM attractions WHERE attraction_id = ?
            ";

            $db->query($sql, [(int) $id]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to delete attractions', ['exception' => $e]);
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
            DELETE FROM attractionreview WHERE attraction_review = ?
            ";

            $db->query($sql, [(int) $id]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to delete attractions review', ['exception' => $e]);
            throw $e;

        }

        return;
    }
}

?>
