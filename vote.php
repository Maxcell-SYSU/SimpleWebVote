<?php
    header("Content-type:text/html;charset=utf-8");
    $success = true;

    if (isset($_COOKIE['vote'])) {
        if($_COOKIE['vote']=="yes") {
            $success=false;
        }
    }
    else {
        $success=false;
    }

    $con = mysql_connect("localhost", "root", "root");
    if (!$con) {
        die('Could not connect:'.mysql_error());
    }

    mysql_select_db("db", $con);

    $currentIP=$_SERVER['REMOTE_ADDR'];
    $result=mysql_query("SELECT * FROM ip",$con);

    while ($row = mysql_fetch_array($result)) {
        if ($row['IP']==$currentIP) {
            $success=false;
        }
    }

    if ($success) {
        setcookie("vote", "yes", time()+86400);
        mysql_query("INSERT INTO ip (IP) VALUES ('$currentIP')", $con);
        $worksname = $_POST['worksname'];
        mysql_query("UPDATE info SET num=num+1 WHERE worksname=$worksname",$con);
    }
    else {
        echo "请不要重复投票！";
    }
?>
