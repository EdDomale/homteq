<?php
    session_start();
    include("db.php");

    $pagename="login results";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");

        echo "<h4>".$pagename."</h4>";

        if(empty($_POST['email']) or empty($_POST['password'])) {
            echo "Fill All Fields.<br>Try again <a href='login.php'>here</a>.";
        } else {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $SQL = "
                    SELECT userId, userType, userFName, userSName, userEmail, userPassword
                    FROM Users
                    WHERE userEmail = '".$email."'
                    ";            
    
            $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
            $nbrecs = mysqli_num_rows($exeSQL);

            $arrayu = mysqli_fetch_array($exeSQL);

            if($nbrecs == 0) {
                echo "<p>Email not recognised.<br>Try again <a href='login.php'>here</a></p>";
            } else {
                if($arrayu['userPassword'] != $password) {
                    echo "<p>Incorrect Password Entered.<br>Try again <a href='login.php'>here</a></p>";
                } else {
                    $_SESSION['userid'] = $arrayu['userId'];
                    $_SESSION['usertype'] = $arrayu['userType'];
                    $_SESSION['fname'] = $arrayu['userFName'];
                    $_SESSION['sname'] = $arrayu['userSName'];

                    echo "<p>Hello ".$_SESSION['fname']." ".$_SESSION['sname']."!</p>";
                    echo "<p>Account Type: ".$_SESSION['usertype']."</p><br>";

                    echo "<p>Continue shopping for <a href='index.php'>Home Tech</a></p>";
                    echo "<p>View your <a href='basket.php'>Smart Basket</a></p>";
                }
            }
        }
        
        include("footfile.html");
    echo "</body>";
?>