<?php

namespace DrivingSchool\Database;

use PDO;
use PDOException;

/**
 * Database connection manager
 * 
 * Implements Singleton pattern for single connection
 * across the application with PDO dependency injection
 */
class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private ?PDO $connection = null;
    private array $config;

    /**
     * Private constructor for Singleton pattern
     * 
     * @param array $config Database configuration
     */
    private function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Gets connection instance (Singleton)
     * 
     * @param array $config Database configuration
     * @return DatabaseConnection
     */
    public static function getInstance(array $config): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * Establishes database connection
     * 
     * @return PDO PDO object for database communication
     * @throws PDOException On connection error
     */
    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $this->config['host'],
                $this->config['database']
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $options
            );
        }

        return $this->connection;
    }

    /**
     * Closes database connection
     */
    public function closeConnection(): void
    {
        $this->connection = null;
    }
}
