<?php
if(isset($_SESSION['userid'])) {
    echo "<p style='float: right'><b><i>".$_SESSION['fname']." ".$_SESSION['sname']." | ".$_SESSION['usertype']."</i></b></p>";
}
?>