<?php


namespace App\Http\Controllers\Filtering;


class NumberFiltering implements INumberFilter
{

    public static function Gte(array $data, float $gte, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (intval($item[$key]) >= $gte)
                array_push($result,$item);
        return $result;
    }

    public static function Lte(array $data, float $lte, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (intval($item[$key]) <= $lte)
                array_push($result,$item);
        return $result;
    }

    public static function Equals(array $data, float $equals, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (intval($item[$key]) == $equals)
                array_push($result,$item);
        return $result;
    }
}
