<?php
namespace lib;

Class Login
{
	private $password;
	private $username;
    private $db;
    public $success = false;
	
	function __construct($username, $password)
	{
		$this->password = stripslashes($password);
		$this->username = stripslashes($username);
        $this->db = new Database;
		$this->login($this->username, $this->password);
	}
	
	private function login($username, $password)
	{
        $stmt = $this->db->prepare('SELECT * FROM USER WHERE USERNAME = ?');
        $stmt->execute([$username]);
		$data = $stmt->fetch();
		if(!$data) {
            $this->success = false;
            return false;
        }
        //check if user is still using old password system
        if(!$data['CHANGED']) {
            //Verify current password
            $this->password = $password . $data['SALT'];
            $this->password = hash('sha256', $this->password);
            if($data['PASSWORD'] != $this->password) {
            return false;
            }
            $this->updatePassword($password, $data['ID']);
        } else {
            $this->password = $data['PASSWORD'];
        }
        // Register $username, $password and redirect to mainpage.
        // If the username or password is wrong, redirect to login page and show the login error.
        if(!password_verify($password, $this->password)) {
            $this->success = false;
            return false;
        }
        if($data['ACTIVE'] != '1') {
            $this->success = false;
            return false;
        }

        if(!isset($_SESSION['start'])) {
            session_start();
        }
        $_SESSION['ID'] = $data['ID'];
        $this->success = true;
        return true;
    }
    
    //change password hashing function
    private function updatePassword($password, $id)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE USER SET PASSWORD = ?, CHANGED = ? WHERE  ID = ?');
        $stmt->execute([$this->password, '1', $id]);
        return true;
    }

	function __destruct()
	{
		unset($this->password);
		unset($this->username);
	}
}
?>