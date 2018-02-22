<?php
namespace App\GraphQL\Example\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Example;
use App\GraphQL\Example\ExampleHelper;

class OneExampleQuery extends Query
{

    protected $attributes = [
        'name' => 'oneExample'
    ];

    public function type()
    {
        return GraphQL::type('Example');
    }

    public function args()
    {
        return ExampleHelper::oneExampleArgs();
    }

    public function resolve($root, $args)
    {
        return ExampleHelper::oneExampleResolver($root, $args);
    }

}
