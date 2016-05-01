<?php
//The author has placed this work in the Public Domain, thereby relinquishing all copyrights.
//You may use, modify, republish, sell or give away this work without prior consent.
//This implementation comes with no warranty or guarantee of fitness for any purpose.

//=========================================================================
//An implementation of the Ramer-Douglas-Peucker algorithm for reducing
//the number of points on a polyline
//see http://en.wikipedia.org/wiki/Ramer%E2%80%93Douglas%E2%80%93Peucker_algorithm
//=========================================================================



//Finds the perpendicular distance from a point to a straight line.
//The coordinates of the point are specified as $ptX and $ptY.
//The line passes through points l1 and l2, specified respectively with their
//coordinates $l1x and $l1y, and $l2x and $l2y
function perpendicularDistance($ptX, $ptY, $l1x, $l1y, $l2x, $l2y)
{
    $result = 0;
    if ($l2x == $l1x)
    {
        //vertical lines - treat this case specially to avoid divide by zero
        $result = abs($ptX - $l2x);
    }
    else
    {
        $slope = (($l2y-$l1y) / ($l2x-$l1x));
        $passThroughY = (0-$l1x)*$slope + $l1y;
        $result = (abs(($slope * $ptX) - $ptY + $passThroughY)) / (sqrt($slope*$slope + 1));
    }
    return $result;
}

//RamerDouglasPeucker
//Reduces the number of points on a polyline by removing those that are closer to the line
//than the distance $epsilon.
//The polyline is provided as an array of arrays, where each internal array is one point on the polyline,
//specified by easting (x-coordinate) with key "E" and northing (y-coordinate) with key "N".
//It is assumed that the coordinates and distance $epsilon are given in the same units.
//The result is returned as an array in a similar format.
//Each point returned in the result array will retain all its original data, including its E and N
//values along with any others.
function RamerDouglasPeucker($pointList, $epsilon)
{
    // Find the point with the maximum distance
    $dmax = 0;
    $index = 0;
    $totalPoints = count($pointList);
    for ($i = 1; $i < ($totalPoints - 1); $i++)
    {
        $d = perpendicularDistance($pointList[$i]["E"], $pointList[$i]["N"],
                                   $pointList[0]["E"], $pointList[0]["N"],
                                   $pointList[$totalPoints-1]["E"], $pointList[$totalPoints-1]["N"]);
			   
        if ($d > $dmax)
        {
            $index = $i;
            $dmax = $d;
        }
    }

    $resultList = array();
	
    // If max distance is greater than epsilon, recursively simplify
    if ($dmax >= $epsilon)
    {
        // Recursive call
        $recResults1 = RamerDouglasPeucker(array_slice($pointList, 0, $index + 1), $epsilon);
        $recResults2 = RamerDouglasPeucker(array_slice($pointList, $index, $totalPoints - $index), $epsilon);

        // Build the result list
        $resultList = array_merge(array_slice($recResults1, 0, count($recResults1) - 1),
                                  array_slice($recResults2, 0, count($recResults2)));
    }
    else
    {
        $resultList = array($pointList[0], $pointList[$totalPoints-1]);
    }
    // Return the result
    return $resultList;
}

?>
