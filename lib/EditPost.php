<?php
namespace lib;


Class EditPost
{
	private $action;
	private $id;
    protected $db;
	
	function __construct($new_action, $new_id)
	{
        $this->db = new Database;
		$this->action = $new_action;
		$this->id = stripslashes($new_id);
		$this->checkAction($this->action);
	}
	
	function checkAction($new_action)
	{
		switch ($new_action)
		{
			case "delete":
				$this->rmMessage($this->id);
				break;
			default:
				break;
		}
	}
	
	// Function to remove existing messages
	function rmMessage($new_id)
	{
        $stmt = $this->db->prepare('DELETE FROM GUILD_NEWS WHERE ID = ?');
        $stmt->execute([$new_id]);
	}
}