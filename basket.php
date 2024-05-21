<?php
    session_start();

    include("db.php");

    $pagename="smart basket";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");
        include("detectlogin.php");

        echo "<h4>".$pagename."</h4>";

        if (isset($_POST['selectedProdId'])) {
            $delprodid = $_POST['selectedProdId'];

            unset($_SESSION['basket'][$delprodid]);
            echo "<p class='updateInfo'><b>1 item removed from the basket</b></p>";
        } else if (isset($_POST['prodid'])) {
            $newprodid = $_POST['prodid'];
            $reququantity = $_POST['quantity'];
    
            $_SESSION['basket'][$newprodid] = $reququantity;
            echo "<p class='updateInfo'><b>1 item added</b></p>";
        }       
        
        $total = 0;

        echo "<table id='baskettable'>";
            echo "<tr>";
                echo "<th>Product Name</th>";
                echo "<th>Price</th>";
                echo "<th>Selected Quantity</th>";
                echo "<th>Subtotal</th>";
                echo "<th>Remove</th>";
            echo "</tr>";

            if (isset($_SESSION['basket'])) {
                foreach($_SESSION['basket'] as $key => $value) {
                    $SQL = "select prodName, prodPrice, prodQuantity
                            from Product
                            where prodId = $key";
                    $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
                    
                    $basketItem = mysqli_fetch_array($exeSQL);

                    echo "<tr>";
                        echo "<td>".$basketItem['prodName']."</td>";
                        echo "<td>&pound".number_format($basketItem['prodPrice'], 2)."</td>";
                        echo "<td>".$value."</td>";
                        $subtotal = $basketItem['prodPrice'] * $value;
                        echo "<td>&pound".number_format($subtotal, 2)."</td>";
                        $total = $total + $subtotal;
                        
                        echo "<form action='basket.php' method='post'>";
                            echo "<td><input type='submit' name='removebtn' value='Remove' id='submitbtn'></td>";
                            echo "<input type='hidden' name='selectedProdId' value=".$key.">";
                        echo "</form>";

                    echo "<tr>";
                }          
            } else {
                echo "<p class='updateInfo'><b>Empty Basket</b></p>";
            }

            echo "<tr>";
                $span = 4;
                echo "<td colspan=".$span."><b>TOTAL</b></td>";
                echo "<td><b>&pound".number_format($total, 2)."</b></td>";
            echo "</tr>"; 
            
        echo "</table>";

        if(isset($_SESSION['basket']) and count($_SESSION['basket']) > 0) {
            echo "<br><p class='updateInfo'><a href=clearbasket.php>CLEAR BASKET</a></p>";

            if(isset($_SESSION['userid'])) {
                echo "<p class='updateInfo'><a href=checkout.php>CHECKOUT</a></p>";
            } else {
                echo "<p class='updateInfo'>New homteq customers: <a href=signup.php>Sign Up</a></p>";
                echo "<p class='updateInfo'>Returning homteq cusotmers: <a href=login.php>Login</a></p>";
            }
        }

        include("footfile.html");
    echo "</body>";
?>