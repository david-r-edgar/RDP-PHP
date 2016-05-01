# RDP-PHP
PHP implementation of the [Ramer–Douglas–Peucker](http://en.wikipedia.org/wiki/Ramer%E2%80%93Douglas%E2%80%93Peucker_algorithm) algorithm.

License: Public Domain

### Example usage ###

    include "rdp.php";

    $line = array(
        0 => array("E"=> 150,"N" => 10),
        1 => array("E" => 200,"N" => 100),
        2 => array("E" => 360,"N" => 170),
        3 => array("E" => 500,"N" => 280));

    //try calling RamerDouglasPeucker() with different values of $epsilon - eg. 10 or 50
    $rdpResult = RamerDouglasPeucker($line, 30);
    var_dump ($rdpResult);
