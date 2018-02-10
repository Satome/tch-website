<?php
namespace lib;


Class Register
{
	private $password;
	private $username;
    private $alias;
    public $success;
	
	public function __construct($new_username, $new_password, $new_alias)
	{
		$this->password = stripslashes($new_password);
		$this->username = stripslashes($new_username);
		$this->alias = stripslashes($new_alias);
        $this->db = new Database;
		$this->addUser($this->username, $this->password, $this->alias);
	}
	
    protected function userExists($username)
    {
        $stmt = $this->db->prepare('SELECT USERNAME FROM USER WHERE USERNAME = ?');
		$stmt->execute([$username]);
        $username = $stmt->fetch();
		if($username != "")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	protected function addUser($username, $password, $alias)
	{
        if(!$this->userExists($username)) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare('INSERT INTO USER (USERNAME, PASSWORD, ALIAS, CHANGED) VALUES (?, ?, ?, "1")');
            $stmt->execute([$username, $this->password, $alias]);
            $this->success = true;
            return true;
        }
        else {
            $this->success = false;
            return false;
        }
	}

	function __destruct()
	{
		unset($this->password);
		unset($this->username);
        unset($this->alias);
	}
}
?>