<?php

namespace DrivingSchool\Models;

/**
 * Driving lesson model
 * 
 * Contains data validation logic and mapping
 * between PHP object and database record
 */
class Drive
{
    private ?int $id;
    private string $lessonDate;
    private string $lessonTime;
    private string $instructorName;
    private string $studentName;

    /**
     * Drive model constructor
     * 
     * @param string $lessonDate Lesson date in YYYY-MM-DD format
     * @param string $lessonTime Lesson time in HH:MM format
     * @param string $instructorName Instructor full name
     * @param string $studentName Student full name
     * @param int|null $id Drive ID (optional for new records)
     */
    public function __construct(
        string $lessonDate,
        string $lessonTime,
        string $instructorName,
        string $studentName,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->lessonDate = $lessonDate;
        $this->lessonTime = $lessonTime;
        $this->instructorName = $instructorName;
        $this->studentName = $studentName;
    }

    /**
     * Creates Drive object from array data
     * 
     * @param array $data Database data
     * @return Drive
     */
    public static function fromArray(array $data): Drive
    {
        return new self(
            $data['lesson_date'],
            $data['lesson_time'],
            $data['instructor_name'],
            $data['student_name'],
            $data['id'] ?? null
        );
    }

    /**
     * Converts object to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->lessonDate,
            'time' => $this->lessonTime,
            'instructor' => $this->instructorName,
            'student' => $this->studentName,
        ];
    }


    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->lessonDate;
    }

    public function getTime(): string
    {
        return $this->lessonTime;
    }

    public function getInstructor(): string
    {
        return $this->instructorName;
    }

    public function getStudent(): string
    {
        return $this->studentName;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
