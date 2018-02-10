<?php
namespace lib;

use PDO;

Class Database extends PDO
{
    protected $dsn;
    protected $opt;
    
    public function __construct()
    {
        require("config.php");
        //var_dump($config);
        extract($config);
        $this->dsn = "mysql:host=$dbhost;dbname=$dbname;charset=$charset";
        $this->opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        //var_dump($this->dsn);
        parent::__construct($this->dsn, $dbuser, $dbpasswd, $this->opt);
        
        return true;
    }
}
?>