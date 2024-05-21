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

        if(isset($_POST['selectedProdId'])) {
            $pridtobeupdated = $_POST['selectedProdId'];
            $newprice = $_POST['newPrice'];
            $newqutoadd = $_POST['quantityToAdd'];

            echo "<p><b>Product No.".$pridtobeupdated." has been updated</b></p>";

            $SQL = "
                    SELECT prodQuantity
                    FROM Product
                    WHERE prodId = $pridtobeupdated
                    ";
            $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

            $arrayqu = mysqli_fetch_array($exeSQL);

            $newstock = $arrayqu['prodQuantity'] + $newqutoadd;

            if(!empty($newprice)) {
                $SQL = "
                        UPDATE Product
                        SET prodPrice = ".$newprice.", prodQuantity = ".$newstock."
                        WHERE prodId = ".$pridtobeupdated;
                $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
            } else {
                $SQL = "
                        UPDATE Product
                        SET prodQuantity = ".$newstock."
                        WHERE prodId = ".$pridtobeupdated;
                $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
            }
        }

        $SQL = "select prodId, prodName, prodPicNameSmall, prodDescripShort, prodPrice, prodQuantity
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

                        echo "<form action='editproduct.php' method='post'>";                        
                            echo "<p class='updateInfo'>";
                                echo "Current Price: <b>&pound".$products['prodPrice']."</b>";
                                echo "<label> | | Enter New Price: </label><input name='newPrice' type='text' size='8'>";
                            echo "</p>";

                            echo "<p class='updateInfo'>Current Stock Level: <b>".$products['prodQuantity']."</b>";
                            echo " | | Add number of items: ";
                            echo "<select name='quantityToAdd'>";
                                for ($item=0; $item <= 100; $item++) {            
                                    echo "<option value=".$item.">".$item."</option>";
                                };
                            echo "</select></p>";

                            echo "<input type='hidden' name='selectedProdId' value=".$products['prodId'].">";

                            echo "<p class='updateInfo'><input type='submit' value='Update' id='submitbtn'></p>";
                        echo "</form>";

                    echo "</td>";
                echo "</tr>";
            }
        echo "</table>";

        include ("footfile.html");
    echo "</body>";
?>