<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Minimizer extends Model
{
    public $timestamps = false;
    protected static $_table_name = 'shortUrls';

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

