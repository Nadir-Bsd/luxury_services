<?php

namespace App\Services;

use App\Attribute\ProfileField;
use App\Entity\Candidate;
use App\Interfaces\ProfileProgressCalculatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;

class ProgressProfile implements ProfileProgressCalculatorInterface
{
    // the mapping is static because we want to keep the mapping in memory for all the instances of the class
    // foreach instance ($this->profileMappingCache) we get the mapping from the cache of the class (self::$profileMappingCache)
    // $this property of this instance,  
    private static array $profileMappingCache = [];
    private EntityManagerInterface $entityManager;
    private ReflectionClass $reflection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function calculateProgress(Candidate $candidate): int
    {
        // return the name of the class of the object
        $className = get_class($candidate);
        // make a reflection instance of the class Candidate to get the properties
        $this->reflection = new ReflectionClass($candidate);

        // Vérifier si le mapping des propriétés annotées par ProfileField est déjà en cache
        if (!isset(self::$profileMappingCache[$className])) {
            self::$profileMappingCache[$className] = $this->getProfileMapping();
        }

        // Récupérer le mapping des propriétés annotées par ProfileField
        $mapping = self::$profileMappingCache[$className];
        // set counter to 0
        $completedFields = 0;
        // set the total number of fields ou have ProfileField annotation to 0
        $totalFields = count($mapping);

        // foreach property in the mapping array
        foreach ($mapping as $propertyName) {
            // get the property value
            $propertyValue = $this->getPropertyValue($candidate, $propertyName);

            // check the different way of void value and if there is a value in it
            if ($this->isFieldCompleted($propertyValue)) {
                // if there is one increment the counter
                $completedFields++;
            }
        }

        // Avoid division by zero
        if ($totalFields === 0) {
            return 0;
        }

        // Calculer le pourcentage de complétion et l'arrondir
        $progressPercentage = ($completedFields / $totalFields) * 100;
        $progressPercentage = (int) round($progressPercentage);

        // update the property completion_percentage of the candidate
        $candidate->setCompletionPercentage($progressPercentage);
        $this->entityManager->persist($candidate);
        $this->entityManager->flush();

        return $progressPercentage;
    }

    /**
     * Récupérer le mapping des propriétés annotées par ProfileField
     */
    private function getProfileMapping(): array
    {
        $mapping = [];
        // check all properties of the class Candidate
        foreach ($this->reflection->getProperties() as $property) {
            // check if the property is annotated by ProfileField
            if ($this->isProfileField($property)) {
                // if yes, add the property name to the mapping array
                $mapping[] = $property->getName();
            }
        }
        return $mapping;
    }

    private function getPropertyValue(Candidate $candidate, string $propertyName)
    {
        // Utilisez des méthodes getter dynamique pour accéder aux valeurs des propriétés
        $getter = 'get' . ucfirst($propertyName);
        if (method_exists($candidate, $getter)) {
            return $candidate->$getter();
        }
        return null;
    }

    private function isFieldCompleted($value): bool
    {
        if ($value === null) {
            return false;
        }
        if (is_string($value) && trim($value) === '') {
            return false;
        }
        if (is_array($value) && empty($value)) {
            return false;
        }
        if ($value instanceof \Countable && count($value) === 0) {
            return false;
        }
        return true;
    }

    // check if the property is annotated by ProfileField
    private function isProfileField(\ReflectionProperty $property): bool
    {
        // get the attributes of the property in an array
        $attributes = $property->getAttributes(ProfileField::class);
        // if the array is not empty return true else return false
        // if the array is empty return false (because we switch the return value of empty function)
        return !empty($attributes);
    }
}