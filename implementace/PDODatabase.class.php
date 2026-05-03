<?php

/**
 * Database access singleton using PDO
 */
class PDODatabase
{
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $db   = 'chirurgicka_ambulance';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';

    /**
     * New instance constructor
     */
    private function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Vyhazuje výjimky při chybě
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Výchozí návrat dat jako asociativní pole
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Zvyšuje bezpečnost proti SQL injection
        ];

        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // V produkci je lepší logovat chybu a ukázat uživateli obecnou zprávu
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Instance cloning protection
     * @return void null
     */
    private function __clone() {}

    /**
     * Deserialization protection
     * @return mixed
     * @throws Exception singleton deserialization
     */
    public function __wakeup() {
        throw new Exception("Nelze deserializovat singleton.");
    }

    /**
     * Main instance access point
     * @return PDODatabase|null existing instance / new instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PDODatabase();
        }
        return self::$instance;
    }

    /**
     * Returns a PDO object providing access to the database
     * @return PDO connection point
     */
    public function getConnection() {
        return $this->connection;
    }
}
