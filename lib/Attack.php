<?php
namespace lib;

Class Attack
{
    protected $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
	function rollPoI()
	{
        $stmt = $this->db->prepare('SELECT * FROM POI WHERE ID <> 1');
        $stmt->execute();
		while ($row = $stmt->fetch())
		{
            $roll = mt_rand(1, 100);
            $poiZones[$row['ID']] = $row['ZONE'];
            $poiRolls[$row['ID']] = $roll;
		}
        $poiRolls = array_keys($poiRolls, max($poiRolls));
        while (list($key, $value) = each($poiRolls))
        {
            $poi[$value] = $poiZones[$value];
            unset($value);
        }
        $poi = array_unique($poi);
        while (list($key, $value) = each($poi))
        {
            $this->rollEnemy($key, $value);
            unset($value);
        }
	}
	
	function rollSelected($new_ID)
	{
        $stmt = $this->db->prepare('SELECT * FROM POI WHERE ID = ?');
        $stmt->execute([$new_ID]);
		while ($row = $stmt->fetch())
		{
            $this->rollEnemy($row['ID'], $row['ZONE']);
		}
	}

	function rollEnemy($new_poiID, $new_zoneID)
	{

        $stmt = $this->db->prepare('SELECT * FROM ENTITY WHERE ZONE = ?');
        $stmt->execute([$new_zoneID]);
        
		while ($row = $stmt->fetch())
		{
            $type[$row['ID']] = $row['TYPE'];
		}
        $type = array_unique($type);
        echo "<b>" . $this->getPoiName($new_poiID) . " in " . $this->getZoneName($new_zoneID) . "</b>";
        echo "<br />";
        while (list($key, $value) = each($type))
        {
            $roll = mt_rand(1, 100);
            if ($value == 74)
            {
                $typeRolled[$value] = $roll - 90;
            }
            else
            {
                $typeRolled[$value] = $roll;
            }
            unset($value);
        }
        $typeRolled = array_keys($typeRolled, max($typeRolled));
        echo "<b>Is under attack by: </b>";
        echo "<br />";
        $this->rollEnemyClass($typeRolled[0]);
        echo "<br />";
        echo "<br />";
	}

	function rollEnemyClass($new_TypeID)
	{
        $stmt = $this->db->prepare('SELECT * FROM ENTITY WHERE TYPE = ?');
        $stmt->execute([$new_TypeID]);
		while ($row = $stmt->fetch())
		{
            $class[$row['ID']] = $row['CLASS'];
		}
        $class = array_unique($class);
        while (list($key, $value) = each($class))
        {
            $roll = mt_rand(1, 5);
            $classRolled[$value] = $roll;
            unset($value);
        }
        $classRolled = array_keys($classRolled, max($classRolled));
        $enemycount = mt_rand(1, $this->getTypeThreat($new_TypeID)*10);
        while (list($key, $value) = each($classRolled))
        {
            if ($new_TypeID == 74)
            {
                echo "<b>" . " Secret encounter :) " ."</b>" . "<br />";
            }
            else
            {
                $roll = mt_rand(1, $enemycount);
                $enemycount = $enemycount - $roll;
                if ($enemycount == 0)
                {
                    $enemycount = 10;
                }
                echo "<b>" . $this->getTypeName($new_TypeID) . " - " . $this->getClassName($value) . " x " . ceil($enemycount/10) . "</b>" . "<br />";
            }
            unset($value);
        }
	}
    
    function getTypeThreat($new_id)
    {
        $stmt = $this->db->prepare('SELECT THREAT FROM ENTITY_TYPE WHERE ID = ?');
        $stmt->execute([$new_id]);
        return $stmt->fetchColumn();
    }
    
    function getZoneName($new_id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM ZONE WHERE ID = ?');
        $stmt->execute([$new_id]);
        return $stmt->fetchColumn();
    }
    
    function getTypeName($new_id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM ENTITY_TYPE WHERE ID = ?');
        $stmt->execute([$new_id]);
        return $stmt->fetchColumn();
    }
    
    function getClassName($new_id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM ENTITY_CLASS WHERE ID = ?');
        $stmt->execute([$new_id]);
        return $stmt->fetchColumn();
    }
    
    function getPoiName($new_id)
    {
        $stmt = $this->db->prepare('SELECT NAME FROM POI WHERE ID = ?');
        $stmt->execute([$new_id]);
        return $stmt->fetchColumn();
    }
}

?>