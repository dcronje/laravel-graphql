<?php
namespace App\GraphQL\Coordinate;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Coordinate;
use App\Lib\ListObject;
use Exception;

/**
 * [CoordinateHelper a helper for building dynamic GraphQL queries and types for coordinates]
 * Author: [your_name]
 * Contact: [your_email]
 * Date: [mm-yyyy]
 */

class CoordinateHelper
{

    /**
     * [oneCoordinateField get GraphQL field for one coordinate]
     * @return {Array<String, Any>} the field
     */
    static function oneCoordinateField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('Coordinate')),
            'description' => 'The coordinate',
            'args' => self::oneCoordinateArgs(),
        ];
    }

    /**
     * [oneCoordinateArgs get GraphQL args for one coordinate]
     * @return {Array<String, Any>} the args
     */
    static function oneCoordinateArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneCoordinateResolver resolve on coordinate]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Coordinate}                                The coordinate object
     */
    static function oneCoordinateResolver($root, $args, $where = false)
    {
        $coordinate = Coordinate::where('id', '=', $args['id'])->first();
        if (!$coordinate) {
            throw new Exception('Coordinate with id: '.$args['id'].' not found!', 404);
        }
        return $coordinate;
    }

    /**
     * [allCoordinatesField get GraphQL field for all coordinates]
     * @return {Array<String, Any>} the field
     */
    static function allCoordinatesField()
    {
        return [
            'type' => GraphQL::type('CoordinateList'),
            'description' => 'The coordinates',
            'args' => self::allCoordinatesArgs(),
        ];
    }

    /**
     * [allCoordinatesArgs get GraphQL args for all coordinates]
     * @return {Array<String, Any>} the args
     */
    static function allCoordinatesArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('CoordinateListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('CoordinateListOrder'))],
      ];
    }

    /**
     * [allCoordinatesResolver resolve all coordinates]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allCoordinatesResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getCoordinatesList($root, $args, $where, $skip, $limit);
        $count = self::getCoordinateCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [coordinateCountField get GraphQL field for coordinate count]
     * @return {Array<String, Any>} the field
     */
    static function coordinateCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The coordinate count',
            'args' => self::coordinateCountArgs(),
        ];
    }

    /**
     * [coordinateCountArgs get GraphQL args for coordinate count]
     * @return {Array<String, Any>} the args
     */
    static function coordinateCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('CoordinateListFilters')],
        ];
    }

    /**
     * [coordinateCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The coordinate count
     */
    static function coordinateCountResolver($root, $args, $where)
    {
        return self::getCoordinateCount($root, $args, $where);
    }

    /**
     * [getCoordinatesList get coordinate list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned coordinates
     * @return {Array<Coordinate>}                         The coordinates
     */
    static function getCoordinatesList($root, $args, $where, $skip, $limit)
    {
        $qry = Coordinate::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getCoordinateCount get coordinatecount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of coordinates
     */
    static function getCoordinateCount($root, $args, $where)
    {
        $qry = Coordinate::where('id', '!=', null);
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
                    default:
                        break;
                }
            }
        }
    }

}
