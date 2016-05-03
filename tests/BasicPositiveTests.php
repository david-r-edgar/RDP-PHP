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

    public function testBasic2()
    {
        $line = array(
            array(-30, -40),
            array(-20, -10),
            array(10, 10),
            array(50, 0),
            array(40, -30),
            array(10, -40));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 12);

        $expectedResult = array(
            array(-30, -40),
            array(10, 10),
            array(50, 0),
            array(40, -30),
            array(10, -40));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 15);

        $expectedResult = array(
            array(-30, -40),
            array(10, 10),
            array(50, 0),
            array(10, -40));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 20);

        $expectedResult = array(
            array(-30, -40),
            array(10, 10),
            array(50, 0),
            array(10, -40));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 45);

        $expectedResult = array(
            array(-30, -40),
            array(10, 10),
            array(10, -40));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testBasic3()
    {
        $line = array(
            array(0.0034, 0.013),
            array(0.0048, 0.006),
            array(0.0062, 0.01),
            array(0.0087, 0.009));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 0.001);

        $expectedResult = array(
            array(0.0034, 0.013),
            array(0.0048, 0.006),
            array(0.0062, 0.01),
            array(0.0087, 0.009));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 0.003);

        $expectedResult = array(
            array(0.0034, 0.013),
            array(0.0048, 0.006),
            array(0.0087, 0.009));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 0.01);

        $expectedResult = array(
            array(0.0034, 0.013),
            array(0.0087, 0.009));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }
}
