<?php

namespace DrivingSchool\Http;

/**
 * API response formatter
 * 
 * Centralizes JSON response creation logic,
 * ensuring format consistency across application
 */
class ApiResponse
{
    /**
     * Creates success response
     * 
     * @param mixed $data Data to return
     * @param string $message Success message
     * @param int $statusCode HTTP status code
     * @return array
     */
    public static function success($data = null, string $message = 'Success', int $statusCode = 200): array
    {
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ];
    }

    /**
     * Creates error response
     * 
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param array $errors Additional validation errors
     * @return array
     */
    public static function error(string $message, int $statusCode = 400, array $errors = []): array
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'status_code' => $statusCode
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return $response;
    }

    /**
     * Sends JSON response to client
     * 
     * @param array $response Response to send
     * @return void
     */
    public static function send(array $response): void
    {
        http_response_code($response['status_code']);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
