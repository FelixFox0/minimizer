<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Minimizer extends Model
{
    public $timestamps = false;
//    protected static $_connection = 'slave';
//
//    protected static $_write_connection = 'master';

    protected static $_table_name = 'shortUrls';
//
//    protected static $_primary_key = ['id'];
//
//    protected static $_properties = [
//        'id' => [
//            'data_type' => 'int',
//        ],
//        'originalUrl' => [
//            'data_type' => 'char',
//        ],
//        'generatedUrl' => [
//            'data_type' => 'char',
//        ],
//        'created' => [
//            'data_type' => 'timestamp',
//        ],
//        'viewed' => [
//            'data_type' => 'int',
//            'default' => 0
//        ],
//        'instance' => [
//            'data_type' => 'char',
//            'default'   => 'default'
//        ]
//    ];

//    public static function getShortUrl(int $page = 1, int $quantity = 50, string $fieldSort = '', string $sort = '', string $instance = '', array $date = [])
//    {
//
//        $result = DB::select()
//            ->from(self::table());
//        if($instance) {
//            $result = $result->where('instance', '=', $instance);
//        }
//        if(array_filter($date)) {
//            $result->where('shortUrls.created', 'BETWEEN', $date);
//        }
//        if($fieldSort){
//            $result = $result->order_by($fieldSort, $sort ? $sort : Null);
//        }
//
//        if($page && $quantity){
//            $result = $result->offset(($page - 1) * $quantity);
//            $result = $result->limit($quantity);
//        }
//
//        $result = $result
//            ->execute('slave')
//            ->as_array('id');
//        return $result;
//
//    }

//    public static function getCountShortUrl(string $instance = '', array $date = [])
//    {
//        $result = DB::select()
//            ->from(self::table());
//        if($instance) {
//            $result = $result->where('instance', '=', $instance);
//        }
//        if(array_filter($date)) {
//            $result->where('shortUrls.created', 'BETWEEN', $date);
//        }
//
//        $result = $result
//            ->execute('slave')
//            ->count();
//        return $result;
//    }

//    public static function getMaxMinDateShortUrl(string $instance = '')
//    {
//        $result = DB::select(DB::expr('MIN(created) as fromDate, MAX(created) as toDate'))
//            ->from(self::table());
//        if($instance) {
//            $result = $result->where('instance', '=', $instance);
//        }
//        $result = $result
//            ->execute('slave')
//            ->current();
//        return $result;
//    }

    public static function add(string $originalUrl, string $newUrl, string $instance)
    {
        return DB::table(self::$_table_name)
            ->insert([
                'originalUrl'  => $originalUrl,
                'generatedUrl' => $newUrl,
                'instance'     => $instance,
            ]);
    }

    public static function updateUrl(int $id, array $param)
    {
//        var_dump($id);
//        var_dump($param);
//        die();
        return DB::table(self::$_table_name)
            ->where('id', '=', $id)
            ->update($param);
    }

    public static function exist($originUrl, string $instance)
    {
        return DB::table(self::$_table_name)
            ->where('originalUrl', '=', $originUrl)
            ->where('instance', '=', $instance)
            ->first();
    }

    public static function findMaxId(string $instance)
    {

        return DB::table(self::$_table_name)
            ->where('instance', '=', $instance)
            ->orderBy('id', 'desc')
            ->first();
    }

    public static function checkNext(string $lastGeneratedUrl, string $instance)
    {
        return DB::table(self::$_table_name)
            ->where('generatedUrl', '=', $lastGeneratedUrl)
            ->where('instance', '=', $instance)
            ->first();
    }
}

