<?php

class Database {
    public $conn;

    /**
     * Constructor for the Database class
     * 
     * @param array $config
     * 
     */
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try{
            $this->conn = new PDO($dsn,$config['username'], $config['password'], $options);
            
        }catch(PDOException $err){
            throw new Exception("Database connection failed: {$err->getMessage()}");
        }
    }

    /**
     * Query the Database 
     * 
     * @param string $query
     * 
     * @return PDOStatement
     * @throws PDOException
     * 
     */
    public function query($query){
        try{
            $sth = $this->conn->prepare($query);
            $sth->execute();
            return $sth;
        }catch(PDOException $err){
            throw new Exception("Query failed to execute: {$err->getMessage()}");
        }
    }

}