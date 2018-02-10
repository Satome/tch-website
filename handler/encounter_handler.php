<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');
$id = stripslashes($_GET['ID']);
if(!isset($attack))
{
    $attack = new Attack();
}
if ($id == "1")
{
    $attack->rollPoI();
}
else
{
    $attack->rollSelected($id);
}
?>