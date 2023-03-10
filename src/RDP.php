<?php
namespace davidredgar\polyline;

/**
 * An implementation of the Ramer-Douglas-Peucker algorithm for reducing
 * the number of points on a polyline.
 *
 * For more information, see:
 * http://en.wikipedia.org/wiki/Ramer%E2%80%93Douglas%E2%80%93Peucker_algorithm
 *
 * @author David Edgar
 *
 * @license PD The author has placed this work in the Public Domain, thereby
 * relinquishing all copyrights.
 * You may use, modify, republish, sell or give away this work without prior
 * consent.
 * This implementation comes with no warranty or guarantee of fitness for any
 * purpose.
 */

require_once __DIR__ .'/../vendor/autoload.php';

class InvalidParameterException extends \Exception { }

class RDP
{
    /**
     * Finds the perpendicular distance from a point to a straight line.
     *
     * The coordinates of the point are specified as $ptX and $ptY.
     *
     * The line passes through points l1 and l2, specified respectively with
     * their coordinates $l1x and $l1y, and $l2x and $l2y
     *
     * @param float $ptX X coordinate of the point
     * @param float $ptY Y coordinate of the point
     * @param float $l1x X coordinate of point on the line l1
     * @param float $l1y Y coordinate of point on the line l1
     * @param float $l2x X coordinate of point on the line l2
     * @param float $l2y Y coordinate of point on the line l2
     *
     * @return float The distance from the point to the line.
     */
    protected static function perpendicularDistance2d($ptX, $ptY,
                                                      $l1x, $l1y, $l2x, $l2y)
    {
        $result = 0;
        if ($l2x == $l1x)
        {
            //vertical lines - treat this case specially to avoid dividing
            //by zero
            $result = abs($ptX - $l2x);
        }
        else
        {
            $slope = (($l2y-$l1y) / ($l2x-$l1x));
            $passThroughY = (0-$l1x)*$slope + $l1y;
            $result = (abs(($slope * $ptX) - $ptY + $passThroughY)) /
                      (sqrt($slope*$slope + 1));
        }
        return $result;
    }

    /**
     * RamerDouglasPeucker2d
     *
     * Reduces the number of points on a polyline by removing those that are
     * closer to the line than the distance $epsilon.
     *
     * @param array $pointList An array of arrays, where each internal array
     * is one point on the polyline, specified by two numeric coordinates.
     * @param float $epsilon The distance threshold to use. The unit should be
     * the same as that of the coordinates of the points in $pointList.
     *
     * @return array $pointList An array of arrays, with the same format as the
     * original argument $pointList. Each point returned in the result array will
     * retain all its original data.
     */
    public static function RamerDouglasPeucker2d($pointList, $epsilon)
    {
        if ($epsilon <= 0)
        {
            throw new InvalidParameterException('Non-positive epsilon.');
        }

        if (count($pointList) < 2)
        {
            return $pointList;
        }

        // Find the point with the maximum distance
        $dmax = 0;
        $index = 0;
        $totalPoints = count($pointList);
        for ($i = 1; $i < ($totalPoints - 1); $i++)
        {
            $d = self::perpendicularDistance2d(
                        $pointList[$i][0], $pointList[$i][1],
                        $pointList[0][0], $pointList[0][1],
                        $pointList[$totalPoints-1][0],
                        $pointList[$totalPoints-1][1]);

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
            // Recursive call on each 'half' of the polyline
            $recResults1 = self::RamerDouglasPeucker2d(
                       array_slice($pointList, 0, $index + 1),
                                $epsilon);
            $recResults2 = self::RamerDouglasPeucker2d(
                       array_slice($pointList, $index, $totalPoints - $index),
                                $epsilon);

            // Build the result list
            $resultList = array_merge(array_slice($recResults1, 0,
                                                  count($recResults1) - 1),
                                      array_slice($recResults2, 0,
                                                  count($recResults2)));
        }
        else
        {
            $resultList = array($pointList[0], $pointList[$totalPoints-1]);
        }
        // Return the result
        return $resultList;
    }
}
?>
