<?php
namespace Tests\Unit;

use App\Utils\XMLUtils;
use PHPUnit\Framework\TestCase;
class XMLTest extends TestCase
{
    public function testIsXMLResultIsTrue()
    {
        $data = '[{"a" : "test" , "b" : "test"}]';
        $json = json_decode($data,true);
        $xml = XMLUtils::convert_xml($json);
        $this->assertEquals("<?xml version=\"1.0\"?>\n<root><b>test</b></root>\n", $xml);
    }
}
