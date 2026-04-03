<?php

namespace App\Service;

class AnimalValidationService
{
    public function validateAnimal(array $data): array
    {
        $errors = [];
        $earTag = trim((string) ($data['earTag'] ?? ''));
        if ($earTag === '') {
            $errors['earTag'] = 'Ear tag is required.';
        } elseif (!ctype_digit($earTag) || (int) $earTag <= 0) {
            $errors['earTag'] = 'Ear tag must be a positive whole number.';
        }
        if (trim((string) ($data['type'] ?? '')) === '') {
            $errors['type'] = 'Please select a type.';
        }
        $weight = trim((string) ($data['weight'] ?? ''));
        if ($weight !== '' && !is_numeric($weight)) {
            $errors['weight'] = 'Weight must be a valid number.';
        } elseif ($weight !== '' && (float) $weight < 0) {
            $errors['weight'] = 'Weight cannot be negative.';
        }
        $birthDate = trim((string) ($data['birthDate'] ?? ''));
        $entryDate = trim((string) ($data['entryDate'] ?? ''));
        if ($birthDate !== '' && !$this->isValidDate($birthDate)) {
            $errors['birthDate'] = 'Birth date is invalid.';
        }
        if ($entryDate !== '' && !$this->isValidDate($entryDate)) {
            $errors['entryDate'] = 'Entry date is invalid.';
        }
        if ($birthDate !== '' && $this->isValidDate($birthDate) && $birthDate > date('Y-m-d')) {
            $errors['birthDate'] = 'Birth date cannot be in the future.';
        }
        if ($entryDate !== '' && $this->isValidDate($entryDate) && $entryDate > date('Y-m-d')) {
            $errors['entryDate'] = 'Entry date cannot be in the future.';
        }
        if ($birthDate !== '' && $entryDate !== '' && $this->isValidDate($birthDate) && $this->isValidDate($entryDate) && $entryDate < $birthDate) {
            $errors['entryDate'] = 'Entry date cannot be before birth date.';
        }
        if (trim((string) ($data['origin'] ?? '')) === '') {
            $errors['origin'] = 'Please select an origin.';
        }
        if (trim((string) ($data['location'] ?? '')) === '') {
            $errors['location'] = 'Please select a location.';
        }
        return $errors;
    }

    public function validateRecord(array $data): array
    {
        $errors = [];
        if (!$this->isValidDate((string) ($data['recordDate'] ?? ''))) {
            $errors['recordDate'] = 'Please select a valid record date.';
        }
        $weight = trim((string) ($data['weight'] ?? ''));
        if ($weight !== '' && !is_numeric($weight)) {
            $errors['weight'] = 'Invalid weight.';
        } elseif ($weight !== '' && (float) $weight < 0) {
            $errors['weight'] = 'Weight cannot be negative.';
        }
        if (trim((string) ($data['conditionStatus'] ?? '')) === '') {
            $errors['conditionStatus'] = 'Please select condition status.';
        }
        $production = trim((string) ($data['production'] ?? ''));
        if ($production !== '' && !is_numeric($production)) {
            $errors['production'] = 'Invalid production value.';
        } elseif ($production !== '' && (float) $production < 0) {
            $errors['production'] = 'Production cannot be negative.';
        }
        return $errors;
    }

    private function isValidDate(string $value): bool
    {
        if ($value === '') {
            return false;
        }
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        return $date instanceof \DateTimeImmutable && $date->format('Y-m-d') === $value;
    }
}
