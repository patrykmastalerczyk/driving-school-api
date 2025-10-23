<?php

namespace DrivingSchool\Container;

use DrivingSchool\Database\DatabaseConnection;
use DrivingSchool\Repositories\DriveRepository;
use DrivingSchool\Services\DriveService;
use DrivingSchool\Controllers\ApiController;
use DrivingSchool\Http\Request;
use DrivingSchool\Validation\DriveValidator;

/**
 * Dependency injection container
 * 
 * Implements Service Locator pattern for dependency management
 * in application following SOLID principles
 */
class ServiceContainer
{
    private array $services = [];
    private array $config;

    /**
     * Container constructor
     * 
     * @param array $config Application configuration
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Gets database instance
     * 
     * @return DatabaseConnection
     */
    public function getDatabase(): DatabaseConnection
    {
        if (!isset($this->services['database'])) {
            $this->services['database'] = DatabaseConnection::getInstance($this->config['database']);
        }

        return $this->services['database'];
    }

    /**
     * Gets lessons repository instance
     * 
     * @return DriveRepository
     */
    public function getDriveRepository(): DriveRepository
    {
        if (!isset($this->services['driveRepository'])) {
            $this->services['driveRepository'] = new DriveRepository(
                $this->getDatabase()->getConnection()
            );
        }

        return $this->services['driveRepository'];
    }

    /**
     * Gets lessons validator instance
     * 
     * @return DriveValidator
     */
    public function getDriveValidator(): DriveValidator
    {
        if (!isset($this->services['driveValidator'])) {
            $this->services['driveValidator'] = new DriveValidator();
        }

        return $this->services['driveValidator'];
    }

    /**
     * Gets lessons service instance
     * 
     * @return DriveService
     */
    public function getDriveService(): DriveService
    {
        if (!isset($this->services['driveService'])) {
            $this->services['driveService'] = new DriveService(
                $this->getDriveRepository(),
                $this->getDriveValidator()
            );
        }

        return $this->services['driveService'];
    }

    /**
     * Gets HTTP request instance
     * 
     * @return Request
     */
    public function getRequest(): Request
    {
        if (!isset($this->services['request'])) {
            $this->services['request'] = new Request();
        }

        return $this->services['request'];
    }

    /**
     * Gets API controller instance
     * 
     * @return ApiController
     */
    public function getApiController(): ApiController
    {
        if (!isset($this->services['apiController'])) {
            $this->services['apiController'] = new ApiController(
                $this->getDriveService(),
                $this->getRequest()
            );
        }

        return $this->services['apiController'];
    }
}
