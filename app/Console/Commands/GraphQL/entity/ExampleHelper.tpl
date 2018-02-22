<?php
namespace App\GraphQL\Example;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Example;
use App\Lib\ListObject;
use Exception;

/**
 * [ExampleHelper a helper for building dynamic GraphQL queries and types for examples]
 * Author: [your_name]
 * Contact: [your_email]
 * Date: [mm-yyyy]
 */

class ExampleHelper
{

    /**
     * [oneExampleField get GraphQL field for one example]
     * @return {Array<String, Any>} the field
     */
    static function oneExampleField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('Example')),
            'description' => 'The example',
            'args' => self::oneExampleArgs(),
        ];
    }

    /**
     * [oneExampleArgs get GraphQL args for one example]
     * @return {Array<String, Any>} the args
     */
    static function oneExampleArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneExampleResolver resolve on example]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Example}                                The example object
     */
    static function oneExampleResolver($root, $args, $where = false)
    {
        $example = Example::where('id', '=', $args['id'])->first();
        if (!$example) {
            throw new Exception('Example with id: '.$args['id'].' not found!', 404);
        }
        return $example;
    }

    /**
     * [allExamplesField get GraphQL field for all examples]
     * @return {Array<String, Any>} the field
     */
    static function allExamplesField()
    {
        return [
            'type' => GraphQL::type('ExampleList'),
            'description' => 'The examples',
            'args' => self::allExamplesArgs(),
        ];
    }

    /**
     * [allExamplesArgs get GraphQL args for all examples]
     * @return {Array<String, Any>} the args
     */
    static function allExamplesArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('ExampleListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('ExampleListOrder'))],
      ];
    }

    /**
     * [allExamplesResolver resolve all examples]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allExamplesResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getExamplesList($root, $args, $where, $skip, $limit);
        $count = self::getExampleCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [exampleCountField get GraphQL field for example count]
     * @return {Array<String, Any>} the field
     */
    static function exampleCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The example count',
            'args' => self::exampleCountArgs(),
        ];
    }

    /**
     * [exampleCountArgs get GraphQL args for example count]
     * @return {Array<String, Any>} the args
     */
    static function exampleCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('ExampleListFilters')],
        ];
    }

    /**
     * [exampleCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The example count
     */
    static function exampleCountResolver($root, $args, $where = false)
    {
        return self::getExampleCount($root, $args, $where);
    }

    /**
     * [getExamplesList get example list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned examples
     * @return {Array<Example>}                         The examples
     */
    static function getExamplesList($root, $args, $where, $skip, $limit)
    {
        $qry = Example::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getExampleCount get examplecount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of examples
     */
    static function getExampleCount($root, $args, $where)
    {
        $qry = Example::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        return $qry->count();
    }

    /**
     * [addWhereToQuery add where clause to eloquent query based off args]
     * @param  {EloquentQuery}            $qry           The eloquent query
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     */
    static function addWhereToQuery($qry, $root, $args, $where)
    {
        if ($where) {
            $qry->where($where[0], $where[1], $where[2]);
        }
        if (isset($args['filters']) && !empty($args['filters'])) {
          if (isset($args['filters']['name']) && !empty($args['filters']['name'])) {
              $qry->where('name', 'like', '%'.$args['filters']['name'].'%');
          }
          if (isset($args['filters']['minCreatedAt']) && !empty($args['filters']['minCreatedAt'])) {
              $qry->where('created_at', '>', $args['filters']['minCreatedAt']);
          }
          if (isset($args['filters']['maxCreatedAt']) && !empty($args['filters']['maxCreatedAt'])) {
              $qry->where('created_at', '<', $args['filters']['maxCreatedAt']);
          }
          if (isset($args['filters']['minUpdatedAt']) && !empty($args['filters']['minUpdatedAt'])) {
              $qry->where('updated_at', '>', $args['filters']['minUpdatedAt']);
          }
          if (isset($args['filters']['maxUpdatedAt']) && !empty($args['filters']['maxUpdatedAt'])) {
              $qry->where('updated_at', '<', $args['filters']['maxUpdatedAt']);
          }
        }
    }

    /**
     * [addOrderToQuery add order clause to eloquent query based off args]
     * @param  {EloquentQuery}            $qry           The eloquent query
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     */
    static function addOrderToQuery($qry, $root, $args, $where)
    {
        if (isset($args['order']) && !empty($args['order'])) {
            foreach ($args['order'] as $orderItem) {
                switch ($orderItem['field']) {
                    case 'name':
                        $qry->orderBy('name', $orderItem['direction']);
                        break;
                    case 'createdAt':
                        $qry->orderBy('created_at', $orderItem['direction']);
                        break;
                    case 'updatedAt':
                        $qry->orderBy('updated_at', $orderItem['direction']);
                        break;
                    default:
                        break;
                }
            }
        }
    }

}
