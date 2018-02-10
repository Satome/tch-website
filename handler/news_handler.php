<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/session_handler.php');
require($_SERVER['DOCUMENT_ROOT'] . '/lib/permissions.php');

if(!isset($news)) {
    $news = new News();
}
if(isset($_GET['ID'])) {
    $id = stripslashes($_GET['ID']);
    $news->showFull($_GET['ID']);
}

if(isset($_GET['Remove'])) {
    $removeID = stripslashes($_GET['Remove']);
    $news->removeArticle($removeID);
    $news->getNewsList();
}
?>