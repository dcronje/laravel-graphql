<?php
namespace App\GraphQL\Region;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Region;
use App\Lib\ListObject;
use Exception;

/**
 * [RegionHelper a helper for building dynamic GraphQL queries and types for regions]
 * Author: [your_name]
 * Contact: [your_email]
 * Date: [mm-yyyy]
 */

class RegionHelper
{

    /**
     * [oneRegionField get GraphQL field for one region]
     * @return {Array<String, Any>} the field
     */
    static function oneRegionField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('Region')),
            'description' => 'The region',
            'args' => self::oneRegionArgs(),
        ];
    }

    /**
     * [oneRegionArgs get GraphQL args for one region]
     * @return {Array<String, Any>} the args
     */
    static function oneRegionArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneRegionResolver resolve on region]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Region}                                The region object
     */
    static function oneRegionResolver($root, $args, $where = false)
    {
        $region = Region::where('id', '=', $args['id'])->first();
        if (!$region) {
            throw new Exception('Region with id: '.$args['id'].' not found!', 404);
        }
        return $region;
    }

    /**
     * [allRegionsField get GraphQL field for all regions]
     * @return {Array<String, Any>} the field
     */
    static function allRegionsField()
    {
        return [
            'type' => GraphQL::type('RegionList'),
            'description' => 'The regions',
            'args' => self::allRegionsArgs(),
        ];
    }

    /**
     * [allRegionsArgs get GraphQL args for all regions]
     * @return {Array<String, Any>} the args
     */
    static function allRegionsArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('RegionListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('RegionListOrder'))],
      ];
    }

    /**
     * [allRegionsResolver resolve all regions]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allRegionsResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getRegionsList($root, $args, $where, $skip, $limit);
        $count = self::getRegionCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [regionCountField get GraphQL field for region count]
     * @return {Array<String, Any>} the field
     */
    static function regionCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The region count',
            'args' => self::regionCountArgs(),
        ];
    }

    /**
     * [regionCountArgs get GraphQL args for region count]
     * @return {Array<String, Any>} the args
     */
    static function regionCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('RegionListFilters')],
        ];
    }

    /**
     * [regionCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The region count
     */
    static function regionCountResolver($root, $args, $where = false)
    {
        return self::getRegionCount($root, $args, $where);
    }

    /**
     * [getRegionsList get region list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned regions
     * @return {Array<Region>}                         The regions
     */
    static function getRegionsList($root, $args, $where, $skip, $limit)
    {
        $qry = Region::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getRegionCount get regioncount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of regions
     */
    static function getRegionCount($root, $args, $where)
    {
        $qry = Region::where('id', '!=', null);
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
