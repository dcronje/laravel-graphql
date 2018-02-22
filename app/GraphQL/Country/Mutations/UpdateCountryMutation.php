<?php
namespace App\GraphQL\Country\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Country;
use App\Lib\GoogleGeo;
use App\Lib\Countries;
use Exception;

class UpdateCountryMutation extends Mutation
{

    protected $attributes = [
        'name' => 'updateCountry',
    ];

    public function type()
    {
        return GraphQL::type('Country');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
            'input' => ['name' => 'input', 'type' => Type::nonNull(Graphql::type('CountryUpdateInput'))],
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
        $country = Country::where('id', '=', $args['id'])->first();
        if (!$country) {
            throw new Exception('Country with id: '.$args['id'].' not found!', 404);
        }
        $country->update($args['input']);
        $country->save();
        return $country;
    }

}
