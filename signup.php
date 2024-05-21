<?php
    session_start();

    $pagename="sign up";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");

        echo "<h4>".$pagename."</h4>";

        echo "<form action='signup_process.php' method='post'>";
            echo "<table id='baskettable'>";

                echo "<tr>";
                    echo "<td><label><b>First Name:</b></label></td>";
                    echo "<td><input name='forename' type='text' size='30'></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><label><b>Last Name:</b></label></td>";
                    echo "<td><input name='surname' type='text' size='30'></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><label><b>Address:</b></label></td>";
                    echo "<td><input name='address' type='text' size='30'></td>";
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><label><b>Post Code:</b></label></td>";
                    echo "<td><input name='postcode' type='text' size='30'></td>";
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><label><b>Telephone Number:</b></label></td>";
                    echo "<td><input name='telephone' type='text' size='30'></td>";
                echo "</tr>";                

                echo "<tr>";
                    echo "<td><label><b>Email:</b></label></td>";
                    echo "<td><input name='email' type='email' size='30'></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><label><b>Password:</b></label></td>";
                    echo "<td><input name='password' type='password' size='30'></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><label><b>Confirm Password:</b></label></td>";
                    echo "<td><input name='confirm_password' type='password' size='30'></td>";
                echo "</tr>";            

                echo "<tr>";
                    echo "<td><input type='submit' value='Sign Up' id='submitbtn'></td>";
                    echo "<td><input type='reset' value='Clear Form' id='submitbtn'></td>";
                echo "</tr>";
            echo "</table>";
        echo "</form>";
        
        include("footfile.html");
    echo "</body>";
?>