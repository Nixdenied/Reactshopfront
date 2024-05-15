<?php

namespace App\Database;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database {
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;
    private string $port;
    private ?PDO $conn = null;

    /**
     * Database constructor.
     * Initializes environment variables and assigns them to class properties.
     */
    public function __construct() {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Assign environment variables to class properties
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
        $this->port = $_ENV['DB_PORT'];
    }

    /**
     * Establishes a connection to the database.
     *
     * @return PDO|null Returns a PDO instance on success or null on failure.
     */
    public function connect(): ?PDO {
        // Check if a connection already exists
        if ($this->conn === null) {
            try {
                // Data Source Name (DSN) for MySQL connection
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8";
                
                // Create a new PDO instance
                $this->conn = new PDO($dsn, $this->username, $this->password);
                
                // Set PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                // Log connection error and set connection to null
                error_log('Connection error: ' . $exception->getMessage());
                $this->conn = null;
            }
        }

        // Return the PDO instance or null if connection failed
        return $this->conn;
    }
}
