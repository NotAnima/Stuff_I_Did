<?php

namespace App\Models;

use CodeIgniter\Model;


class HotelsModel extends Model
{
    protected $table = 'hotels';

    public function getHotels($country = false, $perPage = 0, $page = 0)
    {
        $db = db_connect();
        if ($country === false) {
            $sql = 
            '
            SELECT h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, GROUP_CONCAT(DISTINCT rf.room_features_name ORDER BY rf.room_features_name ASC SEPARATOR ", ") AS room_features, GROUP_CONCAT(DISTINCT rt.room_types_name ORDER BY rt.room_types_name ASC SEPARATOR ", ") AS room_types, GROUP_CONCAT(DISTINCT a.amenity_name ORDER BY a.amenity_name ASC SEPARATOR ", ") AS amenity, c.country_name
            FROM country AS c, hotels AS h
            LEFT JOIN hotelreview AS r ON h.hotel_id = r.hotel_id
            LEFT JOIN hotelroomfeatures AS hrf ON hrf.hotel_id = h.hotel_id
            LEFT JOIN roomfeatures AS rf ON rf.room_features_id = hrf.room_features
            LEFT JOIN hotelroomtypes AS hrt ON hrt.hotel_id = h.hotel_id
            LEFT JOIN roomtypes AS rt ON rt.room_types_id = hrt.room_types_id
            LEFT JOIN hotelamenity AS ha ON ha.hotel_id = h.hotel_id
            LEFT JOIN amenity AS a ON a.amenity_id = ha.amenity_id
            WHERE c.country_id = h.country_id GROUP BY h.hotel_id ORDER BY rating DESC, h.hotel_id
            ';
            $result = $db->query($sql)->getResultArray();
            return $result;
        }

        if ($perPage === 0 or $page === 0) {
            $sql =
            '
            SELECT h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, GROUP_CONCAT(DISTINCT rf.room_features_name ORDER BY rf.room_features_name ASC SEPARATOR ", ") AS room_features, GROUP_CONCAT(DISTINCT rt.room_types_name ORDER BY rt.room_types_name ASC SEPARATOR ", ") AS room_types, GROUP_CONCAT(DISTINCT a.amenity_name ORDER BY a.amenity_name ASC SEPARATOR ", ") AS amenity, c.country_name
            FROM country AS c, hotels AS h
            LEFT JOIN hotelreview AS r ON h.hotel_id = r.hotel_id
            LEFT JOIN hotelroomfeatures AS hrf ON hrf.hotel_id = h.hotel_id
            LEFT JOIN roomfeatures AS rf ON rf.room_features_id = hrf.room_features
            LEFT JOIN hotelroomtypes AS hrt ON hrt.hotel_id = h.hotel_id
            LEFT JOIN roomtypes AS rt ON rt.room_types_id = hrt.room_types_id
            LEFT JOIN hotelamenity AS ha ON ha.hotel_id = h.hotel_id
            LEFT JOIN amenity AS a ON a.amenity_id = ha.amenity_id
            WHERE c.country_id = h.country_id AND c.country_name = ? GROUP BY h.hotel_id ORDER BY rating DESC, h.hotel_id
            ';
    
            $result = $db->query($sql, [(ucfirst($country))])->getResultArray();
            return $result;
        }

        $sql =
        '
        SELECT h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, r_subquery.avg_rating AS rating, r_subquery.rating_count,
        GROUP_CONCAT(DISTINCT rf.room_features_name ORDER BY rf.room_features_name ASC SEPARATOR ", ") AS room_features, 
        GROUP_CONCAT(DISTINCT rt.room_types_name ORDER BY rt.room_types_name ASC SEPARATOR ", ") AS room_types, 
        GROUP_CONCAT(DISTINCT a.amenity_name ORDER BY a.amenity_name ASC SEPARATOR ", ") AS amenity, c.country_name FROM country AS c, hotels AS h
        LEFT JOIN (
            SELECT 
                hotel_id, 
                ROUND(AVG(rating), 1) AS avg_rating, 
                COUNT(rating) AS rating_count
            FROM 
                hotelreview
            GROUP BY 
                hotel_id
            ) AS r_subquery ON h.hotel_id = r_subquery.hotel_id
            LEFT JOIN hotelroomfeatures AS hrf ON hrf.hotel_id = h.hotel_id
            LEFT JOIN roomfeatures AS rf ON rf.room_features_id = hrf.room_features
            LEFT JOIN hotelroomtypes AS hrt ON hrt.hotel_id = h.hotel_id
            LEFT JOIN roomtypes AS rt ON rt.room_types_id = hrt.room_types_id
            LEFT JOIN hotelamenity AS ha ON ha.hotel_id = h.hotel_id
            LEFT JOIN amenity AS a ON a.amenity_id = ha.amenity_id
            WHERE 
                c.country_id = h.country_id AND c.country_name = ?
            GROUP BY 
                h.hotel_id 
            ORDER BY 
                rating DESC, h.hotel_id 
            LIMIT ? OFFSET ?
        ';

        $result = $db->query($sql, [(ucfirst($country)), (int) $perPage, (int) ($perPage * $page) - $perPage])->getResultArray();
        return $result;
    }

    public function getHotelsSearch($country, $name, $perPage = null, $page = null)
    {
        $db = db_connect();

        if ($perPage === null && $page === null)
        {
            $sql = 
            '
            SELECT h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, GROUP_CONCAT(DISTINCT rf.room_features_name ORDER BY rf.room_features_name ASC SEPARATOR ", ") AS room_features, GROUP_CONCAT(DISTINCT rt.room_types_name ORDER BY rt.room_types_name ASC SEPARATOR ", ") AS room_types, GROUP_CONCAT(DISTINCT a.amenity_name ORDER BY a.amenity_name ASC SEPARATOR ", ") AS amenity
            FROM country AS c, hotels AS h
            LEFT JOIN hotelreview AS r ON h.hotel_id = r.hotel_id
            LEFT JOIN hotelroomfeatures AS hrf ON hrf.hotel_id = h.hotel_id
            LEFT JOIN roomfeatures AS rf ON rf.room_features_id = hrf.room_features
            LEFT JOIN hotelroomtypes AS hrt ON hrt.hotel_id = h.hotel_id
            LEFT JOIN roomtypes AS rt ON rt.room_types_id = hrt.room_types_id
            LEFT JOIN hotelamenity AS ha ON ha.hotel_id = h.hotel_id
            LEFT JOIN amenity AS a ON a.amenity_id = ha.amenity_id
            WHERE c.country_id = h.country_id AND c.country_name = ? AND
            (h.name LIKE "%'.$db->escapeLikeString($name).'%" OR h.street_address LIKE "%'.$db->escapeLikeString($name).'%" OR h.city LIKE "%'.$db->escapeLikeString($name).'%" OR rf.room_features_name LIKE "%'.$db->escapeLikeString($name).'%" OR rt.room_types_name LIKE "%'.$db->escapeLikeString($name).'%" OR a.amenity_name LIKE "%'.$db->escapeLikeString($name).'%")
            GROUP BY h.hotel_id ORDER BY rating DESC, h.hotel_id;
            ';

            $result = $db->query($sql, [(ucfirst($country))])->getResultArray();

            return $result;
        }

        $sql = 
        '
        SELECT h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description,h.website, h.email, h.contact_no, h.price, h.images, r_subquery.avg_rating AS rating, r_subquery.rating_count, 
        GROUP_CONCAT(DISTINCT rf.room_features_name ORDER BY rf.room_features_name ASC SEPARATOR ", ") AS room_features, 
        GROUP_CONCAT(DISTINCT rt.room_types_name ORDER BY rt.room_types_name ASC SEPARATOR ", ") AS room_types, 
        GROUP_CONCAT(DISTINCT a.amenity_name ORDER BY a.amenity_name ASC SEPARATOR ", ") AS amenity FROM country AS c, hotels AS h
        LEFT JOIN (
            SELECT 
                hotel_id, 
                ROUND(AVG(rating), 1) AS avg_rating, 
                COUNT(rating) AS rating_count
            FROM 
                hotelreview
            GROUP BY 
                hotel_id
        ) AS r_subquery ON h.hotel_id = r_subquery.hotel_id
        LEFT JOIN hotelroomfeatures AS hrf ON hrf.hotel_id = h.hotel_id
        LEFT JOIN roomfeatures AS rf ON rf.room_features_id = hrf.room_features
        LEFT JOIN hotelroomtypes AS hrt ON hrt.hotel_id = h.hotel_id
        LEFT JOIN roomtypes AS rt ON rt.room_types_id = hrt.room_types_id
        LEFT JOIN hotelamenity AS ha ON ha.hotel_id = h.hotel_id
        LEFT JOIN amenity AS a ON a.amenity_id = ha.amenity_id
        WHERE 
            c.country_id = h.country_id AND c.country_name = ? AND
            (h.name LIKE "%'.$db->escapeLikeString($name).'%" OR h.street_address LIKE "%'.$db->escapeLikeString($name).'%" OR h.city LIKE "%'.$db->escapeLikeString($name).'%" OR rf.room_features_name LIKE "%'.$db->escapeLikeString($name).'%" OR rt.room_types_name LIKE "%'.$db->escapeLikeString($name).'%" OR a.amenity_name LIKE "%'.$db->escapeLikeString($name).'%")
        GROUP BY 
            h.hotel_id 
        ORDER BY 
            rating DESC, h.hotel_id 
        LIMIT ? OFFSET ?;
        ';

        $result = $db->query($sql, [(ucfirst($country)), (int) $perPage, (int) ($perPage * $page) - $perPage])->getResultArray();

        return $result;
    }

    public function getHotel($slug) {
        $db = db_connect();

        $sql = 
        "
        SELECT h.hotel_id, country.country_name, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, GROUP_CONCAT(DISTINCT a.amenity_name ORDER BY a.amenity_name ASC SEPARATOR ', ') AS amenities, GROUP_CONCAT(DISTINCT f.room_features_name ORDER BY f.room_features_name ASC SEPARATOR ', ') AS room_features, GROUP_CONCAT(DISTINCT t.room_types_name ORDER BY t.room_types_name ASC SEPARATOR ', ') AS room_types
        FROM country, hotels AS h
        LEFT JOIN hotelamenity AS ha ON ha.hotel_id = h.hotel_id
        LEFT JOIN amenity AS a ON a.amenity_id = ha.amenity_id
        LEFT JOIN hotelroomfeatures AS hf ON hf.hotel_id = h.hotel_id
        LEFT JOIN roomfeatures AS f ON f.room_features_id = hf.room_features
        LEFT JOIN hotelroomtypes AS ht ON ht.hotel_id = h.hotel_id
        LEFT JOIN roomtypes AS t ON t.room_types_id = ht.room_types_id
        WHERE h.hotel_id = ? AND h.country_id = country.country_id;
        ";

        $result = $db->query($sql, [(int) $slug])->getRowArray(0);
        return $result;
    }

    public function getAllCountryHotelsFilterAmenities($country, $amenities) {
        $db = db_connect();

        $amenities = implode(",", $amenities);
        d($amenities);
        $sql =
        "
        SELECT h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM hotels as h, country AS c, hotelreview AS r, hotelamenity AS ha, amenity AS a
        WHERE c.country_id = h.country_id AND r.hotel_id = h.hotel_id AND c.country_name = ? AND ha.hotel_id = h.hotel_id AND a.amenity_id = ha.amenity_id AND a.amenity_name IN (?) GROUP BY h.hotel_id ORDER BY rating DESC;
        ";

        $result = $db->query($sql, [ucfirst($country), $amenities])->getResultArray();

        d($result);

        return $result;
    }

    public function getAllCountryHotelsAmenities($country) {
        $db = db_connect();

        $sql =
        "
        SELECT DISTINCT(a.amenity_name)
        FROM hotels as h, country AS c, hotelamenity AS ha, amenity AS a
        WHERE c.country_id = h.country_id AND c.country_name = ? AND ha.hotel_id = h.hotel_id AND a.amenity_id = ha.amenity_id;
        ";

        $result = $db->query($sql, [ucfirst($country)])->getResultArray();

        return $result;
    }

    public function getHotelAmenities($slug)
    {
        $db = db_connect();

        $sql =
        "
        SELECT amenity.amenity_name 
        FROM amenity, hotelamenity 
        WHERE hotelamenity.hotel_id = ? AND hotelamenity.amenity_id = amenity.amenity_id;
        ";

        $result = $db->query($sql, [(int) $slug])->getResultArray();

        return $result;
    }

    public function getHotelRoomFeatures($slug)
    {
        $db = db_connect();

        $sql =
        "
        SELECT roomfeatures.room_features_name 
        FROM hotelroomfeatures, roomfeatures 
        WHERE hotelroomfeatures.hotel_id = ? AND hotelroomfeatures.room_features = roomfeatures.room_features_id;
        ";

        $result = $db->query($sql, [(int) $slug])->getResultArray();

        return $result;
    }

    public function getHotelRoomTypes($slug)
    {
        $db = db_connect();

        $sql =
        "
        SELECT roomtypes.room_types_name FROM roomtypes, hotelroomtypes WHERE hotelroomtypes.hotel_id = ? AND hotelroomtypes.room_types_id = roomtypes.room_types_id;
        ";

        $result = $db->query($sql, [(int) $slug])->getResultArray();

        return $result;
    }

    public function getHotelReviews($slug, $perPage = 0, $page = 0)
    {
        $db = db_connect();
        $sql = 
        "
        SELECT u.username, r.review_title, r.review, r.rating, r.visit_date, r.created_on 
        FROM hotelreview AS r, hotels AS h, users AS u 
        WHERE r.hotel_id = h.hotel_id AND r.user_id = u.user_id AND h.hotel_id = ? LIMIT ? OFFSET ?
        ";

        $query = $db->query($sql, [(int) $slug, $perPage, ($perPage * $page) - $perPage])->getResultArray();
        
        return $query;
    }

    public function getNumHotelReviews($slug)
    {
        $db = db_connect();
        $sql = 
        "
        SELECT u.username, r.review_title, r.review, r.rating, r.visit_date, r.created_on 
        FROM hotelreview AS r, hotels AS h, users AS u 
        WHERE r.hotel_id = h.hotel_id AND r.user_id = u.user_id AND h.hotel_id = ?
        ";

        $query = $db->query($sql, (int) $slug)->getNumRows();

        return $query;
    }

    public function getAvgHotelReviews($slug)
    {
        $db = db_connect();
        $sql =
        "
        SELECT ROUND(AVG(r.rating), 1) AS average FROM hotelreview AS r, hotels AS h WHERE r.hotel_id = h.hotel_id AND h.hotel_id = ?
        ";

        $query = $db->query($sql, (int) $slug)->getFirstRow('array');

        return $query;
    }

    public function getTrendingHotels()
    {
        $db = db_connect();
        $sql =
        "
        SELECT country.country_name, h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM hotels AS h, hotelreview AS r, country
        WHERE country.country_id = h.country_id AND r.hotel_id = h.hotel_id GROUP BY h.hotel_id ORDER BY rating DESC LIMIT 4
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getHotelsWithRoomService()
    {
        $db = db_connect();
        $sql =
        "
        SELECT country.country_name, h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM hotels AS h, hotelreview AS r, hotelroomfeatures, roomfeatures, country
        WHERE country.country_id = h.country_id AND r.hotel_id = h.hotel_id AND hotelroomfeatures.hotel_id = h.hotel_id AND hotelroomfeatures.room_features = roomfeatures.room_features_id AND roomfeatures.room_features_name = 'Room service' GROUP BY h.hotel_id ORDER BY rating DESC LIMIT 4
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getHotelsWithPool()
    {
        $db = db_connect();
        $sql =
        "
        SELECT country.country_name, h.hotel_id, h.name, h.street_address, h.city, h.postal_code, h.description, h.website, h.email, h.contact_no, h.price, h.images, ROUND(AVG(r.rating), 1) AS rating, COUNT(r.rating) AS rating_count
        FROM hotels AS h, hotelreview AS r, hotelamenity, amenity, country
        WHERE country.country_id = h.country_id AND r.hotel_id = h.hotel_id AND hotelamenity.hotel_id = h.hotel_id AND hotelamenity.amenity_id = amenity.amenity_id AND amenity.amenity_name = 'Pool' GROUP BY h.hotel_id ORDER BY rating DESC LIMIT 4
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function createReview($hotel_id, $user_id, $review_title, $review, $rating, $visit_date, $created_on)
    {

        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            INSERT INTO hotelreview (hotel_id, user_id, review_title, review, rating, visit_date, created_on) VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

            $db->query($sql, [(int) $hotel_id, (int) $user_id, $review_title, $review, $rating, $visit_date, $created_on]);

            $this->db->transComplete();
        
        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to create hotel review', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function createHotel($data)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            INSERT INTO hotels (country_id, name, street_address, city, postal_code, description, website, email, contact_no, price, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $db->query($sql, [(int) $data['country'], $data['name'], $data['street_address'], $data['city'], $data['postal_code'], $data['description'], $data['website'], $data['email'], $data['contact_no'], $data['price'], $data['images']]);

            $sql_hotel_id =
            "
            SELECT * FROM hotels WHERE name = ?
            ";

            $hotel = $db->query($sql_hotel_id, $data['name'])->getRowArray(0);
            $hotel_id = $hotel['hotel_id'];

            $amenities = $data['amenities'];
            $room_types = $data['room_types'];
            $room_features = $data['room_features'];
            if ($data['amenities'] != null) {

            for ($i = 0; $i < count($amenities); $i++)
                {
                    $amenities_sql =
                    "
                    INSERT INTO hotelamenity (hotel_id, amenity_id) VALUES (?, ?)
                    ";

                    $db->query($amenities_sql, [(int) $hotel_id, (int) $amenities[$i]]);
                }
            }

            if ($data['room_types'] != null) {

            
                for ($i = 0; $i < count($room_types); $i++)
                {
                    $room_types_sql =
                    "
                    INSERT INTO hotelroomtypes (hotel_id, room_types_id) VALUES (?, ?)
                    ";

                    $db->query($room_types_sql, [(int) $hotel_id, (int) $room_types[$i]]);
                }
            }

            if ($data['room_features'] != null) {

                for ($i = 0; $i < count($room_features); $i++)
                {
                    $room_features_sql =
                    "
                    INSERT INTO hotelroomfeatures (hotel_id, room_features) VALUES (?, ?)
                    ";

                    $db->query($room_features_sql, [(int) $hotel_id, (int) $room_features[$i]]);
                }
            }

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to create hotel', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function getAmenities()
    {
        $db = db_connect();

        $sql =
        "
        SELECT * FROM amenity;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getRoomTypes()
    {
        $db = db_connect();

        $sql =
        "
        SELECT * FROM roomtypes;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function getRoomFeatures()
    {
        $db = db_connect();

        $sql =
        "
        SELECT * FROM roomfeatures;
        ";

        $query = $db->query($sql)->getResultArray();

        return $query;
    }

    public function updateHotel($data)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            UPDATE hotels SET country_id = ?, name = ?, street_address = ?, city = ?, postal_code = ?, description = ?, website = ?, email = ?, contact_no = ?, price = ?, images = ? WHERE hotel_id = ?
            ";

            $db->query($sql, [(int) $data['country'], $data['name'], $data['street_address'], $data['city'], $data['postal_code'], $data['description'], $data['website'], $data['email'], $data['contact_no'], $data['price'], $data['images'], (int) $data['hotel_id']]);

            # Remove all old cuisines
            $sql_remove_old_amenities =
            "
            DELETE FROM hotelamenity WHERE hotel_id = ?
            ";

            $db->query($sql_remove_old_amenities, [(int) $data['hotel_id']]);

            # Remove all old cuisines
            $sql_remove_old_room_types =
            "
            DELETE FROM hotelroomtypes WHERE hotel_id = ?
            ";

            $db->query($sql_remove_old_room_types, [(int) $data['hotel_id']]);

            # Remove all old cuisines
            $sql_remove_old_room_features =
            "
            DELETE FROM hotelroomfeatures WHERE hotel_id = ?
            ";

            $db->query($sql_remove_old_room_features, [(int) $data['hotel_id']]);

            $amenities = $data['amenities'];
            $room_types = $data['room_types'];
            $room_features = $data['room_features'];

            if ($data['amenities'] != null) {

            
                for ($i = 0; $i < count($amenities); $i++)
                {
                    $amenities_sql =
                    "
                    INSERT INTO hotelamenity (hotel_id, amenity_id) VALUES (?, ?)
                    ";

                    $db->query($amenities_sql, [(int) $data['hotel_id'], (int) $amenities[$i]]);
                }
            }

            if ($data['room_types'] != null) {


                for ($i = 0; $i < count($room_types); $i++)
                {
                    $room_types_sql =
                    "
                    INSERT INTO hotelroomtypes (hotel_id, room_types_id) VALUES (?, ?)
                    ";

                    $db->query($room_types_sql, [(int) $data['hotel_id'], (int) $room_types[$i]]);
                }
            }

            if ($data['room_features'] != null) {

                for ($i = 0; $i < count($room_features); $i++)
                {
                    $room_features_sql =
                    "
                    INSERT INTO hotelroomfeatures (hotel_id, room_features) VALUES (?, ?)
                    ";

                    $db->query($room_features_sql, [(int) $data['hotel_id'], (int) $room_features[$i]]);
                }
            }

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to edit hotel', ['exception' => $e]);
            throw $e;

        }

        return;
    }

    public function deleteHotel($id = null)
    {
        try{

            $db = db_connect();

            $db->transException(true)->transStart();

            $sql =
            "
            DELETE FROM hotels WHERE hotel_id = ?
            ";

            $db->query($sql, [(int) $id]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to delete hotel', ['exception' => $e]);
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
            DELETE FROM hotelreview WHERE hotel_review = ?
            ";

            $db->query($sql, [(int) $id]);

            $this->db->transComplete();

        } catch (DatabaseException $e) {

            log_message('error', 'Database error occurred in the model when trying to delete hotel review', ['exception' => $e]);
            throw $e;

        }

        return;
    }
}

?>