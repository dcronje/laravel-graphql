<?php
namespace App\GraphQL\Example\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Example;
use App\Lib\GoogleGeo;
use App\Lib\Examples;
use Exception;

class UpdateExampleMutation extends Mutation
{

    protected $attributes = [
        'name' => 'updateExample',
    ];

    public function type()
    {
        return GraphQL::type('Example');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
            'input' => ['name' => 'input', 'type' => Type::nonNull(Graphql::type('ExampleUpdateInput'))],
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
        $example = Example::where('id', '=', $args['id'])->first();
        if (!$example) {
            throw new Exception('Example with id: '.$args['id'].' not found!', 404);
        }
        $example->update($args['input']);
        $example->save();
        return $example;
    }

}
