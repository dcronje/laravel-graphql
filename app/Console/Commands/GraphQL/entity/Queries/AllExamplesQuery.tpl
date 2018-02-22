<?php
namespace App\GraphQL\Example\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Example;
use App\GraphQL\Example\ExampleHelper;

class AllExamplesQuery extends Query
{

    protected $attributes = [
        'name' => 'allExamples'
    ];

    public function type()
    {
        return GraphQL::type('ExampleList');
    }

    public function args()
    {
        return ExampleHelper::allExamplesArgs();
    }

    public function resolve($root, $args)
    {
        return ExampleHelper::allExamplesResolver($root, $args);
    }

}
