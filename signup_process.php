<?php
    session_start();
    include("db.php");

    $pagename="sign up results";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");

        echo "<h4>".$pagename."</h4>";

        if(empty($_POST['forename']) or
            empty($_POST['surname']) or
            empty($_POST['address']) or
            empty($_POST['postcode']) or
            empty($_POST['telephone']) or
            empty($_POST['email']) or
            empty($_POST['password']) or
            empty($_POST['confirm_password'])) 
        {
            echo "Fill All Fields.<br>Try again <a href='signup.php'>here</a>.";
        } else {
            $forename = $_POST['forename'];
            $surname = $_POST['surname'];
            $address = $_POST['address'];
            $postcode = $_POST['postcode'];
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            $SQL = "
                    SELECT userEmail
                    FROM Users
                    WHERE userEmail = '".$email."'
                    ";
            $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
            $nbrecs = mysqli_num_rows($exeSQL);            

            if($password != $confirm_password) {
                echo "<p>Passwords do not match.<br>Try again <a href='signup.php'>here</a></p>";
            } else if($nbrecs > 0) {
                echo "<p>Email already in use.<br>Try again <a href='signup.php'>here</a></p>";
            } else {
                $SQL = "
                    INSERT INTO Users (userType, userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword)
                    VALUES ('Customer', '".$forename."', '".$surname."', '".$address."', '".$postcode."', '".$telephone."', '".$email."', '".$confirm_password."')
                ";
                $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

                if($exeSQL) {
                    $SQL = "
                        SELECT userId, userType, userFName, userSName, userEmail, userPassword
                        FROM Users
                        WHERE userEmail = '".$email."'
                    ";            
    
                    $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
                    $arrayu = mysqli_fetch_array($exeSQL);

                    $_SESSION['userid'] = $arrayu['userId'];
                    $_SESSION['usertype'] = $arrayu['userType'];
                    $_SESSION['fname'] = $arrayu['userFName'];
                    $_SESSION['sname'] = $arrayu['userSName'];

                    echo "<p>Hello ".$_SESSION['fname']." ".$_SESSION['sname']."!</p>";
                    echo "<p>Account Type: ".$_SESSION['usertype']."</p><br>";

                    echo "<p>Continue shopping for <a href='index.php'>Home Tech</a></p>";
                    echo "<p>View your <a href='basket.php'>Smart Basket</a></p>";
                } else {
                    echo "<p>Error signing up.<br>Try again <a href='signup.php'>here</a></p>";
                }
            }
        }
        
        include("footfile.html");
    echo "</body>";
?>