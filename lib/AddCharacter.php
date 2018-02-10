<?php
namespace lib;

Class AddLocation
{
    private $name;
	private $description;
    private $zone;
	private $table;
	
	function __construct($new_name, $new_description, $new_zone, $new_table)
	{
		$this->name = trim($new_name);
        $this->name = stripslashes($this->name);
		$this->description = trim($new_description);
		$this->description = stripslashes($this->description);
        $this->zone = trim($new_zone);
        $this->zone = stripslashes($this->zone);
        $this->table = trim($new_table);
        $this->table = stripslashes($this->table);
		$this->insSql($this->name, $this->description, $this->zone, $this->table);
	}

	// Function to insert the messages to database
	function insSql($new_name, $new_description, $new_zone, $new_table)
	{
		require("mysqli.php");
		// Trim the message in case of sql injection
		$this->name = $mysqli->real_escape_string($new_name);
		$this->description = $mysqli->real_escape_string($new_description);
        $this->zone = $mysqli->real_escape_string($new_zone);
        $this->table = $mysqli->real_escape_string($new_table);
        
        if(!$this->zone == NULL)
		{
            // Insert the message to database
            $mysqli->query("INSERT INTO $this->table (NAME, DESCRIPTION, ZONE) VALUES ('$this->name', '$this->description', '$this->zone')");
            //header("location: admin.php");
        }
        else
        {
             // Insert the message to database
            $mysqli->query("INSERT INTO $this->table (NAME, DESCRIPTION) VALUES ('$this->name', '$this->description')");
            //header("location: admin.php");
        }
        mysqli_close($mysqli);
	}
}
Class AddEntity
{
    private $classification;
	private $type;
    private $entityClass;
	private $zone;
	
	function __construct($new_classification, $new_type, $new_entityClass, $new_zone)
	{
		$this->classification = trim($new_classification);
        $this->classification = stripslashes($this->classification);
		$this->type = trim($new_type);
		$this->type = stripslashes($this->type);
        $this->entityClass = trim($new_entityClass);
        $this->entityClass = stripslashes($this->entityClass);
        $this->zone = trim($new_zone);
        $this->zone = stripslashes($this->zone);
        
        if(!is_numeric($this->type))
        {   
            $this->typeExists($this->type);
        }
        if(!is_numeric($this->entityClass) && $this->entityClass != NULL)
		{
            $this->classExists($this->entityClass);
        }
        $this->insEntity($this->classification, $this->type, $this->entityClass, $this->zone);
	}

	// Function to insert the messages to database
	function insEntity($new_classification, $new_type, $new_entityClass, $new_zone)
	{
		require("mysqli.php");
		// Trim the message in case of sql injection
		$this->classification = $mysqli->real_escape_string($new_classification);
		$this->type = $mysqli->real_escape_string($new_type);
        $this->entityClass = $mysqli->real_escape_string($new_entityClass);
        $this->zone = $mysqli->real_escape_string($new_zone);
        // Insert the message to database
        //echo $this->classification, $this->type, $this->entityClass;
        $mysqli->query("INSERT INTO ENTITY (CLASSIFICATION, TYPE, CLASS, ZONE) VALUES ('$this->classification', '$this->type', '$this->entityClass', '$this->zone')");
        header("location: entity.php");
        mysqli_close($mysqli);
	}
    
    function insType($new_type)
	{
		require("mysqli.php");
		// Trim the message in case of sql injection
		$this->type = $mysqli->real_escape_string($new_type);
        // Insert the message to database
        //echo $this->classification, $this->type, $this->entityClass;
        $mysqli->query("INSERT INTO ENTITY_TYPE (NAME) VALUES ('$this->type')");
        $this->type = $mysqli->insert_id;
        mysqli_close($mysqli);
        //header("location: admin.php");
	}
    
    function typeExists($new_type)
    {
        require("mysqli.php");
        $this->type = $mysqli->real_escape_string($new_type);
        $res = $mysqli->query("SELECT  FROM ENTITY_TYPE WHERE NAME = '$this->type'");
        if($res->num_rows == 0)
        {
            $this->insType($this->type);
        }
        else
        {
            $row = $res->fetch_Assoc();
            $this->type = $row['ID'];
        }
        mysqli_close($mysqli);
    }
    
    function classExists($new_entityClass)
    {
        require("mysqli.php");
        $this->entityClass = $mysqli->real_escape_string($new_entityClass);
        $res = $mysqli->query("SELECT  FROM ENTITY_CLASS WHERE NAME = '$this->entityClass'");
        if($res->num_rows == 0)
        {
            $this->insEntityClass($this->entityClass);
        }
        else
        {
            $row = $res->fetch_Assoc();
            $this->entityClass = $row['ID'];
        }
        mysqli_close($mysqli);
    }
    
    function insEntityClass($new_entityClass)
	{
		require("mysqli.php");
		// Trim the message in case of sql injection
        $this->entityClass = $mysqli->real_escape_string($new_entityClass);
        // Insert the message to database
        //echo $this->classification, $this->type, $this->entityClass;
        $mysqli->query("INSERT INTO ENTITY_CLASS (NAME) VALUES ('$this->entityClass')");
        $this->entityClass = $mysqli->insert_id;
        mysqli_close($mysqli);
        //header("location: admin.php");
	}
}

Class AddCharacter
{
    private $name;
    private $characterClass;
//    private $rank;
//    private $perks;
	private $description;
//    private $avatar;
    private $user;
    protected $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
	function __construct($new_name, $new_characterClass, $new_description, $new_user)
	{
		$this->name = trim($new_name);
        $this->name = stripslashes($this->name);
		$this->characterClass = trim($new_characterClass);
        $this->characterClass = stripslashes($this->characterClass);
//        $this->rank = trim($rank);
//        $this->rank = stripslashes($this->rank);
//        $this->perks = trim($perks);
//        $this->perks = stripslashes($this->perks);
		$this->description = trim($new_description);
		$this->description = stripslashes($this->description);
//        $this->avatar = trim($avatar);
//        $this->avatar = stripslashes($this->avatar);
        $this->user = trim($new_user);
        $this->user = stripslashes($this->user);
        if(!$this->characterExists($this->name))
        {
            $this->insSql($this->name, $this->characterClass, $this->description, $this->user);
        }
        else
        {
            echo('<script>window.location = "/User?ID=' . $_SESSION['ID'] . '"</script>');
        }
	}

	// Function to insert the messages to database
	function insSql($new_name, $new_characterClass, $new_description, $new_user)
	{
        $stmt = $this->db->prepare('INSERT INTO USER_CHARACTER (NAME, CHARACTER_CLASS, DESCRIPTION, USERID) VALUES (?, ?, ?, ?)');
        $stmt->execute([$this->name, $this->characterClass, $this->description, $this->user]);
        echo('<script>window.location = "/User?ID=' . $_SESSION['ID'] . '"</script>');
	}
    
    function characterExists($character)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM USER_CHARACTER WHERE NAME = ?');
        $stmt->execute([$character]);
        $name = $stmt->fetchColumn();
        if($name == "")
        {
            return false;
        }
        else
        {
            echo '<script>window.alert("The username is already taken.")</script>';
            return true;
        }
    }
}
/* Class Edit
{
	private $action;
	private $id;
	
	function __construct($new_action, $new_id)
	{
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
		require("mysqli.php");
		$this->id = $mysqli->real_escape_string($new_id);
		$mysqli->query("DELETE FROM news WHERE ID='$this->id'");
		header("location: index.php");
	}
}*/
?>