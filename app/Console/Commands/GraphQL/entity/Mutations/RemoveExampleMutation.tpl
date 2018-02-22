<?php
namespace App\GraphQL\Example\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Example;
use Exception;

class RemoveExampleMutation extends Mutation
{

    protected $attributes = [
        'name' => 'removeExample',
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
        $example = Example::where('id', '=', $args['id'])->first();
        if (!$example) {
          throw new Exception('Example with id: '.$args['id'].' not found!', 404);
        }
        $example->delete();
        return $args['id'];
    }

}
