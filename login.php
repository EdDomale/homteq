<?php
    session_start();

    $pagename="login";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");

        echo "<h4>".$pagename."</h4>";

        echo "<form action='login_process.php' method='post'>";
            echo "<table id='baskettable'>";
                echo "<tr>";
                    echo "<td><label><b>Email:</b></label></td>";
                    echo "<td><input name='email' type='text' size='30'></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><label><b>Password:</b></label></td>";
                    echo "<td><input name='password' type='password' size='30'></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><input type='submit' value='Login' id='submitbtn'></td>";
                    echo "<td><input type='reset' value='Clear Form' id='submitbtn'></td>";
                echo "</tr>";
            echo "</table>";
        echo "</form>";
        
        include("footfile.html");
    echo "</body>";
?>