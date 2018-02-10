<?php
namespace lib;


Class Post
{
    protected $db;
    protected $user;
    protected $charID;
    protected $post;
    protected $title;
    protected $postDate;
	
	public function __construct()
	{
        $this->db = new Database;
        $this->user = new User;
        $this->character = new Character;
        $this->postDate = date("F j, Y");
	}
    
    public function getPostForm()
    {
		if(!isset($character))
		{
			$character = new Character();
		}
        echo('
        <div id="newsForm">
        <form id="postNews" method="post" action="./?action=postNews" style="height: 280px;">
            <input type="text" required placeholder="Title" name="title" class="info" size="33">
            <select name="charID" class="info">
            ' . $character->getCharacterList() . '
            </select>
            <input id="Submit" class="button" type="submit" value="Submit"/>
            <br />
            <textarea cols="60" rows="15" placeholder="News article" name="post"></textarea>
        </form></div><br />');
    }
    
    public function postNewArticle($charID, $title, $post)
    {
		if(!isset($user))
		{
			$user = new User();
		}
        $userID = $_SESSION['ID'];
        if(!$user->isAdmin($userID)) {
            return false;
        } 
        $this->post = stripslashes(trim($post));
        $this->title = stripslashes(trim($title));
        $this->charID = $charID;
        $this->checkTags($this->post);
        return true;
    }
	// Function to check if message contains any tags, use existing tags as templates if you add more.
	// If tag is found, call "tagParser" to take care of the technical stuff.
	// This function is run untill the message does not contain any tags, then it calls the sql injector
	private function checkTags($post)
	{
		if (stristr($post, "[url]") && stristr($post, "[/url]"))
		{
			$this->tagParser($post, "[url]");
		}
		elseif (stristr($post, "[image]") && stristr($post, "[/image]"))
		{
			$this->tagParser($post, "[image]");
		}
		else
		{
			// return the message to be used in the main function
			$this->insSql($this->postDate, $this->charID, $this->title, $this->post);
		}
	}
	
	// Function to parse the tags, it starts by storing the first part of the message before any tags to array, and then processing the ending tag.
	// To add more tags, just replicate the case "[url]" and change the tag type.
	private function tagParser($post, $new_tag)
	{
		$msgAR[] = substr($post, 0, stripos($post, $new_tag));
		//print_r($msgAR);
		switch ($new_tag)
			{
				case "[url]":
					$msgAR[]	=	'<a href="';
					$oldPos = stripos($post, "[url]") + 5;
					$tmp2 = stripos($post, "[/url]");
					$mLenght = $tmp2 - $oldPos;
					$URL = substr($post, $oldPos, $mLenght);
					if (substr($URL, 0, 4) != "http" & substr($URL, 0, 3) != "ftp")
					{
						$URL = "http://" . $URL;
					}
					$msgAR[] = $URL;
					$msgAR[] = '" target="_blank">';
					$msgAR[] = $URL;
					$msgAR[] = '</a>';
					$msgAR[] = substr($post, stripos($post, "[/url]") + 6);
					break;
				case "[image]":
					$msgAR[]	=  '<img class="post" src="';
					$oldPos = stripos($post, "[image]") + 7;
					$tmp2 = stripos($post, "[/image]");
					$mLenght = $tmp2 - $oldPos;
					$URL = substr($post, $oldPos, $mLenght);
					if (substr($URL, 0, 4) != "http" & substr($URL, 0, 3) != "ftp")
					{
						$URL = "http://" . $URL;
					}
					$msgAR[] = $URL;
					$msgAR[]	=  '" alt="';
					$msgAR[] = $URL;
					$msgAR[] = '">';
					$msgAR[] = substr($post, stripos($post, "[/image]") + 8);
					break;
				default:
					break;
			}
		// Compress the array into string and pass it to tagChecker for new inspection.
		$this->post = implode($msgAR);
		//print_r($this->post);
		$this->checkTags($this->post);
	}
	
	// Function to insert the messages to database
	private function insSql($postDate, $charID, $title, $post)
	{
		// Insert the message to database
        $stmt = $this->db->prepare('INSERT INTO GUILD_NEWS (DATE, USER, TITLE, POST) VALUES (?, ?, ?, ?)');
        $stmt->execute([$postDate, $charID, $title, $post]);
	}
}

?>