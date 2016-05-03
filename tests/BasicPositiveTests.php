<?php
namespace davidredgar\polyline;

class BasicPositiveTests extends \PHPUnit_Framework_TestCase
{
    public function testBasic1()
    {
        $line = array(
            array(150, 10),
            array(200, 100),
            array(360, 170),
            array(500, 280));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 30);
        
        $expectedResult = array(
            array(150, 10),
            array(200, 100),
            array(500, 280));
        
        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");        
    }
}
