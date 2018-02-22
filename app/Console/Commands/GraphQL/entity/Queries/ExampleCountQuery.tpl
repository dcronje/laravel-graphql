<?php
namespace App\GraphQL\Example\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Example;
use App\GraphQL\Example\ExampleHelper;

class ExampleCountQuery extends Query
{

    protected $attributes = [
        'name' => 'exampleCount'
    ];

    public function type()
    {
        return Type::nonNull(Type::int());
    }

    public function args()
    {
        return ExampleHelper::exampleCountArgs();
    }

    public function resolve($root, $args)
    {
        return ExampleHelper::exampleCountResolver($root, $args);
    }

}
