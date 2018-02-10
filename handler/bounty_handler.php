<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');
$status = stripslashes($_GET['status']);
$id = stripslashes($_GET['id']);
if(!isset($merc))
{
    $merc = new Merc();
}
$merc->setBountyStatus($status, $id);
$merc->getBountyList();
?>