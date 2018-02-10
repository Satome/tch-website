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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>The Eternal Leaf</title>
        <link rel="stylesheet" href="/styles.css" type="text/css" />
        <link rel="stylesheet" href="admin.css" type="text/css" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <script src="/js/common.js"></script>
        <script src="/Admin/admin.js"></script>
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
                        <?php $user->userLinks(); ?>
                    </ul>
                </div>
            </nav>
            <div id="body" class="width">
                <section id="content" class="two-column with-right-sidebar">
                    <?php $admin->getAdminView(); ?>
                </section>
            </div>
        </div>
        <script>
            document.getElementById('statistics').style.display = "block";
            function openInfo(evt, infoName) {
                var i, x, tablinks;
                x = document.getElementsByClassName("page_content");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < x.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" tablink_active", "");
                }
                document.getElementById(infoName).style.display = "block";
                evt.currentTarget.className += " tablink_active";
            }
        </script>
    </body>
</html>

