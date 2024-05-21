<?php
    session_start();

    include("db.php");

    $pagename="a smart buy for a smart home";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");
        include("detectlogin.php");

        echo "<h4>".$pagename."</h4>";

        $prodid=$_GET['u_prod_id'];

        $SQL = "
                select prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity 
                from Product
                where prodID = $prodid
                ";
        $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

        echo "<table style='border: 0px'>";
            while($products = mysqli_fetch_array($exeSQL)) {
                echo "<tr>";
                    echo "<td style='border: 0px'>";
                        echo "<a href=prodbuy.php?u_prod_id=".$products['prodId'].">";
                            echo "<img src=images/".$products['prodPicNameLarge']." width=400>";
                        echo "</a>";
                    echo "</td>";

                    echo "<td style='border: 0px'>";
                        echo "<a href=prodbuy.php?u_prod_id=".$products['prodId'].">";        
                            echo "<p><h5>".$products['prodName']."</h5></p>";
                        echo "</a>";        

                        echo "<p class='updateInfo'>".$products['prodDescripLong']."</p>";

                        echo "<p class='updateInfo'><b>&pound".number_format($products['prodPrice'], 2)."</b></p>";

                        echo "<p class='updateInfo'>Number left in stock: ".$products['prodQuantity']."</p>";
                        
                        echo "<p class='updateInfo'>Number to be purchased: </p>";
                        
                        echo "<form action='basket.php' method='post'>";
                            echo "<p class='updateInfo'>";
                                echo "<select name='quantity'>";
                                    for ($item=1; $item <= $products['prodQuantity']; $item++) {            
                                        echo "<option value=".$item.">".$item."</option>";
                                    };
                                echo "</select>";

                                echo "<input type='submit' name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
                                echo "<input type='hidden' name='prodid' value=".$prodid.">";
                            echo "</p>";
                        echo "</form>";
                    echo "</td>";
                echo "</tr>";
            }
        echo "</table>";

        include("footfile.html");
    echo "</body>";    
?>