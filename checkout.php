<?php
    session_start();

    include("db.php");
    mysqli_report(MYSQLI_REPORT_OFF);

    $pagename="checkout";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");
        include("detectlogin.php");

        echo "<h4>".$pagename."</h4>";

        $currentdatetime = date('Y-m-d H:i:s');

        $SQL = "
                INSERT INTO Orders (userId, orderDateTime, orderStatus)
                VALUES (".$_SESSION['userid'].", '".$currentdatetime."', 'Placed')
                ";
        $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

        if($exeSQL and isset($_SESSION['basket']) and count($_SESSION['basket']) > 0) {
            echo "<p class='updateInfo'><b>Order successfully placed!</b></p>";

            $SQL = "
                    SELECT MAX(orderNo) AS orderNo
                    FROM Orders
                    WHERE userId = ".$_SESSION['userid'];
            $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

            $arrayo = mysqli_fetch_array($exeSQL);

            $orderNumber = $arrayo['orderNo'];
            echo "<p class='updateInfo'>Order No: <b>".$orderNumber."</b></p>";

            $total = 0;

            echo "<table id='baskettable'>";
                echo "<th>Product Name</th>";
                echo "<th>Price</th>";
                echo "<th>Quantity</th>";
                echo "<th>Subtotal</th>";

                foreach($_SESSION['basket'] as $key => $value) {
                    $SQL = "
                            SELECT prodId, prodName, prodPrice
                            FROM Product
                            WHERE prodId = $key
                            ";
                    $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

                    $arrayb = mysqli_fetch_array($exeSQL);

                    $subtotal = $arrayb['prodPrice'] * $value;

                    $SQL = "
                            INSERT INTO Order_Line (orderNo, prodId, quantityOrdered, subTotal)
                            VALUES (".$orderNumber.", ".$arrayb['prodId'].", ".$value.", ".$subtotal.")
                            ";
                    $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

                    echo "<tr>";
                        echo "<td>".$arrayb['prodName']."</td>";
                        echo "<td>&pound".number_format($arrayb['prodPrice'], 2)."</td>";
                        echo "<td>".$value."</td>";
                        $subtotal = $arrayb['prodPrice'] * $value;
                        echo "<td>&pound".number_format($subtotal, 2)."</td>";
                        $total = $total + $subtotal;
                    echo "</tr>";
                }

                echo "<tr>";
                    $span = 3;
                    echo "<td colspan=".$span."><b>TOTAL</b></td>";
                    echo "<td><b>&pound".number_format($total, 2)."</b></td>";
                echo "</tr>";

                $SQL = "
                        UPDATE Orders
                        SET orderTotal = ".$total."
                        WHERE orderNo = ".$orderNumber;
                $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
                
            echo "</table>";
            

        } else {
            echo "<p>Error. Unable to place order.</p>";
        }

        unset($_SESSION['basket']);
        
        include("footfile.html");
    echo "</body>";
?>