<?php
namespace App\GraphQL\Location\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Location;
use Exception;

class RemoveLocationMutation extends Mutation
{

    protected $attributes = [
        'name' => 'removeLocation',
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
        $location = Location::where('id', '=', $args['id'])->first();
        if (!$location) {
          throw new Exception('Location with id: '.$args['id'].' not found!', 404);
        }
        $location->delete();
        return $args['id'];
    }

}
