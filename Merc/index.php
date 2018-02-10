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
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>The Eternal Leaf</title>
        <link rel="stylesheet" href="/styles.css" type="text/css" />
        <link rel="stylesheet" href="merc.css" type="text/css" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/js/encounter.js"></script>
        <script src="/js/common.js"></script>
    </head>
    <body>
        <div id="container" >
            <header>
                <div class="width" >
                    <div style="margin: auto; width: 70%;">
                        <img src="/images/icons/emblem_110.png" style="float: left"/><h1><a href="/">The Eternal Leaf</a></h1>
                    </div>
                </div>
            </header>
            <nav>
                <div class="width">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <?php if(!isset($user)){$user = new User();}$user->userLinks(); ?>
                    </ul>
                </div>
            </nav>
            <div id="body" class="width">
                <section id="content" class="two-column with-right-sidebar">
                    <article id="merc">
                        <div class="bountyInfo">
                            <p class="bountyInfo" style="width: 45%;">Bounty</p>
                            <p class="bountyInfo" style="width: 25%;">Issued by</p>
                            <p class="bountyInfo" style="width: 15%;">Date</p>
                            <p class="bountyInfo" style="width: 10%;">Status</p>
                        </div>
                        <div id="bountyList">
                            <?php
                            $merc->getBountyList(10, false);
                            ?>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    </body>
</html>