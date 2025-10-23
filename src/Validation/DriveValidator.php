<?php

namespace DrivingSchool\Validation;

use DrivingSchool\Models\Drive;

/**
 * Class responsible for driving lesson data validation
 * 
 * Centralizes validation logic, enabling
 * easy testing and rule extension
 */
class DriveValidator
{
    /**
     * Validates driving lesson data
     * 
     * @param array $data Data to validate
     * @return array List of validation errors
     */
    public function validate(array $data): array
    {
        $errors = [];

        // Date validation
        if (empty($data['date'])) {
            $errors[] = 'Lesson date is required';
        } elseif (!$this->isValidDate($data['date'])) {
            $errors[] = 'Invalid date format';
        } elseif (!$this->isFutureDate($data['date'])) {
            $errors[] = 'Lesson date must be in the future';
        }

        // Time validation
        if (empty($data['time'])) {
            $errors[] = 'Lesson time is required';
        } elseif (!$this->isValidTime($data['time'])) {
            $errors[] = 'Invalid time format';
        }

        // Instructor validation
        if (empty($data['instructor'])) {
            $errors[] = 'Instructor name is required';
        } elseif (!$this->isValidName($data['instructor'])) {
            $errors[] = 'Instructor name can only contain letters, spaces and hyphens';
        }

        // Student validation
        if (empty($data['student'])) {
            $errors[] = 'Student name is required';
        } elseif (!$this->isValidName($data['student'])) {
            $errors[] = 'Student name can only contain letters, spaces and hyphens';
        }

        return $errors;
    }

    /**
     * Checks if date has valid format
     * 
     * @param string $date Date to check
     * @return bool
     */
    private function isValidDate(string $date): bool
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * Checks if date is in the future
     * 
     * @param string $date Date to check
     * @return bool
     */
    private function isFutureDate(string $date): bool
    {
        $driveDate = new \DateTime($date);
        $today = new \DateTime('today');
        return $driveDate >= $today;
    }

    /**
     * Checks if time has valid format
     * 
     * @param string $time Time to check
     * @return bool
     */
    private function isValidTime(string $time): bool
    {
        return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time) === 1;
    }

    /**
     * Checks if name contains only allowed characters
     * 
     * @param string $name Name to check
     * @return bool
     */
    private function isValidName(string $name): bool
    {
        return preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s\-]+$/u', $name) === 1;
    }
}
