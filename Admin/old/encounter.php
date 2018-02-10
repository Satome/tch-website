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
    <script src="/js/encounter.js"></script>
</head>
<body style="margin: auto; background-color: #2a2a2a;">
    <div style="position: relative; background-color: #b9b5b5;">
        <div style="height: 35px; background-color: #a09f9f;">
            <a href="admin.php" target="admin" class="admin">Back</a>
            <a href="#" target="admin" onclick='showPoi(document.getElementById("poi").value);return false;' class="admin">Roll</a>
        </div>
        <form>
        <select id="poi" name="poi" onchange="showPoi(this.value)">
        <?php
        $res = $mysqli->query("SELECT * FROM POI");
        while($row = $res->fetch_array())
        {
            $alias = $row['NAME'];
            $id = $row['ID'];
            echo "<option value=". $id . ">" . $alias . "</option><br />";
            }
        ?>
        </select>
        </form>
        <div id="result">
        </div>
    </div>
</body>
</html>