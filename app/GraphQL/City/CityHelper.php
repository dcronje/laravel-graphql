<?php
namespace App\GraphQL\City;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\City;
use App\Lib\ListObject;
use Exception;

/**
 * [CityHelper a helper for building dynamic GraphQL queries and types for cities]
 * Author: [your_name]
 * Contact: [your_email]
 * Date: [mm-yyyy]
 */

class CityHelper
{

    /**
     * [oneCityField get GraphQL field for one city]
     * @return {Array<String, Any>} the field
     */
    static function oneCityField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('City')),
            'description' => 'The city',
            'args' => self::oneCityArgs(),
        ];
    }

    /**
     * [oneCityArgs get GraphQL args for one city]
     * @return {Array<String, Any>} the args
     */
    static function oneCityArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneCityResolver resolve on city]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {City}                                The city object
     */
    static function oneCityResolver($root, $args, $where = false)
    {
        $city = City::where('id', '=', $args['id'])->first();
        if (!$city) {
            throw new Exception('City with id: '.$args['id'].' not found!', 404);
        }
        return $city;
    }

    /**
     * [allCitiesField get GraphQL field for all cities]
     * @return {Array<String, Any>} the field
     */
    static function allCitiesField()
    {
        return [
            'type' => GraphQL::type('CityList'),
            'description' => 'The cities',
            'args' => self::allCitiesArgs(),
        ];
    }

    /**
     * [allCitiesArgs get GraphQL args for all cities]
     * @return {Array<String, Any>} the args
     */
    static function allCitiesArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('CityListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('CityListOrder'))],
      ];
    }

    /**
     * [allCitiesResolver resolve all cities]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allCitiesResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getCitiesList($root, $args, $where, $skip, $limit);
        $count = self::getCityCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [cityCountField get GraphQL field for city count]
     * @return {Array<String, Any>} the field
     */
    static function cityCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The city count',
            'args' => self::cityCountArgs(),
        ];
    }

    /**
     * [cityCountArgs get GraphQL args for city count]
     * @return {Array<String, Any>} the args
     */
    static function cityCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('CityListFilters')],
        ];
    }

    /**
     * [cityCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The city count
     */
    static function cityCountResolver($root, $args, $where = false)
    {
        return self::getCityCount($root, $args, $where);
    }

    /**
     * [getCitiesList get city list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned cities
     * @return {Array<City>}                         The cities
     */
    static function getCitiesList($root, $args, $where, $skip, $limit)
    {
        $qry = City::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getCityCount get citycount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of cities
     */
    static function getCityCount($root, $args, $where)
    {
        $qry = City::where('id', '!=', null);
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
