<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use DateTime;

class Flights extends BaseController
{
    public function index() {

        $data = [
            'title' => 'Flights',
        ];

        if (! $this->request->is('post')) {
            return view('templates/header', $data)
                . view('flights/index')
                . view('templates/footer');
        }
    }

    public function search() {
        helper(array('form', 'url'));
        $validation = \Config\Services::validation();

        $travel = array(
            'economy' => "ECONOMY",
            'premium_economy' => "PREMIUM_ECONOMY",
            'business' => "BUSINESS",
            "first_class" => "FIRST"
        );

        $data = [
            'title' => 'Flights Search',
        ];

        if (! $this->request->is('post')) {
            return view('templates/header', $data)
                . view('flights/index')
                . view('templates/footer');
        }
        else{
            $post = $this->request->getPost();
            $startLocation = $post['startLocation'];
            $endLocation = $post['endLocation'];
            $departureDate = $post['departureDate'];
            $returnDate = $post['returnDate'];
            $adults = $post['adults'];
            $children = $post['children'];
            $travelClass = $post['travelClass'];

            $validation->setRules([
                'departureDate' => 'required|date_not_in_past',
                'returnDate' => 'required|date_not_in_past|date_not_earlier_than[departureDate]',
                'startLocation' => 'required|location_not_same[endLocation]',
                'endLocation' => 'required',
                'adults' => 'required|integer',
                'travelClass' => 'required'
            ]);

            // Make sure start end date make sense
            $startTimestamp = strtotime($departureDate);
            $endTimestamp = strtotime($returnDate);

            $startDateString = date('Y-m-d', $startTimestamp);
            $endDateString = date('Y-m-d', $endTimestamp);

            // Display the dates in a string
            $dateString = $startDateString . ' - ' . $endDateString;

            if ($validation->run($post)) {
                $flights = $this->getFlights($startLocation,$endLocation,$departureDate,$returnDate,$adults,$children,$travel[$travelClass]);
                $data = [
                    'title' => 'Flights Search',
                    'flights'=> $flights,
                    'trip_dates' => $dateString
                ];
                return view('templates/header', $data)
                . view('flights/search')
                . view('templates/footer');
            } else {
                // validation failed, show errors
                $errors = $validation->getErrors();
                $data['errors'] = $errors;
                return view('templates/header', $data)
                . view('flights/index')
                . view('templates/footer');
            }
        }

    }

    public function getFlights($startLocation, $endLocation, $departureDate, $returnDate, $adults=1,$children=0 ,$travelClass="ECONOMY"){
        // Part 1: Get the access token
        $url = 'https://test.api.amadeus.com/v1/security/oauth2/token';

        // Initialize cURL
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded'
        );
        $data = array(
            'grant_type' => 'client_credentials',
            'client_id' => 'zuyZiOoXzArsEWN7wpFBN1E2182fF8AV',
            'client_secret' => 'zqG5LT00XfU4A2Wt'
        );

        // Set options
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

        // Execute the request
        $response = curl_exec($curl);

        // Check for errors
        if ($response === false) {
            $error = curl_error($curl);
            // Handle the error appropriately
            error_log('cURL Error: ' . $error);
        } else {
            // Get the HTTP status code
            $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpStatus !== 200) {
                // Handle non-200 status code
                error_log('HTTP Error: ' . $httpStatus);
            } else {
                // Get access token
                $responseData = json_decode($response, true);
                if ($responseData !== null) {
                    // Access the responseData data
                    $access_token = $responseData['access_token'];
                } else {
                    // If there's an error
                    error_log('Error decoding the JSON response');
                }
            }
        }

        // Close cURL
        curl_close($curl);

        // Part 2: Query Flight data
        // Break the start and end location into valid code
        $parts = explode('(', $startLocation);
        $startLocation = trim($parts[1], ')');

        $parts = explode('(', $endLocation);
        $endLocation = trim($parts[1], ')');

        $url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';

        $headers = array(
                'Authorization: Bearer '. $access_token,
                'Content-Type: application/json'
        );
        // Query parameters
        $params = array(
            'originLocationCode' => $startLocation,
            'destinationLocationCode' => $endLocation,
            'departureDate' => $departureDate,
            'returnDate' => $returnDate,
            'adults' => $adults,
            'travelClass' => $travelClass,
            'currencyCode' => 'SGD',
            'max' => 10,
        );

        if(!empty($children) and $children != 0){
            $params['children'] = $children;
        }
        
        // Append query parameters to the URL
        $url .= '?' . http_build_query($params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        // Execute the request
        $response = curl_exec($curl);
        // Check for errors
        if ($response === false) {
            $error = curl_error($curl);
            // Handle the error appropriately
            error_log('cURL Error: ' . $error);
        } else {
            // Get the HTTP status code
            $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpStatus !== 200) {
                // Handle non-200 status code
                error_log('HTTP Error: ' . $httpStatus);
            } else {
                // Get access token
                $responseData = json_decode($response, true);
                if ($responseData !== null) {
                    // Access the responseData data
                    $flights = $responseData['data'];
                } else {
                    // If there's an error
                    error_log('Error decoding the JSON response');
                }
            }
        }
        
        // Close cURL
        curl_close($curl);

        // Part 3: Parsing it into an array
        $final_list = array();

        foreach ($flights as $flight) {

            $details = array();
            // Trip is all the flights, flight is individual flights
            $trip_movement = array();
            $flight_movement = array();
            // Price
            $details['price'] = intval($flight['price']['total']);

            foreach ($flight['itineraries'][0]['segments'] as $segment){
                $flight_movement['departure_time'] = $segment['departure']['at'];
                $flight_movement['arrival_time'] = $segment['arrival']['at'];


                $flight_movement['start_location'] = $segment['departure']['iataCode'];
                $flight_movement['end_location'] = $segment['arrival']['iataCode'];

                // Get the flight time difference
                $departureTime = new DateTime($segment['departure']['at']);
                $arrivalTime = new DateTime($segment['arrival']['at']);
                $interval = $departureTime->diff($arrivalTime);
                $flight_movement['duration'] = $interval->format('%Hh %im');

                // Handle time of flight
                $formatted_departure = $departureTime->format('h:i A');
                $formatted_arrival = $arrivalTime->format('h:i A');
                $formatted_times = $formatted_departure . ' - ' . $formatted_arrival;
                // $details['flight_date'] = $formatted_date;
                $flight_movement['flight_time'] = $formatted_times;

                $trip_movement[] = $flight_movement;
            }
            
            $details['trip_movement'] = $trip_movement;
            // // Time of flight
            $details['overall_departure_time'] = $flight['itineraries'][0]['segments'][0]['departure']['at'];
            $details['overall_arrival_time'] = $flight['itineraries'][0]['segments'][count($flight['itineraries'][0]['segments']) - 1]['arrival']['at'];

            // Start and end location
            $details['start_location'] = $flight['itineraries'][0]['segments'][0]['departure']['iataCode'];
            $details['end_location'] = $flight['itineraries'][0]['segments'][count($flight['itineraries'][0]['segments']) - 1]['arrival']['iataCode'];

            // Airport locations
            $airport_locations = array();
            foreach ($flight['itineraries'][0]['segments'] as $segment) {
                $airport_locations[] = $segment['departure']['iataCode'];
                $airport_locations[] = $segment['arrival']['iataCode'];
            }
            $details['airport_locations'] = array_unique($airport_locations);

            // Stop Overs
            if (count($details['airport_locations']) > 2) {
                $details['number_of_stops'] = count($details['airport_locations']) - 2;
                $details['stop_over'] = $details['airport_locations'];
                unset($details['stop_over'][array_search($details['start_location'], $details['stop_over'])]);
                unset($details['stop_over'][array_search($details['end_location'], $details['stop_over'])]);
            }

            // Flight time
            // $departure_dt = new DateTime($details['overall_departure_time']);
            // $arrival_dt = new DateTime($details['overall_arrival_time']);

            // Handle date
            // $formatted_departure = $departure_dt->format('Y-m-d');
            // $formatted_arrival = $arrival_dt->format('Y-m-d');
            // $formatted_date = $formatted_departure . ' - ' . $formatted_arrival;

            // //Handle time
            // $formatted_departure = $departure_dt->format('h:i A');
            // $formatted_arrival = $arrival_dt->format('h:i A');
            // $formatted_times = $formatted_departure . ' - ' . $formatted_arrival;
            // // $details['flight_date'] = $formatted_date;
            // $details['flight_time'] = $formatted_times;

            // Duration of flight in hours and minutes
            // $interval = $departure_dt->diff($arrival_dt);
            $details['duration'] = $interval->format('%Hh %im');

            $final_list[] = $details;

        }
        return $final_list;
    }
}

?>
