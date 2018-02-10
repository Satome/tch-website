<?php
namespace lib;


Class Merc
{
    protected $db;
    protected $user;
    protected $character;
    
    public function __construct()
    {
        $this->db = new Database;
        $this->user = new User;
        $this->character = new Character;
    }
    
	public function getBountyList($new_amount = 50, $all = false)
	{
		$amount = $new_amount;
        if($all) {
            $stmt = $this->db->prepare('SELECT * FROM BOUNTY ORDER BY ID DESC LIMIT ?');
        } else {
            $stmt = $this->db->prepare('SELECT * FROM BOUNTY WHERE STATUS<>"Completed" AND STATUS<>"Failed" ORDER BY ID DESC LIMIT ?');
        }
        $stmt->execute([$amount]);
        while ($row = $stmt->fetch())
		{
            $id = $row['ID'];
            $charName = utf8_encode($this->character->getCharName($row['CHARID']));
            $title = utf8_encode($row['TITLE']);
            $post = utf8_encode($row['POST']);
            $time = utf8_encode($row['TIME']);
            $status = utf8_encode($row['STATUS']);
            $reward = utf8_encode($row['REWARD']);
            $parray = explode("\n", $post);
            $i = "0";
			// Output the postinfo (Time, User)
			echo ('<div id="bountyFrame">' . '<div class="bountyInfo"><a href="#" onclick="showBounty(\'' . $id . '_bnt\');return false;"><p class="bountyInfo" style="width: 45%;">' . $title . '</p>' . '<p class="bountyInfo" style="width: 25%;">' . $charName . '</p>' . '<p class="bountyInfo" style="width: 15%;">' . $time . '</p></a>');
            echo $this->getBountyStatus($status, $id);
            echo ('</div>');
            echo ('<div id="' . $id . '_bnt" class="bountyDesc" style="display: none;"><p class="bountyDesc">');
            while($i != count($parray))
            {
                echo $parray[$i] . '<br>';
                $i++;
            }
            echo ('<br />Completing this bounty will earn you ' . $reward . '<br />');
            echo ('</p></div>');
			echo ('</div><br>');
		}
	}
    
	public function postBounty($new_charID, $new_title, $new_post, $new_reward)
	{
		// Trim the message in case of sql injection
        $charID = trim($new_charID);
        $charID = stripslashes($charID);
        $title = trim($new_title);
        $title = stripslashes($title);
        $post = trim($new_post);
        $post = stripslashes($post);
        $reward = trim($new_reward);
        $reward = stripslashes($reward);
        $status = 'Available';
        $time = date('d-m-Y');
        $userID = $_SESSION['ID'];
        if(!$this->user->isDM($userID)){
            return false;
        }
		// Insert the message to database
        $stmt = $this->db->prepare('INSERT INTO BOUNTY (CHARID, TITLE, POST, REWARD, STATUS, TIME) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$charID, $title, $post, $reward, $status, $time]);
	}
    
    public function showPostForm()
    {
        echo('
        <div id="bountyForm">
        <form id="postBounty" method="post" action="./?action=postBounty" style="height: 280px;">
            <input required placeholder="[TYPE] Title" name="title" class="info">
            <input required placeholder="Reward" name="reward" class="info">
            <select name="charID" class="info">
            ' . $this->character->getCharacterList() . '
            </select>
            <input id="Submit" class="button" type="submit" value="Submit"/>
            <br />
            <textarea cols="60" rows="15" placeholder="Bounty description" name="post"></textarea>
        </form></div><br />');
    }
    
    public function getBountyStatus($new_status, $new_id)
    {
        //if(!isset($user)){$user = new User();}
        $userID = ($_SESSION['ID']);
        $out = null;
        $status = $new_status;
        $id = $new_id;
        $available = '<option value="Available">Available</option>';
        $inprogress = '<option value="In progress">In progress</option>';
        $completed = '<option value="Completed">Completed</option>';
        $failed = '<option value="Failed">Failed</option>';
        if ($status == "Available"){$available = '<option value="Available" selected>Available</option>';}
        if ($status == "In progress"){$inprogress = '<option value="In progress" selected>In progress</option>';}
        if ($status == "Completed"){$completed = '<option value="Completed" selected>Completed</option>';}
        if ($status == "Failed"){$failed = '<option value="Failed" selected>Failed</option>';}
        if($this->user->isDM($userID)) {
            $out = '<form style="width: 10%; display: inline-block;">
            <p class="bountyInfo">
            <select id="status" name="status" onchange="setBountyStatus(\'' . $id . '\', this.value)">
            ' . $available . '
            <br />
            ' . $inprogress . '
            <br />
            ' . $completed . '
            <br />
            ' . $failed . '
            <br />
            </select>
            </p>
            </form>';
        }
        else
        {
            $out = '<p class="bountyInfo">' . $status . '</p>';
        }
        return $out;
    }
    
    public function setBountyStatus($new_status, $new_id)
    {	
        $status = $new_status;
        $bountyID = $new_id;
        $userID = $_SESSION['ID'];
        if(!$this->user->isDM($userID)){
            return false;
        }
        $stmt = $this->db->prepare('UPDATE BOUNTY SET STATUS = ? WHERE ID = ?');
        $stmt->execute([$status, $bountyID]);
    }
}
?>
