<?php

namespace DrivingSchool\Interfaces;

use DrivingSchool\Models\Drive;

/**
 * Interface for driving lessons service
 * 
 * Defines contract for business logic related to lessons,
 * enabling easy testing and implementation swapping
 */
interface DriveServiceInterface
{
    /**
     * Gets all driving lessons
     * 
     * @return array List of Drive objects
     */
    public function getAllDrives(): array;

    /**
     * Gets driving lesson by ID
     * 
     * @param int $id Lesson ID
     * @return Drive|null Drive object or null if not found
     */
    public function getDriveById(int $id): ?Drive;

    /**
     * Creates new driving lesson with validation
     * 
     * @param array $data Lesson data
     * @return array Operation result with Drive object or errors
     */
    public function createDrive(array $data): array;

    /**
     * Deletes driving lesson by ID
     * 
     * @param int $id Lesson ID to delete
     * @return array Operation result
     */
    public function deleteDrive(int $id): array;
}
