<?php
class DataBase
{
    private $password;
    private $user;
    private $host;

    public function __construct($file)
    {
        $config = file($file);
        
        $this->host = trim($config[0]);
        $this->user = trim($config[1]);
        $this->password = trim($config[2]);
    }

    

    public function CONNECT()
    {
        try
        {
            $db = new PDO($this->host, $this->user, $this->password);
            return $db;
        } catch (PDOException $e) {
            echo "connessione non riuscito\n";
        }
    }
}
