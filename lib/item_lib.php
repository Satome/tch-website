<?php
Class Update
{
	private $id;
    private $value;
	
	function __construct($new_id, $new_value)
	{
		$this->id = stripslashes($new_id);
        $this->value = stripslashes($new_value);
		$this->updateItem($this->id, $this->value);
	}
	
	protected function updateItem($id, $value)
	{
		require("mysqli.php");
		$this->id = $mysqli->real_escape_string($id);
        $this->value = $mysqli->real_escape_string($value);
		$mysqli->query("UPDATE ITEM SET VALUE='$this->value' WHERE ID='$this->id'");
        mysqli_close($mysqli);
        //echo '<script>window.alert("Updated.")</script>';
	}

	function __destruct()
	{
		unset($this->id);
        unset($this->value);
	}
}
?>