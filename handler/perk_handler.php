<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');
if(isset($_GET['PERKS']))
{
    $perks = stripslashes($_GET['PERKS']);
    $id = stripslashes($_GET['ID']);
    $character->setPerks($perks, $id);
    $character->listPerks($id);
}
if(isset($_GET['UPDATE']))
{
    $id = stripslashes($_GET['UPDATE']);
    $character->getCharacterPerks($id);
}
?>