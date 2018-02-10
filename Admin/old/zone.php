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
        <div style="position: relative; height: 600px; background-color: #b9b5b5;">
            <form action="./?action=addZone" target="_parent" method="post" style="width: 505px; border:solid; padding: 10px; ">
                Zone name:
                <input id="name" name="name" type="text" />
                <br />
                <br />
                Zone description:
                <textarea id="description" name="description"  cols="60" name="S1" rows="10"></textarea>
                <br />
                <input type="hidden" id="table" name="table" value="ZONE">
                <input id="Submit" type="submit" value="Submit" />
                </form>
                <h2>Already added:</h2>
                <div style="border:1px solid #ccc; font:16px/26px Georgia, Garamond, Serif; overflow:auto; position: relative; width: 200px; max-height: 200px; background-color: #FFFFFF;">
                    <?php
                        $res = $mysqli->query("SELECT * FROM ZONE");
                        while($row = $res->fetch_array())
                        {
                            $alias = $row['NAME'];
                            $id = $row['ID'];
                            echo $alias;
                            echo "<br>";
                        }
                        mysqli_free_result($res);
                    ?>
                </div>
        </div>
</body>
</html>