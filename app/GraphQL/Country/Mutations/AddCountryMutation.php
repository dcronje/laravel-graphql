<?php
namespace App\GraphQL\Country\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Country;
use App\Lib\GoogleGeo;
use App\Lib\Countries;
use Exception;

class AddCountryMutation extends Mutation
{

    protected $attributes = [
        'name' => 'addCountry',
    ];

    public function type()
    {
        return GraphQL::type('Country');
    }

    public function args()
    {
        return [
            'input' => ['name' => 'input', 'type' => Type::nonNull(GraphQL::type('CountryAddInput'))],
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
        $country = new Country($args['input']);
        $country->save();
        return $exmaple;
    }

}
