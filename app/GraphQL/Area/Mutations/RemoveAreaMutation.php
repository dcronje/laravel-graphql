<?php
namespace App\GraphQL\Area\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Area;
use Exception;

class RemoveAreaMutation extends Mutation
{

    protected $attributes = [
        'name' => 'removeArea',
    ];

    public function type()
    {
        return Type::id();
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
        ];
    }

    public function rules()
    {
        return [
            'id' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $area = Area::where('id', '=', $args['id'])->first();
        if (!$area) {
          throw new Exception('Area with id: '.$args['id'].' not found!', 404);
        }
        $area->delete();
        return $args['id'];
    }

}
