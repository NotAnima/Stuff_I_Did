<?php

namespace App\Models;

use CodeIgniter\Model;

class CountriesModel extends Model
{
    protected $table = 'country';

    public function getCountries($country = false)
    {
        $db = db_connect();
        if ($country === false) {
            $sql = "SELECT * FROM country";
            $result = $db->query($sql);
            return $result->getResultArray();
        }

        $sql =
        "
        SELECT * FROM country WHERE country_name = ?
        ";

        $result = $db->query($sql, [(ucfirst($country))])->getResultArray();
        return $result;
    }
}

?>
