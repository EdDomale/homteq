<?php
    session_start();
    include("detectlogin.php");

    $pagename="template";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");

        echo "<h4>".$pagename."</h4>";

        echo "<p>Thank you, ".$_SESSION['fname']." ".$_SESSION['sname']."</p>";
        session_unset();
        session_destroy();
        echo "<p>You are now logged out.</p>";
        
        include("footfile.html");
    echo "</body>";
?>