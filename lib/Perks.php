<?php
namespace lib;

Class Perks
{
    protected $db;
    protected $perks;
    protected $attributes;
    protected $auras;
    
    public function __construct()
    {
        $this->db = new Database;
    }
    
    function updatePerks()
    {
        //<name><class/type><description><cost>
        $file = file($_SERVER['DOCUMENT_ROOT'] . '/tmp/perks.txt', FILE_IGNORE_NEW_LINES);
        $stmt = $this->db->prepare('UPDATE PERKS SET DESCRIPTION = ?, COST = ? WHERE NAME = ?');
        foreach($file as $key => $perk) {
            $this->perks[$key] = preg_split("/\<(.*?)\>/", $perk, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        }
        
        foreach($this->perks as $perk) {
            $stmt->execute([$perk['2'], $perk['3'], $perk['0']]);
        }
        
    }
    
   function updateAttributes()
    {
        //<class/type><name><description>
        $file = file($_SERVER['DOCUMENT_ROOT'] . '/tmp/attributes.txt', FILE_IGNORE_NEW_LINES);
        $stmt = $this->db->prepare('UPDATE ATTRIBUTES SET DESCRIPTION = ? WHERE NAME = ?');
        foreach($file as $key => $attribute) {
            $this->attributes[$key] = preg_split("/\<(.*?)\>/", $attribute, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        }
        
        foreach($this->attributes as $attribute) {
            $stmt->execute([$attribute['2'], $attribute['1']]);
        }
        
    }
    
   function updateAuras()
    {
        //<name><description>
        $file = file($_SERVER['DOCUMENT_ROOT'] . '/tmp/auras.txt', FILE_IGNORE_NEW_LINES);
        $stmt = $this->db->prepare('UPDATE AURAS SET DESCRIPTION = ? WHERE NAME = ?');
        foreach($file as $key => $aura) {
            $this->auras[$key] = preg_split("/\<(.*?)\>/", $aura, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        }
        
        foreach($this->auras as $aura) {
            $stmt->execute([$aura['1'], $aura['0']]);
        }
        
    }
}