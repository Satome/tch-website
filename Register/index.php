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
                    <article>
                        <?php
                            if(isset($_GET['regSuccessfull'])) {
                                if($_GET['regSuccessfull'] == 'false') {
                                    echo '<script>window.alert("The username is already taken.")</script>';
                                } else {
                                    echo '<script>window.alert("Thank you for registering, your account should be activated soon.")</script>';
                                }
                            }
                        ?>
                        <form action="./?action=register" method="post" style="width: 505px; padding: 10px; color: black">
                            <table>
                                <tr>
                                    <td><label> Alias (ec. name that is shown to other users/ admins)</label></td>
                                    <td><input title="Enter alias that is shown for other users (like character name)" type="text" required pattern="\w+" name="alias"></td>
                                </tr>
                                <tr>
                                    <td><label> Username </label></td>
                                    <td><input title="Enter your username" type="text" required pattern="\w+" name="username"></td>
                                </tr>
                                <tr>
                                    <td><label> Password </label></td>
                                    <td><input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" type="password" name="password1" onchange="
                                    this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                    if(this.checkValidity()) form.password2.pattern = this.value;"></td>
                                </tr>
                                <tr>
                                    <td><label>Confirm Password: </label></td>
                                    <td><input title="Please enter the same Password as above" type="password" name="password2" onchange="
                                    this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"></td>
                                </tr>
                                <tr>
                                    <td><input id="Submit-register" type="submit" value="Submit" /></td>
                                </tr>
                            </table>
                        </form>
                    </article>
                </section>
            </div>
        </div>
    </body>
</html>