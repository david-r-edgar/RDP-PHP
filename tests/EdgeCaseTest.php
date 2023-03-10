<?php
namespace davidredgar\polyline;

class EdgeCaseTests extends \PHPUnit\Framework\TestCase
{
    public function testNoPointsInLine()
    {
        $line = array();

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 1);

        $expectedResult = array();

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testOnePointInLine()
    {
        $line = array(array(10, 10));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 1);

        $expectedResult = array(array(10, 10));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testTwoPointsInLine()
    {
        $line = array(array(10, 10), array(20, 20));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 1);

        $expectedResult = array(array(10, 10), array(20, 20));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testLineWithJustTwoIdenticalPoints()
    {
        $line = array(array(1, 2), array(3, 5));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 1);

        $expectedResult = array(array(1, 2), array(3, 5));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 10);
        //same expected result
        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testThreePointsWithIdenticalStartAndEndLine()
    {
        $line = array(array(0.1, 0.1), array(0.9, 0.7), array(0.1, 0.1));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 0.2);

        $expectedResult = array(array(0.1, 0.1), array(0.9, 0.7), array(0.1, 0.1));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 0.9);

        $expectedResult = array(array(0.1, 0.1), array(0.1, 0.1));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testEpsilon0()
    {
        $line = array(array(3400, 89000), array(5500, 52000), array(4800, 41000));

        $invalidParameterExceptionsCaught = 0;

        try
        {
            $rdpResult = RDP::RamerDouglasPeucker2d($line, 0);
        }
        catch (InvalidParameterException $e)
        {
            $invalidParameterExceptionsCaught ++;
        }

        $this->assertEquals(1, $invalidParameterExceptionsCaught, "expected exception not thrown");
    }

    public function testNegativeEpsilon()
    {
        $line = array(array(125.6, 89.5), array(97.4, 101.0), array(70.8, 109.1));

        $invalidParameterExceptionsCaught = 0;

        try
        {
            $rdpResult = RDP::RamerDouglasPeucker2d($line, -20);
        }
        catch (InvalidParameterException $e)
        {
            $invalidParameterExceptionsCaught ++;
        }

        $this->assertEquals(1, $invalidParameterExceptionsCaught, "expected exception not thrown");
    }

    public function testHorizontalLine()
    {
        $line = array(array(10, 10), array(20, 10), array(30, 10), array(40, 10));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 5);

        $expectedResult = array(array(10, 10), array(40, 10));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }

    public function testVerticalLine()
    {
        $line = array(array(-20, -20), array(-20, -10), array(-20, 0), array(-20, 10));

        $rdpResult = RDP::RamerDouglasPeucker2d($line, 5);

        $expectedResult = array(array(-20, -20), array(-20, 10));

        $this->assertEquals($expectedResult, $rdpResult, "result polyline array incorrect");
    }
}
