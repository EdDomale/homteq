<?php
    session_start();

    include ("db.php");

    $pagename="admin: process orders";
    echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

    echo "<title>".$pagename."</title>";

    echo "<body>";
        include ("headfile.html");
        include("detectlogin.php");

        echo "<h4>".$pagename."</h4>";

        if(isset($_POST['orderNbToDelete'])) {
            $del_orderid = $_POST['orderNbToDelete'];

            $SQL = "
                    DELETE FROM Orders
                    WHERE orderNo = $del_orderid";
            $execSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
        }
        
        if(isset($_POST['orderNb'])) {
            $updt_orderid = $_POST['orderNb'];

            $SQL = "
                    UPDATE Orders
                    SET orderStatus = '".$_POST['status']."'
                    WHERE orderNo = ".$updt_orderid;
            $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
        }

        $SQL = "
                SELECT O.orderNo AS orderNo, O.orderDateTime AS orderDateTime, O.orderStatus AS orderStatus, U.userId AS userId, U.userFName AS userFName, U.userSName AS userSName, U.userAddress AS userAddress, U.userPostCode AS userPostCode, P.prodName AS prodName, OL.quantityOrdered AS quantityOrdered
                FROM Order_Line OL
                JOIN Product P ON OL.prodId = P.prodId
                JOIN Orders O ON OL.orderNo = O.orderNo
                JOIN Users U ON U.userId = O.userId
                ";
        $executeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));

        echo "<p class='updateInfo'><table>";
            $lastOrderNo = 0;

            while($orders = mysqli_fetch_array($executeSQL)) {
                if($orders['orderNo'] != $lastOrderNo) {

                    echo "<tr>";
                        echo "<td colspan=8></td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<th>Order</th>";
                        echo "<th>Order Date Time</th>";
                        echo "<th>User Id</th>";
                        echo "<th>Customer Name</th>";
                        echo "<th>Customer Address</th>";
                        echo "<th>Estimated Shipping Date</th>";
                        echo "<th colspan=2>Process Order</th>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td>";
                            echo "<p><b>No: ".$orders['orderNo']."</b></p>";
                        echo "</td>";

                        echo "<td>";
                            echo "<p>".$orders['orderDateTime']."</p>";
                        echo "</td>";
                        
                        echo "<td>";
                            echo "<p>".$orders['userId']."</p>";
                        echo "</td>";

                        echo "<td>";
                            echo "<p>".$orders['userFName']." ".$orders['userSName']."</p>";
                        echo "</td>";
                        
                        echo "<td>";
                            echo "<p>".$orders['userAddress'].", ".$orders['userPostCode']."</p>";
                        echo "</td>";
                        
                        echo "<td>";
                            $shippingDate = date('Y-m-d', strtotime($orders['orderDateTime'] . "+2 days"));

                            echo "<p>".$shippingDate."</p>";
                        echo "</td>";

                        echo "<td>";
                            echo "<form action='processorders.php' method='post'>";
                                if($orders['orderStatus'] == "Placed") {
                                    echo "<p>";
                                        echo "<select name='status'>";           
                                            echo "<option value='Placed'>Placed</option>";
                                            echo "<option value='Ready'>Ready to ship</option>";
                                        echo "</select>";

                                        echo "<input type='submit' value='Update' id='submitbtn'>";
                                    echo "</p>";
                                    
                                    echo "<input type='hidden' name='orderNb' value=".$orders['orderNo'].">";
                                } else if($orders['orderStatus'] == "Ready") {
                                    echo "<p>";
                                        echo "<select name='status'>";           
                                            echo "<option value='Ready'>Ready to ship</option>";
                                            echo "<option value='Shipped'>Shipped</option>";
                                        echo "</select>";

                                        echo "<input type='submit' value='Update' id='submitbtn'>";
                                    echo "</p>";

                                    echo "<input type='hidden' name='orderNb' value=".$orders['orderNo'].">";
                                } else if($orders['orderStatus'] == "Shipped") {
                                    echo "<p><b>Order ".$orders['orderStatus']."</b></p>";

                                    $SQL = "
                                            UPDATE Orders
                                            SET shippingDate = '".$shippingDate."'
                                            WHERE orderNo = ".$orders['orderNo'];
                                    $exeSQL = mysqli_query($dbConnection, $SQL) or die(mysqli_error($dbConnection));
                                }
                            echo "</form>";                                
                        echo "</td>";

                        echo "<td>";
                            echo "<form action='processorders.php' method='post'>";
                                echo "<input type='submit' value='Delete' id='submitbtn'>";

                                echo "<input type='hidden' name='orderNbToDelete' value=".$orders['orderNo'].">";
                            echo "</form>";
                        echo "</td>";
                    echo "</tr>";
                }

                echo "<tr>";
                    echo "<td colspan=5>";
                        echo "<p>".$orders['prodName']."</p>";
                    echo "</td>";
                    
                    echo "<td>";
                        echo "<p>".$orders['quantityOrdered']." items</p>";
                    echo "</td>";                    
                echo "</tr>";

                $lastOrderNo = $orders['orderNo'];
            }
        echo "</table></p>";

        include ("footfile.html");
    echo "</body>";
?>