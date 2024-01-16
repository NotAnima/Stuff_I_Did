<?php
namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;

class FlightControlTest extends CIUnitTestCase
{
    public function testMyFunction()
    {
        // Create an instance of your controller
        $myController = new \App\Controllers\Flights();

        // Call the function you want to test
        $result = $myController->getFlights("SIN","MIL","2023-07-25","2023-07-30",1,1);
        
        // Make assertions on the result
        $this->assertNotNull($result);
        error_log('Final Data: ' . print_r($result, true));
        error_log('Number of entries: ' . count($result));
    }
}
