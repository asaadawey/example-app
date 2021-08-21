<?php


namespace App\Http\Controllers\Filtering;


class StringFiltering implements IStringFilter
{

    public static function Contains(array $data, string $contains, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (strpos($item[$key],$contains)!==false)
                array_push($result,$item);
        return $result;
    }

    public static function StartsWith(array $data, string $start_with, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (str_starts_with(strtolower($item[$key]),strtolower($start_with)))
                array_push($result,$item);
        return $result;
    }

    public static function EndWith(array $data, string $end_with, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (str_ends_with(strtolower($item[$key]),strtolower($end_with)))
                array_push($result,$item);
        return $result;
    }

    public static function Equals(array $data, string $equals, string $key): array
    {
        $result = array();
        foreach ($data as $item)
            if (strcmp($item[$key], $equals) == 0)
                array_push($result, $item);
        return $result;
    }
}
