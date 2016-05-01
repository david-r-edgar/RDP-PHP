<?php

    include "../src/rdp.php";

    $line = array(
        array(150, 10),
        array(200, 100),
        array(360, 170),
        array(500, 280));

    //try calling RamerDouglasPeucker() with different values of $epsilon - eg. 10 or 50
    $rdpResult = RDP::RamerDouglasPeucker2d($line, 30);
    var_dump ($rdpResult);

?>
