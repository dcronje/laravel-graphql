<?php
namespace App\GraphQL\Region\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Region;
use App\Lib\GoogleGeo;
use App\Lib\Regions;
use Exception;

class UpdateRegionMutation extends Mutation
{

    protected $attributes = [
        'name' => 'updateRegion',
    ];

    public function type()
    {
        return GraphQL::type('Region');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
            'input' => ['name' => 'input', 'type' => Type::nonNull(Graphql::type('RegionUpdateInput'))],
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
        $region = Region::where('id', '=', $args['id'])->first();
        if (!$region) {
            throw new Exception('Region with id: '.$args['id'].' not found!', 404);
        }
        $region->update($args['input']);
        $region->save();
        return $region;
    }

}
