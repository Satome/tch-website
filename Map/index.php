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
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <script src="jquery-1.8.3.min.js"></script>
        <script src="jquery.elevatezoom.js"></script>
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
                    <article>
                        <img id="map" src="van_small.png" data-zoom-image="van_large.jpg" usemap="#basemap"/>
                        <map name="basemap">
                            <area shape="circle" coords="301,371,5" href="#" onclick="window.alert('KEK');" alt="Astranaar">
                        </map>
                        <script>$("#map").elevateZoom({ zoomType: "lens", lensShape: "round", lensSize: 220, lensFadeIn: 500, lensFadeOut: 500, containLensZoom: true, loadingIcon: true});</script>
                    </article>
                </section>
            </div>
        </div>
    </body>
</html>