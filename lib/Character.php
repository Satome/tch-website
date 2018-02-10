<?php
namespace lib;

Class Character
{
    protected $db;
    protected $user;
    
    public function __construct()
    {
        $this->db = new Database;
        $this->user = new User;
    }
    
    //PERK STUFF
    function getPerkName($id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM PERKS WHERE ID = ?');
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn();
        $name = utf8_encode($name);
		return $name;
    }
    
    function getPerkDesc($id)
    {
        $stmt = $this->db->prepare('SELECT DESCRIPTION FROM PERKS WHERE ID = ?');
        $stmt->execute([$id]);
        $description = $stmt->fetchColumn();
        $description = utf8_encode($description);
		return $description;
    }
    
    function getPerkIcon($id)
    {
        $stmt = $this->db->prepare('SELECT ICON FROM PERKS WHERE ID = ?');
        $stmt->execute([$id]);
        $icon = $stmt->fetchColumn();
        $icon = utf8_encode($icon);
        $icon = pathinfo($icon);
		return $icon['filename'];
    }
    
    function getAttributeIcon($id)
    {
        $stmt = $this->db->prepare('SELECT ICON FROM ATTRIBUTES WHERE ID = ?');
        $stmt->execute([$id]);
        $icon = $stmt->fetchColumn();
        $icon = utf8_encode($icon);
        $icon = pathinfo($icon);
		return $icon['filename'];
    }

    function getCharacterPerks($new_charID)
    {
        $out = null;
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT PERKS FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $perks = $stmt->fetchColumn();
        if ($perks != "")
        {
            $perks = explode(",", $perks);
            $perks = array_filter($perks);
            while (list($key, $value) = each($perks))
            {
                if($value != "")
                {
                    $description = '<div id="' . $value . '_desc" class="_desc"><b>' . $this->getPerkName($value) . '</b><br />' . $this->getPerkDesc($value) . '</div>';
                    $icon = '<img style="widht: 60px; height: 60px;" onmouseover="showDescription(event,\'' . $value . '_desc\')" onmouseout="showDescription(event,\'' . $value . '_desc\')"src="/images?perk_icon=';
                    $icon = $icon . $this->getPerkIcon($value);
                    unset($value);
                    $icon = $icon . '">';
                    $out = $out . $icon . $description;
                }
            }
        }
        else
        {
            $out = 'Perks not set';
        }
		echo $out;
    }

    function getAttributeName($id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM ATTRIBUTES WHERE ID = ?');
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn();
        $name = utf8_encode($name);
		return $name;
    }
    
    function getAttributeDesc($id)
    {
        $stmt = $this->db->prepare('SELECT DESCRIPTION FROM ATTRIBUTES WHERE ID = ?');
        $stmt->execute([$id]);
        $description = $stmt->fetchColumn();;
        $description = utf8_encode($description);
		return $description;
    }
    
    //Character functions
    function getCharacterName($new_charID)
    {
        $out = null;
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT NAME FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $name = $stmt->fetchColumn();
        echo $name;
    }
    
    function getCharacterAvatar($new_charID)
    {
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT AVATAR FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $avatar = $stmt->fetchColumn();
        if($avatar == "")
        {
            $avatar = 'noimage';
        }
        if(strpos($avatar, 'http://') !== false)
        {
            $avatar = $avatar;
        }
        else
        {
            $avatar = '/images?character_icon=' . $avatar;
        }
        return $avatar;
    }

    function getCharacterRank($new_charID)
    {
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT RANK FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $rank = $stmt->fetchColumn();
        $rank = $this->getRank($rank);
        echo $rank;
    }
    
    function getCharacterBio($new_charID, $raw)
    {
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT DESCRIPTION FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $description = $stmt->fetchColumn();
        if ($raw !=true)
        {
            $parray = explode("\n", $description);
            $i = "0";
            while($i != count($parray))
            {
                echo $parray[$i] . '<br>';
                $i++;
            }
        }
        else
        {
            return $description;
        }
    }
    
    function getCharacterClass($new_charID)
    {
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT CHARACTER_CLASS FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $characterClass = $stmt->fetchColumn();
        return $characterClass;
    }
    
    function getCharacterAttribute($new_charID)
    {
        $out = null;
        $charID = stripslashes($new_charID);
        $stmt = $this->db->prepare('SELECT ATTRIBUTE FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $characterAttribute = $stmt->fetchColumn();
        
        if ($characterAttribute != "")
        {
            $description = '<div id="' . $characterAttribute . '_desc" class="_desc"><b>' . $this->getAttributeName($characterAttribute) . '</b><br />' . $this->getAttributeDesc($characterAttribute) . '</div>';
            $icon = '<img style="widht: 60px; height: 60px;" onmouseover="showDescription(event,\'' . $characterAttribute . '_desc\')" onmouseout="showDescription(event,\'' . $characterAttribute . '_desc\')"src="/images?attribute_icon=';
            $icon = $icon . $this->getAttributeIcon($characterAttribute);
            $icon = $icon . '">';
            $out = $icon . $description;
        }
        else
        {
            $out = 'Attribute not set';
        }
		echo $out;
    }
    
    function getAttributes($new_type, $new_charID)
    {
        $charID = stripslashes($new_charID);
        $type = $new_type;
        $stmt = $this->db->prepare('SELECT * FROM ATTRIBUTES WHERE CLASS = ?');
        $stmt->execute([$type]);
        while ($row = $stmt->fetch())
		{
            echo('<p style="color: black; font: bold 12px/30px Georgia, serif; margin-bottom: 0px; text-align: center">' . $row['NAME'] . '</p>');
            echo('<div id="' . $row['ICON'] . '_desc" class="_desc">' . $this->getAttributeDesc($row['ID']) . '</div>');
            echo('<input id="' . $row['ICON'] . '" class="attributeIcon" value="' . $row['ID'] . '" type="checkbox" onclick="setCharacterAttribute(' . $charID . ')" ' . $this->attributeChecked($row['ID'], $charID) . '>');
            echo('<label for="' . $row['ICON'] . '" onmouseover="showDescription(event,\'' . $row['ICON'] . '_desc\')" onmouseout="showDescription(event,\'' . $row['ICON'] . '_desc\')" style="color: black; font: bold 12px Georgia, serif;"><img src="/images?attribute_icon=' . $this->getAttributeIcon($row['ID']) . '" onerror="this.src=\'/images?attribute_icon=wut\'" style="display: block; height: 48px; margin-bottom: 0px; margin-left: auto; margin-right: auto;"/></label><br />');
        }
    }
    
    function getPerks($new_type, $new_charID, $new_offset)
    {
        $charID = stripslashes($new_charID);
        $type = $new_type;
        $offset = $new_offset;
        $charPerks = $this->getCharPerks($charID);
        $stmt = $this->db->prepare('SELECT * FROM PERKS WHERE TYPE = ? ORDER BY COST DESC');
        $stmt->execute([$type]);
        $perks = $stmt->fetchAll();
        $perks = array_slice($perks, $offset, 6);
        foreach($perks as $perk) {
            $cost = $perk['COST'];
            if(!empty($charPerks)) {
                if($perk['ID'] == 2 && in_array('1', $charPerks) && in_array('3', $charPerks)) {
                $cost = 1;
                }
                // Set Fury perk cost to 1 if Berserking is active
                if($perk['ID'] == 12 && in_array('14', $charPerks)) {
                $cost = 1;
                }
                // Set Berserking perk cost to 1 if Fury is active
                if($perk['ID'] == 14 && in_array('12', $charPerks)) {
                $cost = 1;
                }
            }
            echo('<p style="color: black; font: bold 12px/30px Georgia, serif; margin-bottom: 0px; text-align: center">' . $perk['NAME'] . '</p>');
            echo('<div id="' . $this->getPerkShort($perk['NAME']) . '_desc" class="_desc">' . $this->getPerkDesc($perk['ID']) . '</div>');
            echo('<input id="' . $this->getPerkShort($perk['NAME']) . '" class="perkIcon" value="' . $perk['ID'] . '" type="checkbox" onclick="setPerks(' . $charID . ')" ' . $this->perkChecked($perk['ID'], $charID) . '>');
            echo('<label for="' . $this->getPerkShort($perk['NAME']) . '" onmouseover="showDescription(event,\'' . $this->getPerkShort($perk['NAME']) . '_desc\')" onmouseout="showDescription(event,\'' . $this->getPerkShort($perk['NAME']) . '_desc\')" style="color: black; font: bold 12px Georgia, serif;"><img src="/images/icons/perks/' . $this->getPerkIcon($perk['ID']) . '" onerror="this.src=\'/images?attribute_icon=wut\'" style="display: block; height: 48px; margin-bottom: 0px; margin-left: auto; margin-right: auto;"/><span style="display: inline-block; width: 100%; text-align: center;">Cost: ' . $cost . 'pp</span></label><br />');
        }
    }
    
    function getPerkShort($new_perkName)
    {
        $perkName = $new_perkName;
        $len = strpos($perkName, ')') - 1;
        $out = substr($perkName, 1, $len);
        return $out;
    }
    
    function listPerks($new_charID)
    {
        $charID = $new_charID;
        echo('<div style="margin-left: auto; margin-right: auto;">
        <div style="display: inline-block; width:20%; text-align: center">');
        $this->getPerks('Healing', $charID, 0);
        echo ('<p style="color: black; font:italic bold 16px/40px Georgia, serif; margin-bottom: 0px;">Healing</p>');
        echo('</div>');
        echo('<div style="display: inline-block; width:20%; text-align: center">');
        $this->getPerks('Magic', $charID, 0);
        echo ('<p style="color: black; font:italic bold 16px/40px Georgia, serif; margin-bottom: 0px;">Magic</p>');
        echo('</div>');
        echo('<div style="display: inline-block; width :20%; text-align: center">');
        $this->getPerks('Physical', $charID, 6);
        echo ('<p style="color: black; font:italic bold 16px/40px Georgia, serif; margin-bottom: 0px;">Physical</p>');
        echo('</div>');
        echo('<div style="display: inline-block; width :20%; text-align: center">');
        $this->getPerks('Physical', $charID, 0);
        echo ('<p style="color: black; font:italic bold 16px/40px Georgia, serif; margin-bottom: 0px;">Physical</p>');
        echo('</div>');
        echo('<div style="display: inline-block; width:20%; text-align: center">');
        $this->getPerks('Omni', $charID, 0);
        echo ('<p style="color: black; font:italic bold 16px/40px Georgia, serif; margin-bottom: 0px;">Omni</p>');
        echo('</div>');
        echo ('<p style="color: black; font:italic bold 16px/40px Georgia, serif; margin-bottom: 0px;">PP left: ' . $this->ppLeft($charID) . '</p>');
        echo('</div>');
    }

    function listAttributes($new_charID)
    {
        $charID = $new_charID;
        echo('<div style="margin-left: auto; margin-right: auto; padding-top: 0px;">
        <div style="display: inline-block; width:20%; text-align: center">');
        $this->getAttributes('Heavy Melee Fighters', $charID);
        $this->getAttributes('Light Melee Fighters', $charID);
        $this->getAttributes('Rogues/Rangers', $charID);
        $this->getAttributes('Ranged', $charID);
        $this->getAttributes('Engineering', $charID);
        $this->getAttributes('Weapon', $charID);
        echo('</div>');
        echo('<div style="display: inline-block; width:20%; text-align: center">');
        $this->getAttributes('Arcane', $charID);
        $this->getAttributes('Fire', $charID);
        $this->getAttributes('Frost', $charID);
        echo('</div>');
        echo('<div style="display: inline-block; width:20%; text-align: center">');
        $this->getAttributes('Shadow', $charID);
        $this->getAttributes('Necromancy', $charID);
        $this->getAttributes('Fel', $charID);
        echo('</div>');
        echo('<div style="display: inline-block; width:20%; text-align: center">');
        $this->getAttributes('Nature', $charID);
        echo('</div>');
        echo('<div style="display: inline-block; width:20%; text-align: center">');
        $this->getAttributes('Light', $charID);
        $this->getAttributes('Chi', $charID);
        $this->getAttributes('Shamanism', $charID);
        echo('</div>');
        echo('</div>');
    }
    
    function perkAvailable($new_perkID, $new_pp, $new_selected, $new_charID)
    {
        $perkID = $new_perkID;
        $pp = $new_pp;
        $selected = $new_selected;
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT COST FROM PERKS WHERE ID = ?');
        $stmt->execute([$perkID]);
        $cost = $stmt->fetchColumn();
        $charPerks = $this->getCharPerks($charID);
        
        // Set PD perk cost to 1 if CH and W are active
        if($perkID == 2 && in_array('1', $charPerks) && in_array('3', $charPerks))
        {
            $cost = 1;
        }
        // Set Fury perk cost to 1 if Fury and Berserking are active
        if($perkID == 12 && in_array('14', $charPerks))
        {
            $cost = 1;
        }
        // Set Berserking perk cost to 1 if Fury and Berserking are active
        if($perkID == 14 && in_array('12', $charPerks))
        {
            $cost = 1;
        }

        if ($cost>$pp && $selected != "checked ")
        {
            return "disabled";
        }
        //Limit perks to 4
        //elseif(count($this->getCharPerks($charID)) == 5 && $selected != "checked ")
        //{
        //    return "disabled";
        //}
        else
        {
            return "";
        }
    }
    
    function attributeAvailable($new_attributeID, $new_selected, $new_charID)
    {
        $attributeID = $new_attributeID;
        $selected = $new_selected;
        $charID = $new_charID;
        //if ($selected != "checked ")
        //{
        //    return "disabled";
        //}
        if($this->getCharAttribute($charID) != "" && $selected != "checked ")
        {
            return "disabled";
        }
        else
        {
            return "";
        }
    }
    
    function perkChecked($new_perkID, $new_charID)
    {
        $perkID = $new_perkID;
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT PERKS FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $perks = $stmt->fetchColumn();
        $perks = explode(",", $perks);
        $perks = array_filter($perks);
        if(in_array($perkID, $perks))
        {
            $selected = "checked ";
        }
        else
        {
            $selected = "";
        }
        $available = $this->perkAvailable($perkID, $this->ppLeft($charID), $selected, $charID);
        return $selected . $available;
    }

    function attributeChecked($new_attributeID, $new_charID)
    {
        $charID = $new_charID;
        $attributeID = $new_attributeID;
        $stmt = $this->db->prepare('SELECT ATTRIBUTE FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $attribute = $stmt->fetchColumn();

        if($attributeID == $attribute)
        {
            $selected = "checked ";
        }
        else
        {
            $selected = "";
        }
        $available = $this->attributeAvailable($attributeID, $selected, $charID);
        return $selected . $available;
    }
    
    function getCharPP($new_charID)
    {
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT RANK FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $rank = $stmt->fetchColumn();
        switch($rank)
        {
            case 4:
                $pp = 5;
                break;
            case 5:
                $pp = 4;
                break;
            case 6:
                $pp = 3;
                break;
            case 7:
                $pp = 2;
                break;
            case 8:
                $pp = 1;
                break;
            default:
                $pp = 0;
        }
        if($rank < 4)
        {
            $pp = 6;
        }

        return $pp;
    }
    
    function ppLeft($new_charID)
    {
        $charID = $new_charID;
        $perks = $this->getCharPerks($charID);
        $stmt = $this->db->prepare('SELECT * FROM PERKS');
        $stmt->execute();
        while ($row = $stmt->fetch())
		{
            $perklist[$row['ID']] = $row['COST'];
		}

        $pp = $this->getCharPP($charID);
        if(!empty($perks))
        {
            if(in_array('1', $perks) && in_array('3', $perks))
            {
                $perklist['2'] = 1;
            }
           // Set Fury perk cost to 1 if Fury and Berserking are active
            if(in_array('12', $perks) && in_array('14', $perks))
            {
                $perklist['12'] = 1;
            }
            // Set Berserking perk cost to 1 if Fury and Berserking are active
            if(in_array('12', $perks) && in_array('14', $perks))
            {
                $perklist['14'] = 1;
            }
        }
        if(!empty($perks))
        {
            while (list($key, $value) = each($perks))
            {
                $cost =  isset($perklist[$value]) ? $perklist[$value] : 0;
                $pp = $pp - $cost;
                unset($value);
                unset($cost);
            }
        }
        return $pp;
    }
    
    function getCharPerks($new_charID)
    {
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT PERKS FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $perks = $stmt->fetchColumn();
        $perks = explode(",", $perks);
        $perks = array_filter($perks);

        return $perks;
    }
    
    function getCharAttribute($new_charID)
    {
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT ATTRIBUTE FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $attribute = $stmt->fetchColumn();
        return $attribute;
    }
    
    function setPerks($new_perks, $new_charID)
    {	
        $perks = $new_perks;
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT USERID FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $userID = $stmt->fetchColumn();
        $stmt = $this->db->prepare('UPDATE USER_CHARACTER SET PERKS = ? WHERE  ID = ?');
        if($userID == $_SESSION['ID'])
        {
            $stmt->execute([$perks, $charID]);
        }
    }

    function setAttribute($new_attribute, $new_charID)
    {	
        $attribute = $new_attribute;
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT USERID FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $userID = $stmt->fetchColumn();
        $stmt = $this->db->prepare('UPDATE USER_CHARACTER SET ATTRIBUTE = ? WHERE  ID = ?');
        if($userID == $_SESSION['ID'])
        {
            $stmt->execute([$attribute, $charID]);
        }
    }
    
    //List user characters
    function listCharacters($id)
    {
        $listAll = false;
        if($id == "0")
        {
            $stmt = $this->db->prepare('SELECT * FROM USER_CHARACTER');
            $listAll = true;
            $stmt->execute();
        }
        else
        {
            $stmt = $this->db->prepare('SELECT * FROM USER_CHARACTER WHERE USERID = ?');
            $stmt->execute([$id]);
        }
        $characters = $stmt->fetchAll();
        if($characters)
        {
            echo ('
                <div style="width: 100%; color: black; text-align: left;">
                            <p style="text-align: left; display: inline-block; width: 33%;">Name</p>
                            <p style="text-align: left; display: inline-block; width: 30%;">Class</p>
                            <p style="text-align: left; display: inline-block; width: 33%;">Rank</p>
                </div>
                <div class="character_list">');
            foreach($characters as $character) {
            $name = utf8_encode($character['NAME']);
            $characterClass = utf8_encode($character['CHARACTER_CLASS']);
            $rank = $this->getRank($character['RANK']);
            $charID = $character['ID'];
            $this->printCharacterList($charID, $name, $characterClass, $rank, $listAll);
            }
            echo ('
                </div>');
            if(!$listAll)
            {
                echo('<br /><a href="/Character?addNew=true" class="char_info">Click here to add a new character.</a>');
            }
        }
        else
        {
            echo('<br /><a href="/Character?addNew=true" class="char_info">You have no characters, click here to add a new one.</a>');
        }
    }
    
    function printCharacterList($new_charID, $new_name, $new_characterClass, $new_rank, $new_listAll)
    {
        $charID = $new_charID;
        $name = $new_name;
        $characterClass = $new_characterClass;
        $rank = $new_rank;
        $listAll = $new_listAll;
        $stmt = $this->db->prepare('SELECT * FROM RANKS');
        $stmt->execute();
        if(!$listAll)
        {
            echo ('
                    <div>
                        <p style="text-align: left; display: inline-block; width: 33%;"">' . '<a href="/Character?ID=' . $charID . '">' . $name . '</a></p>
                        <p style="text-align: left; display: inline-block; width: 30%;"">' . $characterClass . '</p>
                        <p style="text-align: left; display: inline-block; width: 33%;"">' . $rank . '</p>
                    </div>');
        }
        else
        {
            echo ('
                    <div>
                        <p style="text-align: left; display: inline-block; width: 33%;"">' . '<a href="/Character?ID=' . $charID . '">' . $name . '</a></p>
                        <p style="text-align: left; display: inline-block; width: 30%;"">' . $characterClass . '</p>
                        <form style="width: 33%; display: inline-block;">
                        <p style="text-align: left; display: inline-block; width: 100%;""><select id="rank" name="rank" onchange="setRank(' . $charID . ', this.value)">');
            while($row = $stmt->fetch())
            {
                $alias = $row['NAME'];
                $id = $row['ID'];
                $selected = NULL;
                if($alias == $rank)
                {
                    $selected = 'selected="selected"';
                }
                    echo ('<option value="'. $id . '"' . $selected . '>' . $alias . '</option><br />');
            }
            echo('</select></p></form></div>');
        }
    }

    //Character rank stuff
    function getRank($id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM RANKS WHERE ID = ?');
        $stmt->execute([$id]);
        $rank = $stmt->fetchColumn();
		return $rank;
    }
    
    function setRank($new_rank, $new_charID)
    {	
        $rank = (int)$new_rank;
        $charID = $new_charID;
        $userID = $_SESSION['ID'];
        $stmt = $this->db->prepare('SELECT RANK FROM USER_CHARACTER WHERE USERID = ?');
        $stmt->execute([$userID]);
        $userRank = $stmt->fetchColumn();
        $stmt = $this->db->prepare('UPDATE USER_CHARACTER SET RANK = ? WHERE ID = ?');
        if($userRank < 3 && $userRank < $rank)
        {
            $stmt->execute([$rank, $charID]);
        }

    }
    
   // Basic character stuff
    function getCharName($id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn();
        $name = utf8_encode($name);
		return $name;
    }

    function getCharacterList()
    {
        $userID = $_SESSION['ID'];
        $charID = null;
        $charName = null;
        $out = null;
        $stmt = $this->db->prepare('SELECT * FROM USER_CHARACTER WHERE USERID = ?');
        $stmt->execute([$userID]);
        while($row = $stmt->fetch())
        {
            $charName = $row['NAME'];
            $charID = $row['ID'];
            $out = $out . '<option value="'. $charID . '">' . $charName . '</option><br />';
        }
        return $out;
    }
    
    function getCharacter($new_charID)
    {
        $charID = $new_charID;
        $stmt = $this->db->prepare('SELECT USERID FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $userID = $stmt->fetchColumn();
        echo '<div id="character_container">';
        if($userID == $_SESSION['ID'])
        {
            echo '<form method="post" action="./?action=editCharacter" enctype="multipart/form-data" style="height: inherit;"><input type="hidden" name="id" value="' . $charID . '">';
        }
        echo '<div id="left_col"><div id="char_image" style="background-image:url(\'' . $this->getCharacterAvatar($charID) . '\')">';
        echo '<input type="button" class="button" id="avatarButton" hidden value="Change avatar" onclick="document.getElementById(\'avatarFile\').click();" />';
        $this->getCharacterAvatar($charID);
        echo '</div><div class="char_info tablink tablink_active" onclick="openInfo(event, \'character_bio\');">';
        $this->getCharacterName($charID);
        echo '</div><div class="char_info">';
        $this->getCharacterRank($charID);
        echo '</div><div class="char_info">';
        echo '<textarea id="characterClass" name="characterClass" class="char_info" disabled maxlength="24">' . $this->getCharacterClass($charID) . '</textarea>';
        echo '</div><div id="char_attribute" class="tablink" onclick="openInfo(event, \'character_attributes\');">';
        $this->getCharacterAttribute($charID);
        echo '</div><div id="char_perks" class="tablink" onclick="openInfo(event, \'character_perks\');">';
        $this->getCharacterPerks($charID);
        echo '</div></div><div id="character_bio" class="page_content">';
        echo '<textarea id="characterBio" name="characterBio" disabled>' . $this->getCharacterBio($charID, true) . '</textarea>';
        if($userID == $_SESSION['ID'])
        {
            echo '<input type="file" name="fileToUpload" id="avatarFile" style="display: none;" disabled class="button">';
            echo '<input id="Edit_button" class="button" type="button" value="Edit" onclick="editCharacter();"/>';
            echo '<input id="Save_button" hidden style="float: right;" class="button" type="submit" value="Save"/>';
        }
        echo '</div><div id="character_perks" class="page_content">';
        $this->listPerks($charID);
        echo '</div><div id="character_attributes" class="page_content">';
        $this->listAttributes($charID);
        echo '</div>';
        if($userID == $_SESSION['ID'])
        {
            echo '</form>';
        }
        echo '</div>';
    }
    
    function getNewCharacterForm()
    {
        echo '<div id="character_container">';
        echo '<form method="post" action="./?action=addCharacter" enctype="multipart/form-data" style="height: inherit;">';
        echo '<div id="left_col"><div id="char_image" style="background-image:url(\'' . '/images?character_icon=noimage' . '\')">';
        echo '<input type="button" class="button" id="avatarButton" value="Add image" onclick="document.getElementById(\'avatarFile\').click();" />';
        echo '</div><div class="char_info tablink tablink_active">';
        echo '<textarea id="characterName" name="characterName" class="char_info" maxlength="24" autofocus placeholder="<<<<Character name>>>>"></textarea>';
        echo '</div><div class="char_info">';
        echo 'Rank will be set by Master';
        echo '</div><div class="char_info">';
        echo '<textarea id="characterClass" name="characterClass" class="char_info" maxlength="24" placeholder="<<<<Character class>>>>"></textarea>';
        echo '</div>';
        echo '</div><div id="character_bio" class="page_content">';
        echo '<textarea id="characterBio" name="characterBio" placeholder="<<<<Character bio>>>>"></textarea>';
        echo '<input type="file" name="fileToUpload" id="avatarFile" style="display: none;" class="button">';
        echo '<input id="Save_button" style="float: right;" class="button" type="submit" value="Save"/>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
    }
    
    function editCharacter($new_charID, $new_characterClass, $new_description)
    {
        $charID = stripslashes($new_charID);
        $characterClass = utf8_encode(stripslashes($new_characterClass));
        $description = utf8_encode(stripslashes($new_description));
        $stmt = $this->db->prepare('SELECT USERID FROM USER_CHARACTER WHERE ID = ?');
        $stmt->execute([$charID]);
        $userID = $stmt->fetchColumn();
        if($characterClass == "")
        {
            $characterClass = $character['CHARACTER_CLASS'];
        }
        
        if($description == "")
        {
            $description = $character['DESCRIPTION'];
        }
        
        $stmt = $this->db->prepare('UPDATE USER_CHARACTER SET CHARACTER_CLASS = ?, DESCRIPTION = ? WHERE  ID = ?');
        if($userID == $_SESSION['ID'])
        {
            $stmt->execute([$characterClass, $description, $charID]);
        }
    }
    
    function addCharacter($name, $characterClass, $description, $avatar)
    {
        $userID = $_SESSION['ID'];
        $name = utf8_encode(stripslashes($name));
        $characterClass = utf8_encode(stripslashes($characterClass));
        $description = utf8_encode(stripslashes($description));

        if($characterClass == "") {
            $characterClass = null;
        }
        
        if($description == "") {
            $description = null;
        }
        
        if($avatar == "") {
            $avatar = null;
        }
        
        $stmt = $this->db->prepare('INSERT INTO USER_CHARACTER (NAME, CHARACTER_CLASS, DESCRIPTION, AVATAR, USERID) VALUES (?, ?, ?, ?, ?)');
        if(isset($_SESSION['ID'])) {
            $stmt->execute([$name, $characterClass, $description, $avatar, $userID]);
        }
    }
}
?>
