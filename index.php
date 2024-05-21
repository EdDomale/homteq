<?php
    session_start();

    include ("db.php");

    $pagename="make your home smart";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");
        include("detectlogin.php");

        echo "<h4>".$pagename."</h4>";

        $SQL = "select prodId, prodName, prodPicNameSmall, prodDescripShort, prodPrice 
                from Product";
        $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

        echo "<table style='border: 0px'>";
            while($products = mysqli_fetch_array($exeSQL)) {
                echo "<tr>";
                    echo "<td style='border: 0px'>";
                        echo "<a href=prodbuy.php?u_prod_id=".$products['prodId'].">";
                            echo "<img src=images/".$products['prodPicNameSmall']." height=200 width=200>";
                        echo "</a>";
                    echo "</td>";

                    echo "<td style='border: 0px'>";
                        echo "<a href=prodbuy.php?u_prod_id=".$products['prodId'].">";        
                            echo "<p class='updateInfo'><h5>".$products['prodName']."</h5></p>";
                        echo "</a>";        

                        echo "<p class='updateInfo'>".$products['prodDescripShort']."</p>";

                        echo "<p class='updateInfo'><b>&pound".$products['prodPrice']."</b></p>";
                    echo "</td>";
                echo "</tr>";
            }
        echo "</table>";

        include ("footfile.html");
    echo "</body>";
?>