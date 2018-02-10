<?php
namespace lib;

Class User
{
    protected $db;
    
    function __construct()
	{
        $this->db = new Database;
	}
    
    public function userLogin()
    {
        if(isset($_GET['error']))
		{
            echo('
            <div class="form_settings">
                <h4 style="color: #DC143C;">Invalid username or password, or the account has not been activated yet.</h4>
                <form action="./?action=login" method="post">
                    <p><input name="username" id="Username" type="text" onclick="this.value=\'\';" value="Username" maxlength="25"/></p>
                    <p><input name="password" id="Password" type="password" onclick="this.value=\'\';" value="Password" maxlength="30"/></p>
                    <p style="padding-top: 15px"><input id="Login_button" class="button" type="submit" value="Login"/></p>
                    <p><input id="Register_button" class="button" type="submit" formaction="./?action=register-forward" value="Register"/></p>
                </form>
            </div>
			'); 
		}
		else
		{
            echo('
            <div class="form_settings">
                <form action="./?action=login" method="post">
                    <p><input name="username" id="Username" type="text" onclick="this.value=\'\';" value="Username" maxlength="25"/></p>
                    <p><input name="password" id="Password" type="password" onclick="this.value=\'\';" value="Password" maxlength="30"/></p>
                    <p style="padding-top: 15px"><input id="Login_button" class="button" type="submit" value="Login"/></p>
                    <p><input id="Register_button" class="button" type="submit" formaction="./?action=register-forward" value="Register"/></p>
                </form>
            </div>
			'); 
		}
    }
	public function userLinks()
	{
        $mercSelected = NULL;
        $mapSelected = NULL;
        $DMSelected = NULL;
        $adminSelected = NULL;
        $userSelected = NULL;
        $loginSelected = NULL;
        $registerSelected = NULL;
        $currentFile = $_SERVER['SCRIPT_NAME'];
        switch($currentFile)
        {
            case "/Merc/index.php":
            {
                $mercSelected = ' class="selected"';
            }
            break;
            case "/Map/index.php":
            {
                $mapSelected = ' class="selected"';
            }
            break;
            case "/DM/index.php":
            {
                $DMSelected = ' class="selected"';
            }
            break;
            case "/Admin/index.php":
            {
                $adminSelected = ' class="selected"';
            }
            break;
            case "/User/index.php":
            {
                $userSelected = ' class="selected"';
            }
            break;
            case "/Character/index.php":
            {
                $userSelected = ' class="selected"';
            }
            break;
            case "/Login/index.php":
            {
                $loginSelected = ' class="selected"';
            }
            break;
            case "/Register/index.php":
            {
                $registerSelected = ' class="selected"';
            }
            break;
        default:
            break;
        }
        // Links for all users
        echo('<li' . $mapSelected . '><a href="/Map">Map</a></li>');
        // Links for Admins
		if(isset($_SESSION['ID']) && $this->getGroup($_SESSION['ID']) > '1300')
		{
            echo('<li' . $mercSelected . '><a href="/Merc">Merc</a></li>');
			echo('<li' . $DMSelected . '><a href="/DM">DM</a></li>');
            echo('<li' . $adminSelected . '><a href="/Admin">Admin</a></li>');
            echo('<li' . $userSelected . '><a href="/User?ID=' . $_SESSION['ID'] . '">' . $this->getAlias($_SESSION['ID']) . '</a></li><li><a href="/Logout">Logout</a></li>');
		}        
        // Links for DM
		elseif(isset($_SESSION['ID']) && $this->getGroup($_SESSION['ID']) > '1100')
		{
            echo('<li' . $mercSelected . '><a href="/Merc">Merc</a></li>');
			echo('<li' . $DMSelected . '><a href="/DM">DM</a></li>');
            echo('<li' . $userSelected . '><a href="/User?ID=' . $_SESSION['ID'] . '">' . $this->getAlias($_SESSION['ID']) . '</a></li><li><a href="/Logout">Logout</a></li>');
		}
        // Links for normal members
        elseif(isset($_SESSION['ID']) && $this->getGroup($_SESSION['ID']) > '999')
		{
			echo('<li' . $mercSelected . '><a href="/Merc">Merc</a></li>');
            echo('<li' . $userSelected . '><a href="/User?ID=' . $_SESSION['ID'] . '">' . $this->getAlias($_SESSION['ID']) . '</a></li><li><a href="/Logout">Logout</a></li>');
		}
        else
		{
            echo('<li' . $loginSelected . '><a href="/Login">Login</a></li>');
            echo('<li' . $registerSelected . '><a href="/Register">Register</a></li>');
		}
	}

	public function getGroup($id)
	{
        $stmt = $this->db->prepare('SELECT USERGROUP FROM USER WHERE ID = ?');
        $stmt->execute([$id]);
        $group = $stmt->fetchColumn();
		return $group;
	}
    
	public function getAvatar($id)
	{
        $stmt = $this->db->prepare('SELECT AVATAR FROM USER WHERE ID = ?');
        $stmt->execute([$id]);
        $avatar = $stmt->fetchColumn();
		if($avatar != null)
		{
			return $avatar;
		}
		else
		{
			return null;
		}
	}
    
	public function getAlias($id)
	{
        $stmt = $this->db->prepare('SELECT ALIAS FROM USER WHERE ID = ?');
        $stmt->execute([$id]);
        $alias = $stmt->fetchColumn();
		return $alias;
	}
    
    
    public function isAdmin($id)
    {
        $id = stripslashes($id);
        if($this->getGroup($id) != '1337') {
            return false;
        }
        return true;
    }

    public function isDM($id)
    {
        $id = stripslashes($id);
        if($this->getGroup($id) <= '1200') {
            return false;
        }
        return true;
    }
}
?>
