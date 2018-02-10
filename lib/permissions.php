<?php
namespace lib;

require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
require_once("session_handler.php");
if(!isset($user))
{
	$user = new User();
}
$currentFile = $_SERVER['SCRIPT_NAME'];
// Admin permissions/ Default user permissions
switch($currentFile)
{
    case "/User/index.php":
        if(!isset($_SESSION['ID']))
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/index.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/admin.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/zone.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/settlement.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/poi.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/entity.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/encounter.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Admin/post.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1300')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/handler/item_handler.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1200')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/handler/encounter_handler.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1200')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/handler/character_handler.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1200')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/Merc/index.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1000')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/DM/index.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1200')
        {
            header("Location: /denied.php");
        }
	    break;
	case "/images/icons/characters/upload.php":
        if(!isset($_SESSION['ID']) || $user->getGroup($_SESSION['ID']) < '1000')
        {
            header("Location: /denied.php");
        }
	    break;
    default:
        break;
}
// Character permissions
?>