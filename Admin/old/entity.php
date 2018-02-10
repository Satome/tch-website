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
        <div style="position: relative; height: 755px; background-color: #b9b5b5;">
            <form action="./?action=addEntity" method="post" target="admin" style="width: 505px; border:solid; padding: 10px; ">
                <H3>READ ME FIRST!</H3>
                <br />
                <b>How to use:
                <br />
                1. Select Classification
                <br />
                2. Select Type (like Ogre, Naga) by clicking the white area, if the entity type is not found, just type it
                <br />
                3. Select Class (Class; Spec) by clicking the white area, if entity class is not found, just type it
                <br />
                4. Select the location/ zone for the entity
                </b>
                <br />
                <b>Classification: </b> 
                <input type="radio" name="classification" value="1" checked>Beast 
                <input type="radio" name="classification" value="2">Demon 
                <input type="radio" name="classification" value="3">Elemental 
                <input type="radio" name="classification" value="4">Humanoid 
                <input type="radio" name="classification" value="5">Undead
                <br />
                <b>Type (select from list, or add new): </b>
                <input type ="text" name="type" list="type" autocomplete="off">
                <datalist id="type">
                <?php
                $res = $mysqli->query("SELECT * FROM ENTITY_TYPE");
                 while($row = $res->fetch_array())
                 {
                    $alias = $row['NAME'];
                    $id = $row['ID'];
                    echo "<option value=". $id . ">" . $alias . "</option>";
                 }
                 mysqli_free_result($res);
                 ?>
                </datalist>
                <br />
                <b>Class (select from list, or add new): </b>
                <input type ="text" name="class" list="class" autocomplete="off">
                <datalist id="class">
                <?php
                $res = $mysqli->query("SELECT * FROM ENTITY_CLASS");
                 while($row = $res->fetch_array())
                 {
                    $alias = $row['NAME'];
                    $id = $row['ID'];
                    echo "<option value=". $id . ">" . $alias . "</option>";
                 }
                 mysqli_free_result($res);
                 ?>
                </datalist>
                <br />
                <br>
                <b>Entity location: </b>
                <select id="zone" name="zone">
                <?php
                $res = $mysqli->query("SELECT * FROM ZONE");
                 while($row = $res->fetch_array())
                 {
                    $alias = $row['NAME'];
                    $id = $row['ID'];
                    echo "<option value=". $id . ">" . $alias . "</option>";
                    }
                 mysqli_free_result($res);
                 ?>
                </select>
                <br />
                <br />
                <input type="hidden" id="table" name="table" value="ENTITY">
                <input id="Submit" type="submit" value="Submit" />
                </form>
                <br>
                <h2>Already added: (ID, Type, Class; Spec, Classification, Location)</h2>
                <div style="border:1px solid #ccc; font:16px/26px Georgia, Garamond, Serif; overflow:auto; position: relative; width: 600px; max-height: 280px; background-color: #FFFFFF;">
                    <table style="width:100%; padding: 5px; border-collapse: collapse; text-align: left;">
                        <tr>
                            <th>ID</th>
                            <th>Type</th>		
                            <th>Class; Spec</th>
                            <th>Classification</th>
                            <th>Location</th>
                        </tr>
                    <?php
                        $res = $mysqli->query("SELECT * FROM ENTITY ORDER BY ID DESC");
                        while($row = $res->fetch_array())
                        {
                            $type = $row['TYPE'];
                            $class = $row['CLASS'];
                            $id = $row['ID'];
                            $zone = $row['ZONE'];
                            $classification = $row['CLASSIFICATION'];
                            
                            $result = $mysqli->query("SELECT NAME FROM ENTITY_TYPE WHERE ID='$type'");
                            $resultRow = mysqli_fetch_object($result);
                            $type = $resultRow->NAME;
                            mysqli_free_result($result);
                            $result = $mysqli->query("SELECT NAME FROM ZONE WHERE ID='$zone'");
                            $resultRow = mysqli_fetch_object($result);
                            $zone = $resultRow->NAME;
                            mysqli_free_result($result);
                            $result = $mysqli->query("SELECT NAME FROM ENTITY_CLASS WHERE ID='$class'");
                            $resultRow = mysqli_fetch_object($result);
                            $class = $resultRow->NAME;
                            mysqli_free_result($result);
                            $result = $mysqli->query("SELECT NAME FROM ENTITY_CLASSIFICATION WHERE ID='$classification'");
                            $resultRow= mysqli_fetch_object($result);
                            $classification = $resultRow->NAME;
                            mysqli_free_result($result);
                            if($type == "Clavis")
                            {
                                $type = "Secret";
                                $class = "Secret";
                                $classification = "Secret";
                                $zone = "Secret";
                            }
                            echo ('
                                <tr>
                                    <td>' . $id . '</td>
                                    <td>' . $type . '</td>
                                    <td>' . $class . '</td>
                                    <td>' . $classification . '</td>
                                    <td>' . $zone . '</td>
                                </tr>');
                        }
                        mysqli_free_result($res);
                    ?>
                    </table>
                </div>
        </div>
</body>
</html>