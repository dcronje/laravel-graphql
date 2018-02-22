<?php
namespace App\GraphQL\Region\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Region;
use App\Lib\GoogleGeo;
use App\Lib\Regions;
use Exception;

class AddRegionMutation extends Mutation
{

    protected $attributes = [
        'name' => 'addRegion',
    ];

    public function type()
    {
        return GraphQL::type('Region');
    }

    public function args()
    {
        return [
            'input' => ['name' => 'input', 'type' => Type::nonNull(GraphQL::type('RegionAddInput'))],
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
        $region = new Region($args['input']);
        $region->save();
        return $exmaple;
    }

}
