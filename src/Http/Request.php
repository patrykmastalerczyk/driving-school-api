<?php

namespace DrivingSchool\Http;

/**
 * HTTP request handler
 * 
 * Centralizes request data retrieval logic,
 * ensuring security and validation
 */
class Request
{
    private array $data;

    public function __construct()
    {
        $this->data = $this->parseRequestData();
    }

    /**
     * Gets HTTP method
     * 
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Gets URL parameter
     * 
     * @param string $key Parameter key
     * @param mixed $default Default value
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Gets data from request body
     * 
     * @param string $key Data key
     * @param mixed $default Default value
     * @return mixed
     */
    public function getData(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Gets all data from request body
     * 
     * @return array
     */
    public function getAllData(): array
    {
        return $this->data;
    }

    /**
     * Checks if request is POST
     * 
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    /**
     * Checks if request is GET
     * 
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->getMethod() === 'GET';
    }

    /**
     * Checks if request is DELETE
     * 
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->getMethod() === 'DELETE';
    }

    /**
     * Parses data from request body
     * 
     * @return array
     */
    private function parseRequestData(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            return is_array($data) ? $data : [];
        }
        
        return $_POST;
    }
}
