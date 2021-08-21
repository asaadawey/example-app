<?php

use App\Utils\XMLUtils;
use PHPUnit\Framework\TestCase;
use App\Http\Controllers\Filtering\NumberFiltering;
class NumberFilterTest extends TestCase
{
    public function testContainsFilter()
    {
        $test_data = '[{"age" : 18},{"age" : 20}]';
        $arr = json_decode($test_data,true);
        $result = NumberFiltering::Equals($arr,20,"age");
        $this->assertCount(1, $result);
        $this->assertEquals('20', $result[0]['age']);
    }
    public function testStartWithFilter()
    {
        $test_data = '[{"age" : 18},{"age" : 20}]';
        $arr = json_decode($test_data,true);
        $result = NumberFiltering::Gte($arr,20,"age");
        $this->assertCount(1, $result);
        $this->assertEquals('20', $result[0]['age']);
    }
    public function testEndWithFilter()
    {
        $test_data = '[{"age" : 18},{"age" : 20}]';
        $arr = json_decode($test_data,true);
        $result = NumberFiltering::Lte($arr,18,"age");
        $this->assertCount(1, $result);
        $this->assertEquals('18', $result[0]['age']);
    }

}
