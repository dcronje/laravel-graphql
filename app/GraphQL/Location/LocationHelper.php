<?php
namespace App\GraphQL\Location;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Location;
use App\Lib\ListObject;
use Exception;

/**
 * [LocationHelper a helper for building dynamic GraphQL queries and types for locations]
 * Author: Drew Cronje
 * Contact: drew@silvertree.services
 * Date: 02-2018
 */

class LocationHelper
{

    /**
     * [oneLocationField get GraphQL field for one location]
     * @return {Array<String, Any>} the field
     */
    static function oneLocationField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('Location')),
            'description' => 'The location',
            'args' => self::oneLocationArgs(),
        ];
    }

    /**
     * [oneLocationArgs get GraphQL args for one location]
     * @return {Array<String, Any>} the args
     */
    static function oneLocationArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneLocationResolver resolve on location]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Location}                                The location object
     */
    static function oneLocationResolver($root, $args, $where = false)
    {
        $location = Location::where('id', '=', $args['id'])->first();
        if (!$location) {
            throw new Exception('Location with id: '.$args['id'].' not found!', 404);
        }
        return $location;
    }

    /**
     * [allLocationsField get GraphQL field for all locations]
     * @return {Array<String, Any>} the field
     */
    static function allLocationsField()
    {
        return [
            'type' => GraphQL::type('LocationList'),
            'description' => 'The locations',
            'args' => self::allLocationsArgs(),
        ];
    }

    /**
     * [allLocationsArgs get GraphQL args for all locations]
     * @return {Array<String, Any>} the args
     */
    static function allLocationsArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('LocationListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('LocationListOrder'))],
      ];
    }

    /**
     * [allLocationsResolver resolve all locations]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allLocationsResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getLocationsList($root, $args, $where, $skip, $limit);
        $count = self::getLocationCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [locationCountField get GraphQL field for location count]
     * @return {Array<String, Any>} the field
     */
    static function locationCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The location count',
            'args' => self::locationCountArgs(),
        ];
    }

    /**
     * [locationCountArgs get GraphQL args for location count]
     * @return {Array<String, Any>} the args
     */
    static function locationCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('LocationListFilters')],
        ];
    }

    /**
     * [locationCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The location count
     */
    static function locationCountResolver($root, $args, $where = false)
    {
        return self::getLocationCount($root, $args, $where);
    }

    /**
     * [getLocationsList get location list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned locations
     * @return {Array<Location>}                         The locations
     */
    static function getLocationsList($root, $args, $where, $skip, $limit)
    {
        $qry = Location::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getLocationCount get locationcount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of locations
     */
    static function getLocationCount($root, $args, $where)
    {
        $qry = Location::where('id', '!=', null);
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
            if (isset($args['filters']) && !empty($args['filters'])) {
                if (isset($args['filters']['countries']) && !empty($args['filters']['countries'])) {
                    $qry->whereIn('countryId', $args['filters']['countries']);
                }
                if (isset($args['filters']['regions']) && !empty($args['filters']['regions'])) {
                    $qry->whereIn('regionId', $args['filters']['regions']);
                }
                if (isset($args['filters']['cities']) && !empty($args['filters']['cities'])) {
                    $qry->whereIn('cityId', $args['filters']['cities']);
                }
                if (isset($args['filters']['areas']) && !empty($args['filters']['areas'])) {
                    $qry->whereIn('areaId', $args['filters']['areas']);
                }
                if (isset($args['filters']['name']) && !empty($args['filters']['name'])) {
                    $qry->where('name', 'like', '%'.$args['filters']['name'].'%');
                }
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
