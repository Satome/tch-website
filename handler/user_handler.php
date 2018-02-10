<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');

if(!isset($admin)) {
    $admin = new Admin();
}
if(isset($_GET['Activate'])) {
    $id = stripslashes($_GET['Activate']);
    $admin->activateUser($id);
    $admin->getUserList();
}
if(isset($_GET['Remove'])) {
    $id = stripslashes($_GET['Remove']);
    $admin->removeUser($id);
    $admin->getUserList();
}
?>