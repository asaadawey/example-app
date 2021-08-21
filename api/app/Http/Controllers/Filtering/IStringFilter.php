<?php


namespace App\Http\Controllers\Filtering;


interface IStringFilter
{
    public static function Contains(array $data, string $contains, string $key) : array;
    public static function StartsWith(array $data, string $start_with, string $key) : array;
    public static function EndWith(array $data, string $end_with, string $key) : array;
    public static function Equals(array $data, string $equals, string $key) : array;
}
