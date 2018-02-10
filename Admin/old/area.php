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
    <title>The Cenarion Heroes RP-System Eadly ALPHA!</title>
    <link rel="stylesheet" type="text/css" href="../StyleSheet.css"/>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body style="min-height: 100%; margin: auto; background-color: #2a2a2a;">
    <div style="margin: auto; width: 1000px;">
        <div style="height: 56px; background-color: #a09f9f;">
          <a href="../">Main</a>
<?php
    if(!isset($user))
    {
        $user = new User();
    }
    $user->userLinks();
	$user->userPanel();
?>
        </div>
        <div style="position: relative; height: 600px; background-color: #b9b5b5; padding-top: 100px; padding-left: 240px">
            <form action="./?action=addArea" method="post" style="width: 505px; border:solid; padding: 10px; ">
                Area name:
                <input id="name" name="name" type="text" />
                <br />
                <br />
                Area description:
                <textarea id="description" name="description"  cols="60" name="S1" rows="10"></textarea>
                <br />
                <input type="hidden" id="table" name="table" value="AREA">
                <input id="Submit" type="submit" value="Submit" />
                </form>
                <h2>Already added:</h2>
                <div style="border:1px solid #ccc; font:16px/26px Georgia, Garamond, Serif; overflow:auto; position: relative; width: 200px; max-height: 200px; background-color: #FFFFFF;">
                    <?php
                        $res = $mysqli->query("SELECT * FROM AREA");
                        while($row = $res->fetch_array())
                        {
                            $alias = $row['NAME'];
                            $id = $row['ID'];
                            echo $alias . ",  " . $id;
                            echo "<br>";
                        }
                    ?>
                </div>
        </div>
    </div>
</body>
</html>