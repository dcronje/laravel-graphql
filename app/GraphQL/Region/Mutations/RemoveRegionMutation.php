<?php
namespace App\GraphQL\Region\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Region;
use Exception;

class RemoveRegionMutation extends Mutation
{

    protected $attributes = [
        'name' => 'removeRegion',
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
        $region = Region::where('id', '=', $args['id'])->first();
        if (!$region) {
          throw new Exception('Region with id: '.$args['id'].' not found!', 404);
        }
        $region->delete();
        return $args['id'];
    }

}
