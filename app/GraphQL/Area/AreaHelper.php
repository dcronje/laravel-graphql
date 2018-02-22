<?php
namespace App\GraphQL\Area;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Area;
use App\Lib\ListObject;
use Exception;

/**
 * [AreaHelper a helper for building dynamic GraphQL queries and types for areas]
 * Author: [your_name]
 * Contact: [your_email]
 * Date: [mm-yyyy]
 */

class AreaHelper
{

    /**
     * [oneAreaField get GraphQL field for one area]
     * @return {Array<String, Any>} the field
     */
    static function oneAreaField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('Area')),
            'description' => 'The area',
            'args' => self::oneAreaArgs(),
        ];
    }

    /**
     * [oneAreaArgs get GraphQL args for one area]
     * @return {Array<String, Any>} the args
     */
    static function oneAreaArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneAreaResolver resolve on area]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Area}                                The area object
     */
    static function oneAreaResolver($root, $args, $where = false)
    {
        $area = Area::where('id', '=', $args['id'])->first();
        if (!$area) {
            throw new Exception('Area with id: '.$args['id'].' not found!', 404);
        }
        return $area;
    }

    /**
     * [allAreasField get GraphQL field for all areas]
     * @return {Array<String, Any>} the field
     */
    static function allAreasField()
    {
        return [
            'type' => GraphQL::type('AreaList'),
            'description' => 'The areas',
            'args' => self::allAreasArgs(),
        ];
    }

    /**
     * [allAreasArgs get GraphQL args for all areas]
     * @return {Array<String, Any>} the args
     */
    static function allAreasArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('AreaListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('AreaListOrder'))],
      ];
    }

    /**
     * [allAreasResolver resolve all areas]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allAreasResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getAreasList($root, $args, $where, $skip, $limit);
        $count = self::getAreaCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [areaCountField get GraphQL field for area count]
     * @return {Array<String, Any>} the field
     */
    static function areaCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The area count',
            'args' => self::areaCountArgs(),
        ];
    }

    /**
     * [areaCountArgs get GraphQL args for area count]
     * @return {Array<String, Any>} the args
     */
    static function areaCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('AreaListFilters')],
        ];
    }

    /**
     * [areaCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The area count
     */
    static function areaCountResolver($root, $args, $where = false)
    {
        return self::getAreaCount($root, $args, $where);
    }

    /**
     * [getAreasList get area list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned areas
     * @return {Array<Area>}                         The areas
     */
    static function getAreasList($root, $args, $where, $skip, $limit)
    {
        $qry = Area::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getAreaCount get areacount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of areas
     */
    static function getAreaCount($root, $args, $where)
    {
        $qry = Area::where('id', '!=', null);
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
