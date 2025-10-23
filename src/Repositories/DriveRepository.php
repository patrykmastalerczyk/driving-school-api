<?php

namespace DrivingSchool\Repositories;

use PDO;
use DrivingSchool\Models\Drive;
use DrivingSchool\Interfaces\DriveRepositoryInterface;

/**
 * Repository for driving lessons CRUD operations
 * 
 * Implements Repository pattern for data access logic separation
 * from business logic
 */
class DriveRepository implements DriveRepositoryInterface
{
    private PDO $connection;

    /**
     * Constructor with dependency injection
     * 
     * @param PDO $connection Database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Gets all driving lessons from database
     * 
     * @return array List of Drive objects
     */
    public function findAll(): array
    {
        $sql = "SELECT id, lesson_date, lesson_time, instructor_name, student_name FROM drives ORDER BY lesson_date ASC, lesson_time ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $drives = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $drives[] = Drive::fromArray($row);
        }

        return $drives;
    }

    /**
     * Gets driving lesson by ID
     * 
     * @param int $id Lesson ID
     * @return Drive|null Drive object or null if not found
     */
    public function findById(int $id): ?Drive
    {
        $sql = "SELECT id, lesson_date, lesson_time, instructor_name, student_name FROM drives WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? Drive::fromArray($row) : null;
    }

    /**
     * Saves new driving lesson to database
     * 
     * @param Drive $drive Drive object to save
     * @return Drive Drive object with assigned ID
     * @throws \PDOException On save error
     */
    public function save(Drive $drive): Drive
    {
        $sql = "INSERT INTO drives (lesson_date, lesson_time, instructor_name, student_name) VALUES (:lesson_date, :lesson_time, :instructor_name, :student_name)";
        $stmt = $this->connection->prepare($sql);
        
        $lessonDate = $drive->getDate();
        $lessonTime = $drive->getTime();
        $instructorName = $drive->getInstructor();
        $studentName = $drive->getStudent();
        
        $stmt->bindParam(':lesson_date', $lessonDate);
        $stmt->bindParam(':lesson_time', $lessonTime);
        $stmt->bindParam(':instructor_name', $instructorName);
        $stmt->bindParam(':student_name', $studentName);
        
        $stmt->execute();

        $drive->setId((int)$this->connection->lastInsertId());
        return $drive;
    }

    /**
     * Deletes driving lesson from database
     * 
     * @param int $id Lesson ID to delete
     * @return bool True if lesson was deleted, false if not found
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM drives WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Checks if lesson with given ID exists
     * 
     * @param int $id Lesson ID
     * @return bool True if lesson exists
     */
    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) FROM drives WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
}
