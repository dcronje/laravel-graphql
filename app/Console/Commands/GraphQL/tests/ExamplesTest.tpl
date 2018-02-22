<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExamplesTest extends TestCase
{
    /**
     * Test class for Examples.
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

    public function testAddExample()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          mutation ADDExampleTestMutation {
            addExample(input: { name: "Silvertree", building: "Floor 3", streetAddress: "125 Buitengracht St, Cape Town" }) {
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
        $this->assertTrue($data->data->addExample->name == "Silvertree", "Failed to add example correctly");
    }

    public function testAllExamples()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          query AllExamplesTestQuery {
            allExamples {
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
        $examples = isset($data->data->allExamples) && isset($data->data->allExamples->list) ? $data->data->allExamples->list : [];
        $this->assertFalse(count($examples) == 0, "No examples returned from allExamples Query");
    }

    public function testFilterExamples()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          query AllExamplesTestQuery {
            allExamples(filters: { name: "john" }) {
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
        $examples = isset($data->data->allExamples) && isset($data->data->allExamples->list) ? $data->data->allExamples->list : [];
        $this->assertTrue(count($examples) == 0, "Examples returned after filering allExamples Query");
    }

    public function testOneExample()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          query OneExampleTestQuery {
            oneExample(id: 1) {
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
        $this->assertTrue($data->data->oneExample->name == "Silvertree", "Incorrect data returned from oneExample Query");
    }

    public function testUpdateExample()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = '
          mutation UpdateExampleTestMutation {
            updateExample(id: 1, input: { name: "Silvertree Internet Holdings" }) {
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
        $this->assertTrue($data->data->updateExample->name == "Silvertree Internet Holdings", "Incorrect data returned from updateExample Mutation");
    }

    public function testDeleteExample()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          mutation DeleteExampleMutation {
            removeExample(id: 1)
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $error = "";
        if (isset($data->errors)) {
            $error = $data->errors[0]->message;
        }
        $this->assertFalse(isset($data->errors), "Errors encountered with removeExample Mutation: ".$error);
    }

    public function testOneExample404Error()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          query OneExampleTestQuery {
            oneExample(id: 1) {
              id
              name
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $this->assertTrue(isset($data->errors), "No 404 Error thrown for oneExample Query");
    }

    public function testUpdateExample404Error()
    {
        //Remove this line once configured
        $this->assertTrue(false, "Test not configured");

        $query = $this->formatQuery('
          mutation UpdateExampleTestMutation {
            updateExample(id: 1, inputs: { name: "Silvertree Internet Holdings" }) {
              id
              name
            }
          }
        ');
        $result = $this->call('GET', "/graphql?query=$query");
        $data = $result->getData();
        $this->assertTrue(isset($data->errors), "No 404 Error thrown for updateExample Mutation");
    }


}
