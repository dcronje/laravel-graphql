<?php
namespace App\GraphQL\Country;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Country;
use App\Lib\ListObject;
use Exception;

/**
 * [CountryHelper a helper for building dynamic GraphQL queries and types for countries]
 * Author: [your_name]
 * Contact: [your_email]
 * Date: [mm-yyyy]
 */

class CountryHelper
{

    /**
     * [oneCountryField get GraphQL field for one country]
     * @return {Array<String, Any>} the field
     */
    static function oneCountryField()
    {
        return [
            'type' => Type::nonNull(GraphQL::type('Country')),
            'description' => 'The country',
            'args' => self::oneCountryArgs(),
        ];
    }

    /**
     * [oneCountryArgs get GraphQL args for one country]
     * @return {Array<String, Any>} the args
     */
    static function oneCountryArgs()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
        ];
    }

    /**
     * [oneCountryResolver resolve on country]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Country}                                The country object
     */
    static function oneCountryResolver($root, $args, $where = false)
    {
        $country = Country::where('id', '=', $args['id'])->first();
        if (!$country) {
            throw new Exception('Country with id: '.$args['id'].' not found!', 404);
        }
        return $country;
    }

    /**
     * [allCountriesField get GraphQL field for all countries]
     * @return {Array<String, Any>} the field
     */
    static function allCountriesField()
    {
        return [
            'type' => GraphQL::type('CountryList'),
            'description' => 'The countries',
            'args' => self::allCountriesArgs(),
        ];
    }

    /**
     * [allCountriesArgs get GraphQL args for all countries]
     * @return {Array<String, Any>} the args
     */
    static function allCountriesArgs()
    {
      return [
          'skip' => ['name' => 'skip', 'type' => Type::int()],
          'limit' => ['name' => 'limit', 'type' => Type::int()],
          'filters' => ['name' => 'filters', 'type' => GraphQL::type('CountryListFilters')],
          'order' => ['name' => 'order', 'type' => Type::listOf(GraphQL::type('CountryListOrder'))],
      ];
    }

    /**
     * [allCountriesResolver resolve all countries]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The list Object
     */
    static function allCountriesResolver($root, $args, $where = false)
    {
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $limit = isset($args['limit']) ? $args['limit'] : 1000;
        $list = self::getCountriesList($root, $args, $where, $skip, $limit);
        $count = self::getCountryCount($root, $args, $where, $skip, $limit);
        return new ListObject($list, $count, $skip, $limit);
    }

    /**
     * [countryCountField get GraphQL field for country count]
     * @return {Array<String, Any>} the field
     */
    static function countryCountField()
    {
        return [
            'type' => Type::nonNull(Type::int()),
            'description' => 'The country count',
            'args' => self::countryCountArgs(),
        ];
    }

    /**
     * [countryCountArgs get GraphQL args for country count]
     * @return {Array<String, Any>} the args
     */
    static function countryCountArgs()
    {
        return [
            'filters' => ['name' => 'filters', 'type' => GraphQL::type('CountryListFilters')],
        ];
    }

    /**
     * [countryCountResolver description]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {ListObject}                              The country count
     */
    static function countryCountResolver($root, $args, $where = false)
    {
        return self::getCountryCount($root, $args, $where);
    }

    /**
     * [getCountriesList get country list helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @param  {Integer}                  $skip          Skip an amount of loations in the return
     * @param  {Integer}                  $limit         Limit the amount of returned countries
     * @return {Array<Country>}                         The countries
     */
    static function getCountriesList($root, $args, $where, $skip, $limit)
    {
        $qry = Country::where('id', '!=', null);
        self::addWhereToQuery($qry, $root, $args, $where);
        self::addOrderToQuery($qry, $root, $args, $where);
        $qry->skip($skip);
        $qry->limit($limit);
        return $qry->get()->toArray();
    }

    /**
     * [getCountryCount get countrycount helper function]
     * @param  {Object}                   $root          GraphQL Object root
     * @param  {Array<String, Any>}       $args          GraphQL Query args
     * @param  {Boolean | Array<String>}  $where         Added where clause for calling object
     * @return {Integer}                                 The count of countries
     */
    static function getCountryCount($root, $args, $where)
    {
        $qry = Country::where('id', '!=', null);
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
