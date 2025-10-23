<?php

namespace DrivingSchool\Interfaces;

use DrivingSchool\Models\Drive;

/**
 * Interface for driving lessons repository
 * 
 * Defines contract for CRUD operations on lessons,
 * enabling easy testing and implementation swapping
 */
interface DriveRepositoryInterface
{
    /**
     * Gets all driving lessons from database
     * 
     * @return array List of Drive objects
     */
    public function findAll(): array;

    /**
     * Gets driving lesson by ID
     * 
     * @param int $id Lesson ID
     * @return Drive|null Drive object or null if not found
     */
    public function findById(int $id): ?Drive;

    /**
     * Saves new driving lesson to database
     * 
     * @param Drive $drive Drive object to save
     * @return Drive Drive object with assigned ID
     */
    public function save(Drive $drive): Drive;

    /**
     * Deletes driving lesson from database
     * 
     * @param int $id Lesson ID to delete
     * @return bool True if lesson was deleted
     */
    public function delete(int $id): bool;

    /**
     * Checks if lesson with given ID exists
     * 
     * @param int $id Lesson ID
     * @return bool True if lesson exists
     */
    public function exists(int $id): bool;
}
