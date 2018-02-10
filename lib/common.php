<?php
namespace lib;

require($_SERVER['DOCUMENT_ROOT'] . '/lib/Bootstrap.php');
include($_SERVER['DOCUMENT_ROOT'] . '/core/CoreLoader.php');
include($_SERVER['DOCUMENT_ROOT'] . '/lib/upload_lib.php');

if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "login":
			if(!isset($login))
			{
				$login = new Login($_POST['username'], $_POST['password']);
                if($login->success) {
                    header("Location: /");
                } else {
                    header("Location: /Login/?error=true");
                }
			}
			break;
        case "register":
            if(!isset($register) && $_POST['username'] != null)
			{
			    $register = new Register($_POST['username'], $_POST['password1'], $_POST['alias']);
                if($register->success) {
                    header("Location: /Register?regSuccessfull=true");
                } else {
                    header("Location: /Register/?regSuccessfull=false");
                }
			}
            break;
		case "activateUser":
            //echo '<script>window.alert("Account activated.")</script>';
			if(!isset($activate))
			{
				$activate = new Activate($_GET['user']);
			}
			break;
        case "addZone":
			if(!isset($addDB))
			{
				$addDB = new AddLocation($_POST['name'], $_POST['description'], NULL, $_POST['table']);
			}
            break;
        case "addSettlement":
			if(!isset($addDB))
			{
				$addDB = new AddLocation($_POST['name'], $_POST['description'], $_POST['zone'], $_POST['table']);
			}
            break;
        case "addPoI":
			if(!isset($addDB))
			{
				$addDB = new AddLocation($_POST['name'], $_POST['description'], $_POST['zone'], $_POST['table']);
			}
            break;
        case "addEntity":
			if(!isset($addDB))
			{
                $addDB = new AddEntity($_POST['classification'], $_POST['type'], $_POST['class'], $_POST['zone']);
            }
			break;
        case "addCharacter":
            if(!isset($addCharacter))
            {
                $name = null;
                $description = null;
                $characterClass = null;
                $avatarFile = null;
                $avatarFileName = null;
                if(isset($_POST['characterName'])){$name = $_POST['characterName'];}
                if(isset($_POST['characterBio'])){$description = $_POST['characterBio'];}
                if(isset($_POST['characterClass'])){$characterClass = $_POST['characterClass'];}
                if(isset($_FILES["fileToUpload"])){$avatarFile = $_FILES["fileToUpload"];}
                if ($avatarFile['name'] != "")
                {
                    $avatarFileName = uploadAvatar($avatarFile, false);
                }
                $character->addCharacter($name, $characterClass, $description, $avatarFileName);
                $uri = '/User/?ID=' . $_SESSION['ID'];
                header("Location: $uri");
            }
            break;
        case "editCharacter":
            $description = null;
            $characterClass = null;
            $avatarFile = null;
            if(isset($_POST['characterBio'])){$description = $_POST['characterBio'];}
            if(isset($_POST['characterClass'])){$characterClass = $_POST['characterClass'];}
            if(isset($_FILES["fileToUpload"])){$avatarFile = $_FILES["fileToUpload"];}
            $character->editCharacter($_POST['id'], $characterClass, $description);
            if ($avatarFile['name'] != "")
            {
                uploadAvatar($avatarFile, $_POST['id']);
            }
            $uri = '/Character/?ID=' . $_POST['id'];
            header("Location: $uri");
            break;
        case "postNews":
            $post = new Post();
            $post->postNewArticle($_POST['charID'], $_POST['title'], $_POST['post']);
            header("Location: /Admin");
            break;
        case "removePost":
            $editPost = new EditPost('delete', $_GET['id']);
            header("Location: /");
            break;
        case "postBounty":
                $merc->postBounty($_POST['charID'], $_POST['title'], $_POST['post'], $_POST['reward']);
                header("Location: /DM");
            break;
		default:
			break;
	}
}
?>