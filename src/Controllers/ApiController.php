<?php

namespace DrivingSchool\Controllers;

use DrivingSchool\Interfaces\DriveServiceInterface;
use DrivingSchool\Http\Request;
use DrivingSchool\Http\ApiResponse;

/**
 * API controller for HTTP request handling
 * 
 * Implements MVC pattern for presentation logic separation
 * from business logic and data access
 */
class ApiController
{
    private DriveServiceInterface $driveService;
    private Request $request;

    /**
     * Constructor with dependency injection
     * 
     * @param DriveServiceInterface $driveService Service for lesson handling
     * @param Request $request HTTP request object
     */
    public function __construct(DriveServiceInterface $driveService, Request $request)
    {
        $this->driveService = $driveService;
        $this->request = $request;
    }

    /**
     * Main method handling API requests
     * 
     * @return void
     */
    public function handleRequest(): void
    {
        // Set CORS headers
        $this->setCorsHeaders();
        
        // Set Content-Type header
        header('Content-Type: application/json; charset=utf-8');

        try {
            $method = $this->request->getMethod();
            $action = $this->request->get('action', '');

            switch ($method) {
                case 'GET':
                    if ($action === 'get') {
                        $this->handleGetDrives();
                    } else {
                        ApiResponse::send(ApiResponse::error('Invalid action', 400));
                    }
                    break;

                case 'POST':
                    if ($action === 'add') {
                        $this->handleAddDrive();
                    } else {
                        ApiResponse::send(ApiResponse::error('Invalid action', 400));
                    }
                    break;

                case 'DELETE':
                    if ($action === 'delete') {
                        $this->handleDeleteDrive();
                    } else {
                        ApiResponse::send(ApiResponse::error('Invalid action', 400));
                    }
                    break;

                default:
                    ApiResponse::send(ApiResponse::error('Unsupported HTTP method', 405));
                    break;
            }

        } catch (\Exception $e) {
            ApiResponse::send(ApiResponse::error('Server error: ' . $e->getMessage(), 500));
        }
    }

    /**
     * Handles GET request - retrieving lessons list
     * 
     * @return void
     */
    private function handleGetDrives(): void
    {
        $drives = $this->driveService->getAllDrives();
        
        // Frontend expects direct array of lessons, not object with status
        $response = array_map(function($drive) {
            return $drive->toArray();
        }, $drives);

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Handles POST request - adding new lesson
     * 
     * @return void
     */
    private function handleAddDrive(): void
    {
        $data = $this->request->getAllData();

        if (empty($data)) {
            ApiResponse::send(ApiResponse::error('Invalid JSON format', 400));
            return;
        }

        $result = $this->driveService->createDrive($data);

        if ($result['success']) {
            $response = [
                'status' => 'success',
                'data' => $result['data']
            ];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            ApiResponse::send(ApiResponse::error(implode(', ', $result['errors']), 400));
        }
    }

    /**
     * Handles DELETE request - removing lesson
     * 
     * @return void
     */
    private function handleDeleteDrive(): void
    {
        $id = $this->request->get('id');

        if (!$id || !is_numeric($id)) {
            ApiResponse::send(ApiResponse::error('Invalid lesson ID', 400));
            return;
        }

        $result = $this->driveService->deleteDrive((int)$id);

        if ($result['success']) {
            $response = [
                'status' => 'success',
                'message' => $result['message']
            ];
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            ApiResponse::send(ApiResponse::error(implode(', ', $result['errors']), 400));
        }
    }


    /**
     * Sets CORS headers
     * 
     * @return void
     */
    private function setCorsHeaders(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        // Handle preflight request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }
}
