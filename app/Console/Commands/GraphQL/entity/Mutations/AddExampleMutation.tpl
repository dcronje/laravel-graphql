<?php
namespace App\GraphQL\Example\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Example;
use App\Lib\GoogleGeo;
use App\Lib\Examples;
use Exception;

class AddExampleMutation extends Mutation
{

    protected $attributes = [
        'name' => 'addExample',
    ];

    public function type()
    {
        return GraphQL::type('Example');
    }

    public function args()
    {
        return [
            'input' => ['name' => 'input', 'type' => Type::nonNull(GraphQL::type('ExampleAddInput'))],
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
        $example = new Example($args['input']);
        $example->save();
        return $exmaple;
    }

}
