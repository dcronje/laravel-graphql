<?php
namespace App\GraphQL\Area\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Area;
use App\GraphQL\Area\AreaHelper;

class OneAreaQuery extends Query
{

    protected $attributes = [
        'name' => 'oneArea'
    ];

    public function type()
    {
        return GraphQL::type('Area');
    }

    public function args()
    {
        return AreaHelper::oneAreaArgs();
    }

    public function resolve($root, $args)
    {
        return AreaHelper::oneAreaResolver($root, $args);
    }

}
