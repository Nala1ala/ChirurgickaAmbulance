<?php

namespace app\models\dtos;
/**
 * Medicinal substance interaction DTO
 */
class Interaction
{
    private string $queriedSubstance;
    private string $foundSubstance;
    private string $description;

    /**
     * New instance constructor
     * @param string $queriedSubstance Searched substance
     * @param string $foundSubstance Found substance
     * @param string $description Interaction description
     */
    public function __construct(string $queriedSubstance, string $foundSubstance, string $description)
    {
        $this->queriedSubstance = $queriedSubstance;
        $this->foundSubstance = $foundSubstance;
        $this->description = $description;
    }

    // Attribute getters
    public function getQueriedSubstance(): string
    {
        return $this->queriedSubstance;
    }

    public function getFoundSubstance(): string
    {
        return $this->foundSubstance;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}