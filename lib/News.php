<?php
namespace lib;

Class News
{
	public $newsAmount = null;
	protected $db;
    protected $user;
    
	public function __construct()
	{
		$this->newsAmount = 2;
        $this->db = new Database;
        $this->user = new User;
        $this->character = new Character;
	}
	
	public function showNews()
	{
		$amount = $this->newsAmount;
		$stmt = $this->db->prepare('SELECT * FROM GUILD_NEWS ORDER BY ID DESC LIMIT ?');
		$stmt->execute([$amount]);
		while ($row = $stmt->fetch())
		{
            $charName = utf8_encode($this->character->getCharName($row['USER']));
			// Output the postinfo (Time, User)
			echo '<div class="postframe">
                    <div class="postinfo">
                        <h3 class="info" style="width: 100%;">' . $row['TITLE'] . '
                        </h3>
                        <p class="info">Posted by: ' . $charName . '
                        </p>
                        <p class="info">' . $row['DATE'] . '
                        </p>
                    </div>
                    <div class="post">
                        <p class="post">';
			// Create array from posts, so we can limit the amount of lines shown
			$parray = explode("\n", $row['POST']);
			$i = "0";
			while($i != count($parray))
			{
				echo $parray[$i] . '<br>';
				$i++;
				// If we go ower the limit of lines, post the link for full message
			//	if($i > "9" && $i != count($parray))
			//	{
			//		echo '<b>...</b><br><a href="#" onclick="showFullPost(' . $row['ID'] . ');return false;" style="margin: 0px 20px 0px 0px">Click here to read the full message</a><br>';
			//	}
			}
			echo '</p></div></div><br>';
		}
	}
	
	public function showFull($new_postID)
	{
        $postID = $new_postID;
		$stmt = $this->db->prepare('SELECT * FROM GUILD_NEWS WHERE ID = ?');
		$stmt->execute([$postID]);
		while ($row = $stmt->fetch())
		{
            $charName = utf8_encode($this->character->getCharName($row['USER']));
			// Output the postinfo (Time, User)
			echo '<div class="postframe">' . '<div class="postinfo"><p class="info">Posted on: ' . $row['DATE'] . '  By ' . $charName;

			// Output the post itself
			echo '</p></div>' . '<div class="post"><p class="post">';
			// Create array from posts, so we can limit the amount of lines shown
			$parray = explode("\n", $row['POST']);
			$i = "0";
			while($i != count($parray))
			{
				echo $parray[$i] . '<br>';
				$i++;
			}
			echo '</p></div></div><br>';
		}
	}
    
	public function getNewsList()
	{
        $stmt = $this->db->prepare('SELECT * FROM GUILD_NEWS ORDER BY ID DESC');
        $stmt->execute();
        while ($row = $stmt->fetch())
		{
            $id = $row['ID'];
            $charName = utf8_encode($this->character->getCharName($row['USER']));
            $title = utf8_encode($row['TITLE']);
            if(!$title) {
                $title = 'No title';
            }
            $post = utf8_encode($row['POST']);
            $date = utf8_encode($row['DATE']);
            $parray = explode("\n", $post);
            $i = "0";
			// Output the postinfo (Time, User)
			echo(   '<div id="newsFrame">
                        <div class="articleInfo">
                            <a href="#" onclick="showArticle(\'' . $id . '_art\');return false;">
                                <p class="articleInfo" style="width: 45%;">' . $title . '</p>
                                <p class="articleInfo" style="width: 25%;">' . $charName . '</p>
                                <p class="articleInfo" style="width: 15%;">' . $date . '</p>
                                <a href="#" onclick="removeArticle(\'' . $id . '\');">Remove</a>
                            </a>
                        </div>
                        <div id="' . $id . '_art" class="articleDesc" style="display: none;">
                            <p class="articleDesc">');
                            while($i != count($parray))
                            {
                                echo $parray[$i] . '<br>';
                                $i++;
                            }
            echo (         '</p>
                        </div>
                    </div>
                    <br>');
		}
	}

	public function removeArticle($id)
	{
        $userID = $_SESSION['ID'];
        if(!$this->user->isAdmin($userID)) {
            return false;
        }
        $stmt = $this->db->prepare('DELETE FROM GUILD_NEWS WHERE ID = ?');
        $stmt->execute([$id]);
        return true;
	}
}

?>
