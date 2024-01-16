<?php

namespace App\Models;

use App\Libraries\DatabaseConnector;

class GuidesModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->guides;
    }

    function getGuides($name = null, $page = null) {
        try {
            if($page === null)
            {
                $page = 1;
            }
            $perPage = 12;
            $skip = ($page - 1)* $perPage;

            if ($name === null) {
                $cursor = $this->collection->find([], ['limit' => $perPage, 'skip' => $skip, 'sort' => ['_id' => -1]]);    
            } 
            
            else if($name != ""){
                $regexPattern = new \MongoDB\BSON\Regex($name, 'i');
                $cursor = $this->collection->find(['title' => $regexPattern], ['limit' => $perPage, 'skip' => $skip, 'sort' => ['_id' => -1]]);
            }else {
                $regexPattern = new \MongoDB\BSON\Regex($name, 'i');
                $cursor = $this->collection->find(['title' => $regexPattern], ['limit' => $perPage, 'skip' => $skip, 'sort' => ['_id' => -1]]);
            }
            $guides = $cursor->toArray();
            return $guides;
        } catch(\Exception $ex) {
            log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $ex]);
            throw $ex;
        }
    }

    function getGuideUser($name, $page = null) {
        try {
            if($page === null)
            {
                $page = 1;
            }
            $perPage = 6;
            $skip = ($page - 1)* $perPage;

            if ($name === null) {
                $cursor = $this->collection->find([], ['limit' => $perPage, 'skip' => $skip, 'sort' => ['_id' => -1]]);    
            } 
            else {
                $regexPattern = new \MongoDB\BSON\Regex($name, 'i');
                $cursor = $this->collection->find(['user' => $regexPattern], ['limit' => $perPage, 'skip' => $skip, 'sort' => ['_id' => -1]]);
            }
            $guides = $cursor->toArray();
            return $guides;
        } catch(\Exception $ex) {
            log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $ex]);
            throw $ex;
        }
    }

    function getGuide($id) {
        try {
            $guide = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            return $guide;
        } catch(\Exception $ex) {
            log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $ex]);
            throw $ex;
        }
    }

    function insertGuide($titles, $image ,$notes, $guide_title, $description, $user) {
        try {
            $guideData = [
                "title" => $guide_title,
                "description" => $description,
                "user" => $user,
                "days" => [],
                "image" => $image,
                "date" => date("d F Y", time())
            ];

            foreach ($titles as $index => $title) {
              $attractions = [];
              foreach ($title as $activity_index => $activity_title) {
                if (isset($notes[$index][$activity_index])){
                  $note = $notes[$index][$activity_index];
                  $attraction = [
                      "title" => $activity_title,
                      "details" => $note
                  ];
                  $attractions[] = $attraction;
                }
              }
              $day = [
                "number" => $index + 1,
                "attractions" => $attractions
              ];

              $guideData["days"][] = $day;
            }
            $insertOneResult = $this->collection->insertOne($guideData);

            if($insertOneResult->getInsertedCount() == 1) {
                return true;
            }

            return false;
        } catch(\Exception $ex) {
            log_message('error', 'Error inserting guides to database : {exception}', ['exception' => $ex]);
            throw $ex;
        }
    }

    function updateGuide($id, $titles, $image, $notes, $guide_title, $description, $user) {
        try {
            $guideData = [
                "title" => $guide_title,
                "description" => $description,
                "user" => $user,
                "days" => [],
                "image" => $image
            ];

            foreach ($titles as $index => $title) {
              $attractions = [];
              foreach ($title as $activity_index => $activity_title) {
                if (isset($notes[$index][$activity_index])){
                  $note = $notes[$index][$activity_index];
                  $attraction = [
                      "title" => $activity_title,
                      "details" => $note
                  ];
                  $attractions[] = $attraction;
                }
              }
              $day = [
                "number" => $index + 1,
                "attractions" => $attractions
              ];

              $guideData["days"][] = $day;
            }
            $result = $this->collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => $guideData]
            );

            if($result->getModifiedCount()) {
                return true;
            }

            return false;
        } catch(\Exception $ex) {
            log_message('error', 'Error updating guides from database : {exception}', ['exception' => $ex]);
            throw $ex;
        }
    }

    function deleteGuide($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            if($result->getDeletedCount() == 1) {
                return true;
            }

            return false;
        } catch(\Exception $ex) {
            log_message('error', 'Error deleting guides from database : {exception}', ['exception' => $ex]);
            throw $ex;
        }
    }

    function docCount($name = null)
    {
        try {
            if($name != null)
            {
                $count = $this->collection->count(['title' => $name]);
                return $count;
            }
            $count = $this->collection->count([]);
            return $count;
        }
        catch(\Exception $ex) {
        log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $ex]);
        throw $ex;
        }
    }

    function userDocCount($name = null)
    {
        try {
            if($name != null)
            {
                $count = $this->collection->count(['user' => $name]);
                return $count;
            }
            $count = $this->collection->count([]);
            return $count;
        }
        catch(\Exception $ex) {
        log_message('error', 'Error fetching guides from database : {exception}', ['exception' => $ex]);
        throw $ex;
        }
    }

}
