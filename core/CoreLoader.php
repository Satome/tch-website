<?php
namespace lib;

if(!isset($news)) {
    $news = new News();
}

if(!isset($user)) {
    $user = new User();
}

if(!isset($character)) {
    $character = new Character();
}

if(!isset($merc)) {
    $merc = new Merc();
}

if(!isset($dm)) {
    $dm = new DM();
}

if(!isset($admin)) 
{
    $admin = new Admin();
}

    $errorMessageStore = array(
        'loginErrorMSG' => 'Invalid username or password, or the account has not been activated yet.',
        'dbErrorMSG' => 'Error accessing database.',
        'fileErrorMSG' => 'Error accessing file.',
        );

?>