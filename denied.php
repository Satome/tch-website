<?php
//Include required libraries
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/common.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>The Eternal Leaf RP-System Early ALPHA!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" href="/styles.css" type="text/css" />
</head>
<body style="min-height: 100%; margin: auto;">
    <div style="position: relative; height: 665px;">
        <p style="color: black"><b>You do not have the permission to access this page, or session timed out. You will be redirected to front page in 3 seconds.</b></p>
        <script>
            setTimeout(redirect, 3000)
            function redirect()
            {
                window.top.location.href = "/";
            }
        </script>
    </div>
</body>
</html>