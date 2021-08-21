<?php

namespace Tests\Unit;

use App\Http\Controllers\Filtering\StringFiltering;

use PHPUnit\Framework\TestCase;
class StringFilterTest extends TestCase
{
    public function testContainsFilter()
    {
        $test_data = '[{"name" : "ahmed"},{"name" : "test"}]';
        $arr = json_decode($test_data,true);
        $result = StringFiltering::Contains($arr,"ah","name");
        $this->assertCount(1, $result);
        $this->assertEquals('ahmed', $result[0]['name']);
    }
    public function testStartWithFilter()
    {
        $test_data = '[{"name" : "ahmed"},{"name" : "test"}]';
        $arr = json_decode($test_data,true);
        $result = StringFiltering::StartsWith($arr,"te","name");
        $this->assertCount(1, $result);
        $this->assertEquals('test', $result[0]['name']);
    }
    public function testEndWithFilter()
    {
        $test_data = '[{"name" : "ahmed"},{"name" : "test"}]';
        $arr = json_decode($test_data,true);
        $result = StringFiltering::EndWith($arr,"ed","name");
        $this->assertCount(1, $result);
        $this->assertEquals('ahmed', $result[0]['name']);
    }
    public function testEqualsFilter()
    {
        $test_data = '[{"name" : "ahmed"},{"name" : "test"}]';
        $arr = json_decode($test_data,true);
        $result = StringFiltering::Equals($arr,"ahmed","name");
        $this->assertCount(1, $result);
        $this->assertEquals('ahmed', $result[0]['name']);
    }
}
