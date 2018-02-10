<?php
namespace lib;

Class Admin
{
    protected $db;
    protected $user;
    protected $post;
    protected $perks;
    
    function __construct()
    {
        $this->db = new Database;
        $this->post = new Post;
        $this->news = new News;
        $this->user = new User;
        $this->perks = new Perks;
    }
    
    public function getAdminView()
    {
        echo ( '<div id="admin_container">
                    <div id="left_col">
                        <div class="info tablink tablink_active" style="border-radius: 25px 0px 0px 0px;" onclick="openInfo(event, \'statistics\');">
                            <b>Statistics</b>
                        </div>
                        <div class="info tablink" onclick="openInfo(event, \'frontpage\');">
                            <b>Front Page settings</b>
                        </div>
                        <div class="info tablink" onclick="openInfo(event, \'accounts\');">
                            <b>Manage Accounts' . $this->getNeedActivate() . '</b>
                        </div>
                        <div class="info tablink">
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <b>News system includes now short tag support.</b>
                            <br />
                            <b>We have 2 types of tags:</b>
                            <br />
                            <b>[url]link[/url]</b>
                            <br />
                            <b>and</b>
                            <br />
                            <b>[image]link to image[/image]</b>
                        </div>
                    </div>
                    <div id="statistics" class="page_content">
                        <b>Registered users: ' . $this->getStatistics("user") . '</b>
                        <br />
                        <b>Characters: '  . $this->getStatistics("character") . '</b>
                    </div>
                    <div id="frontpage" class="page_content">');
                        $this->post->getPostForm();
        echo(           '<div id="news_list">');
                            $this->news->getNewsList();
        echo(           '</div>
                    </div>
                    <div id="accounts" class="page_content">
                        <div id="user_list">');
                            $this->getUserList();
        echo(          '</div>
                    </div>
                </div>');
    }
    
	public function getUserList()
	{
        $userID = $_SESSION['ID'];
        if(!$this->user->isAdmin($userID)) {
            return false;
        }
        $stmt = $this->db->prepare('SELECT ID, ALIAS, USERGROUP, ACTIVE FROM USER ORDER BY ACTIVE, ID');
        $stmt->execute();
        echo ('<div class="userInfo">
                <p class="userInfo" style="width: 80px;">ID</p>
                <p class="userInfo" style="width: 230px;">Alias</p>
                <p class="userInfo" style="width: 80px;">Rank</p>
              </div>');
        while ($row = $stmt->fetch())
		{
            $id = $row['ID'];
            $userAlias = utf8_encode($row['ALIAS']);
            $userGroup = utf8_encode($row['USERGROUP']);
			echo ('<div class="userInfo"><a href="#"><p class="userInfo" style="width: 80px;">' . $id . '</p>' . '<p class="userInfo" style="width: 240px;">' . $userAlias . '</p>' . '<p class="userInfo" style="width: 80px;">' . $userGroup . '</p></a>');
            if($row['ACTIVE'] == 0) {
                echo('    <a href="#" onclick="activateUser(' . $id . ')">Activate</a>');
            }
            echo('    <a href="#" onclick="removeUser(' . $id . ')">Remove</a>');
            echo ('</div>');
			echo ('<br>');
		}
	}
    
	public function getNeedActivate()
	{
        $userID = $_SESSION['ID'];
        if(!$this->user->isAdmin($userID)) {
            return false;
        }
        $stmt = $this->db->prepare('SELECT ID FROM USER WHERE ACTIVE = "0"');
        $stmt->execute();
        $result = count($stmt->fetchAll());
        if($result == '0') {
            return false;
        }
        return ' (' . $result . ')';
	}
    
    public function activateUser($id)
	{
        $userID = $_SESSION['ID'];
        if(!$this->user->isAdmin($userID)) {
            return false;
        }
        $stmt = $this->db->prepare('UPDATE USER SET ACTIVE = 1 WHERE ID = ?');
        $stmt->execute([$id]);
        return true;
	}
    
    public function removeUser($id = 0)
	{
        $userID = $_SESSION['ID'];
        if(!$this->user->isAdmin($userID)) {
            return false;
        }
        if($id == 0) {
            return false;
        }
        $stmt = $this->db->prepare('DELETE FROM USER WHERE ID = ?');
        $stmt->execute([$id]);
        $stmt = $this->db->prepare('DELETE FROM USER_CHARACTER WHERE USERID = ?');
        $stmt->execute([$id]);
        return true;
	}

    public function getStatistics($type)
        {
            switch ($type)
            {
                case 'user':
                    $stmt = $this->db->prepare('SELECT COUNT(*) AS total FROM USER');
                    break;
                case 'character':
                    $stmt = $this->db->prepare('SELECT COUNT(*) AS total FROM USER_CHARACTER');
                    break;
                default:
                    break;
            }
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total'];
        }
}
?>
