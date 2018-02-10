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
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" href="/styles.css" type="text/css" />
</head>
<body style="min-height: 100%; margin: auto; background-color: #2a2a2a;">
    <div style="height: 35px; background-color: #a09f9f;">
        <a href="admin.php" target="admin" class="admin">Back</a>
    </div>
        <div style="position: relative; height: 665px; background-color: #b9b5b5;">
            <form action="./?action=postNews" target="_parent" method="post">
                Write a news article for front page: 
                <textarea name="post"  cols="80" rows="20"></textarea>
                <br />
                <input type="hidden" name="id" value="<?php echo $_SESSION['ID'] ?>">
                <input id="Submit" type="submit" value="Save" />
                </form>
        </div>
</body>
</html>