<?php

namespace DrivingSchool\Services;

use DrivingSchool\Models\Drive;
use DrivingSchool\Interfaces\DriveRepositoryInterface;
use DrivingSchool\Interfaces\DriveServiceInterface;
use DrivingSchool\Validation\DriveValidator;

/**
 * Service for driving lessons business logic
 * 
 * Implements Service Layer pattern for business logic separation
 * from data access layer and controllers
 */
class DriveService implements DriveServiceInterface
{
    private DriveRepositoryInterface $driveRepository;
    private DriveValidator $validator;

    /**
     * Constructor with dependency injection
     * 
     * @param DriveRepositoryInterface $driveRepository Repository for lesson operations
     * @param DriveValidator $validator Lesson data validator
     */
    public function __construct(DriveRepositoryInterface $driveRepository, DriveValidator $validator)
    {
        $this->driveRepository = $driveRepository;
        $this->validator = $validator;
    }

    /**
     * Gets all driving lessons
     * 
     * @return array List of Drive objects
     */
    public function getAllDrives(): array
    {
        return $this->driveRepository->findAll();
    }

    /**
     * Gets driving lesson by ID
     * 
     * @param int $id Lesson ID
     * @return Drive|null Drive object or null if not found
     */
    public function getDriveById(int $id): ?Drive
    {
        return $this->driveRepository->findById($id);
    }

    /**
     * Creates new driving lesson with validation
     * 
     * @param array $data Lesson data
     * @return array Operation result with Drive object or errors
     */
    public function createDrive(array $data): array
    {
        try {
            // Data validation
            $errors = $this->validator->validate($data);
            if (!empty($errors)) {
                return [
                    'success' => false,
                    'errors' => $errors
                ];
            }

            // Create Drive object from data
            $drive = new Drive(
                $data['date'],
                $data['time'],
                $data['instructor'],
                $data['student']
            );

            // Save to database
            $savedDrive = $this->driveRepository->save($drive);

            return [
                'success' => true,
                'data' => $savedDrive->toArray()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => ['Error saving lesson: ' . $e->getMessage()]
            ];
        }
    }

    /**
     * Deletes driving lesson by ID
     * 
     * @param int $id Lesson ID to delete
     * @return array Operation result
     */
    public function deleteDrive(int $id): array
    {
        try {
            // Check if lesson exists
            if (!$this->driveRepository->exists($id)) {
                return [
                    'success' => false,
                    'errors' => ['Lesson with given ID does not exist']
                ];
            }

            // Delete lesson
            $deleted = $this->driveRepository->delete($id);
            
            if (!$deleted) {
                return [
                    'success' => false,
                    'errors' => ['Failed to delete lesson']
                ];
            }

            return [
                'success' => true,
                'message' => 'Lesson successfully deleted'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => ['Error deleting lesson: ' . $e->getMessage()]
            ];
        }
    }
}
