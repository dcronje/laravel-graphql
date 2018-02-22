<?php
namespace App\GraphQL;

interface Exporter {

    static function getTypes();
    static function getQueries();
    static function getMutations();

}
