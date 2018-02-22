<?php
namespace App\GraphQL\Area\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Area;
use App\Lib\GoogleGeo;
use App\Lib\Areas;
use Exception;

class AddAreaMutation extends Mutation
{

    protected $attributes = [
        'name' => 'addArea',
    ];

    public function type()
    {
        return GraphQL::type('Area');
    }

    public function args()
    {
        return [
            'input' => ['name' => 'input', 'type' => Type::nonNull(GraphQL::type('AreaAddInput'))],
        ];
    }

    public function rules()
    {
        return [
            'input' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $area = new Area($args['input']);
        $area->save();
        return $exmaple;
    }

}
