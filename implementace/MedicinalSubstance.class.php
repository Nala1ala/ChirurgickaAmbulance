<?php

/**
 * Medicinal substance DTO
 */
class MedicinalSubstance {
    private string $name;
    private string $category;

    /**
     * New instance constructor
     * @param string $name Substance name
     * @param string $category Medicinal category
     */
    public function __construct(string $name, string $category) {
        $this->name = $name;
        $this->category = $category;
    }

    // Attribute getters
    public function getName(): string { return $this->name; }
    public function getCategory(): string { return $this->category; }
}