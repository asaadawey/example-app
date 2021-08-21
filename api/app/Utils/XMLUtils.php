<?php


namespace App\Utils;


class XMLUtils
{
    public static function convert_xml(array $data) : string
    {
        $xml = new \SimpleXMLElement('<root/>');
        for ($i = 0; $i < count($data); $i++) {
            foreach (array_keys($data[$i]) as $key)
                $data[$i][$key] = strval($data[$i][$key]);
            $data[$i] = array_flip($data[$i]);
        }
        array_walk_recursive($data, array ($xml, 'addChild'));
        return $xml->asXML();

    }
}
