<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    private function formatQuery($query)
    {
        $query = preg_replace('/\n/', '', $query);
        $query = preg_replace('/\s+/', ' ', $query);
        return urlencode($query);
    }

    public static function setUpBeforeClass()
    {
        exec("mysql -h".env('DB_HOST')." -u".env('DB_USERNAME')." -p".env('DB_PASSWORD')." -e 'DROP DATABASE IF EXISTS ".env('DB_DATABASE')."' 2> /dev/null");
        exec("mysql -h".env('DB_HOST')." -u".env('DB_USERNAME')." -p".env('DB_PASSWORD')." -e 'CREATE DATABASE ".env('DB_DATABASE')."' 2> /dev/null");
        exec("php artisan migrate --seed");
    }

    public static function tearDownAfterClass()
    {
        exec("php artisan config:cache");
    }

    public function testAddLocation()
    {
        $query = $this->formatQuery('
          mutation ADDLocationTestMutation {
            addLocation(input: { name: "Silvertree", building: "Floor 3", streetAddress: "125 Buitengracht St, Cape Town" }) {
              id
              name
              coordinates {
                longitude
                latitude
              }
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        var_dump($result);
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
            $this->assertFalse(isset($data->errors), "Errors encountered: ".$error);
        }
        $this->assertTrue($data->data->addLocation->name == "Silvertree", "Failed to add location correctly");
    }

    public function testAllLocations()
    {
        $query = $this->formatQuery('
          query AllLocationsTestQuery {
            allLocations {
              list {
                id
                name
              }
              count
              skip
              limit
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
            $this->assertFalse(isset($data->errors), "Errors encountered: ".$error);
        }
        $locations = isset($data->data->allLocations) && isset($data->data->allLocations->list) ? $data->data->allLocations->list : [];
        $this->assertFalse(count($locations) == 0, "No locations returned from allLocations Query");
    }

    public function testFilterLocations()
    {
        $query = $this->formatQuery('
          query AllLocationsTestQuery {
            allLocations(filters: { name: "john" }) {
              list {
                id
                name
              }
              count
              skip
              limit
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
            $this->assertFalse(isset($data->errors), "Errors encountered: ".$error);
        }
        $locations = isset($data->data->allLocations) && isset($data->data->allLocations->list) ? $data->data->allLocations->list : [];
        $this->assertTrue(count($locations) == 0, "Locations returned after filering allLocations Query");
    }

    public function testOneLocation()
    {
        $query = $this->formatQuery('
          query OneLocationTestQuery {
            oneLocation(id: 1) {
              id
              name
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
            $this->assertFalse(isset($data->errors), "Errors encountered: ".$error);
        }
        $this->assertTrue($data->data->oneLocation->name == "Silvertree", "Incorrect data returned from oneLocation Query");
    }

    public function testUpdateLocation()
    {
        $query = '
          mutation UpdateLocationTestMutation {
            updateLocation(id: 1, input: { name: "Silvertree Internet Holdings" }) {
              id
              name
            }
          }
        ';
        $query = $this->formatQuery($query);
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
            $this->assertFalse(isset($data->errors), "Errors encountered: ".$error);
        }
        $this->assertTrue($data->data->updateLocation->name == "Silvertree Internet Holdings", "Incorrect data returned from updateLocation Mutation");
    }

    public function testDeleteLocation()
    {
        $query = $this->formatQuery('
          mutation DeleteLocationMutation {
            removeLocation(id: 1)
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
        }
        $this->assertFalse(isset($data->errors), "Errors encountered with removeLocation Mutation: ".$error);
    }

    public function testOneLocation404Error()
    {
        $query = $this->formatQuery('
          query OneLocationTestQuery {
            oneLocation(id: 1) {
              id
              name
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $this->assertTrue(isset($data->errors), "No 404 Error thrown for oneLocation Query");
    }

    public function testUpdateLocation404Error()
    {
        $query = $this->formatQuery('
          mutation UpdateLocationTestMutation {
            updateLocation(id: 1, inputs: { name: "Silvertree Internet Holdings" }) {
              id
              name
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $this->assertTrue(isset($data->errors), "No 404 Error thrown for updateLocation Mutation");
    }


}
