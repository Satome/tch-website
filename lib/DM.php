<?php
namespace lib;


Class DM
{
    protected $db;
    protected $character;
    protected $merc;
    
    public function __construct()
    {
        $this->db = new Database;
		$this->character = new Character; 
        $this->merc = new Merc; 
    }
    
    function getEncounter()
    {
        echo ('
            <div style="position: relative; background-color: #b9b5b5;">
                <div style="height: 35px; background-color: #a09f9f;">
                    <a href="#" target="admin" onclick=\'showPoi(document.getElementById("poi").value);return false;\' class="admin">Roll</a>
                </div>
                <form>
                    <select id="poi" name="poi" onchange="showPoi(this.value)">
                    ' . $this->getPOIname() . '
                    </select>
                </form>
                <div id="result">
                </div>
            </div>');
    }
    function getPOIname()
    {
        $out = null;
        $stmt = $this->db->prepare('SELECT * FROM POI');
        $stmt->execute();
        while($row = $stmt->fetch());
        {
            $alias = $row['NAME'];
            $id = $row['ID'];
            $out = $out . '<option value='. $id . '>' . $alias . '</option><br />';
        }
        return $out;
    }
    
    public function getDMView()
    {
        echo ( '<div id="dm_container">
                    <div id="left_col">
                        <div class="info tablink tablink_active" style="border-radius: 25px 0px 0px 0px;" onclick="openInfo(event, \'bounties\');">
                            <b>Manage Bounties</b>
                        </div>
                        <div class="info tablink" onclick="openInfo(event, \'characters\');">
                            <b>Manage Characters</b>
                        </div>
                        <div class="info tablink" onclick="openInfo(event, \'encounters\');">
                            <b>Encounters</b>
                        </div>
                    </div>
                    <div id="bounties" class="page_content">');
                        $this->merc->showPostForm();
        echo(           '<div id="bountyList">');
                            $this->merc->getBountyList(20, true);
        echo(           '</div>
                    </div>
                    <div id="characters" class="page_content">');
                        $this->character->listCharacters(0);
        echo(      '</div>
                    <div id="encounters" class="page_content">
                        <b> DISABLED </b>
                    </div>
                </div>');
    }
}
/*
if(isset($_GET['a']) && $_GET['a'] == 'listCharacters'){$character->listCharacters(0);}
if(isset($_GET['a']) && $_GET['a'] == 'getEncounter'){$dm->getEncounter();}
if(isset($_GET['a']) && $_GET['a'] == 'addBounty'){$merc->showPostForm();}
*/

?>