<?php
//Include required libraries
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/common.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>The Cenarion Heroes RP-System Early ALPHA!</title>
    <link rel="stylesheet" type="text/css" href="../StyleSheet.css"/>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body style="min-height: 100%; margin: auto; background-color: #a09f9f;">
    <div style="margin: auto;">
        <?php
            $res = $mysqli->query("SELECT * FROM USER WHERE ACTIVE=0");
            while($row = $res->fetch_array())
            {
                $alias = $row['USERNAME'];
                $id = $row['ID'];
                echo('<a href="./?action=activateUser&user=' . $id . '">' . 'Account "' . $alias .  '" needs to be activated, click here to activate it.</a>');
            }
        ?>
    </div>
</body>
</html>