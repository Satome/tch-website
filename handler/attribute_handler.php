<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');
if(isset($_GET['ATTRIBUTE']))
{
    $attribute = stripslashes($_GET['ATTRIBUTE']);
    $id = stripslashes($_GET['ID']);
    if(!isset($character))
    {
        $character = new Character();
    }
    $character->setAttribute($attribute, $id);
    $character->listAttributes($id);
}
if(isset($_GET['UPDATE']))
{
    $id = stripslashes($_GET['UPDATE']);
    if(!isset($character))
    {
        $character = new Character();
    }
    $character->getCharacterAttribute($id);
}
?>