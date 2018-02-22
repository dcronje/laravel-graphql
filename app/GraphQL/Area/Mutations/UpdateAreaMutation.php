<?php
namespace App\GraphQL\Area\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Area;
use App\Lib\GoogleGeo;
use App\Lib\Areas;
use Exception;

class UpdateAreaMutation extends Mutation
{

    protected $attributes = [
        'name' => 'updateArea',
    ];

    public function type()
    {
        return GraphQL::type('Area');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
            'input' => ['name' => 'input', 'type' => Type::nonNull(Graphql::type('AreaUpdateInput'))],
        ];
    }

    public function rules()
    {
        return [
            'id' => ['required'],
            'input' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $area = Area::where('id', '=', $args['id'])->first();
        if (!$area) {
            throw new Exception('Area with id: '.$args['id'].' not found!', 404);
        }
        $area->update($args['input']);
        $area->save();
        return $area;
    }

}
