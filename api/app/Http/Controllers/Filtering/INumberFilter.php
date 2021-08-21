<?php


namespace App\Http\Controllers\Filtering;


interface INumberFilter
{
    public static function Gte(array $data, float $gte, string $key) : array;
    public static function Lte(array $data, float $lte, string $key) : array;
    public static function Equals(array $data, float $equals, string $key) : array;
}
