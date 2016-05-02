# RDP-PHP
PHP implementation of the [Ramer–Douglas–Peucker](http://en.wikipedia.org/wiki/Ramer%E2%80%93Douglas%E2%80%93Peucker_algorithm) algorithm for polyline simplification.

License: Public Domain

### Example usage ###

    include "src/rdp.php";

    use davidredgar\polyline\RDP;

    $line = array(
        array(150, 10),
        array(200, 100),
        array(360, 170),
        array(500, 280));

    //try calling RamerDouglasPeucker() with different values of $epsilon - eg. 10 or 50
    $rdpResult = RDP::RamerDouglasPeucker2d($line, 30);
    var_dump ($rdpResult);

### Use for geographic purposes ###

I originally implemented this in order to simplify a complex route on a map. Because I was doing this in Great Britain with OSGB36 coordinates, this worked.

However, be careful if you want to want to attempt this with other coordinate systems. The algorithm assumes cartesian coordinates on a 2D plane. Attempting to use latitudes and longitudes on the surface of a sphere will result in incorrect results. For approximate polyline simplification, the results *may* still be acceptable. As you approach the poles, errors will become more and more apparent: put simply, the degrees of longitude will become much closer to one another than the degrees of latitude, and so incorrect points will be chosen to be removed from the polyline.

