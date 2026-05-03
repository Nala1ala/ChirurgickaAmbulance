<?php

/**
 * One specific medication with specific medicinal substance and form DTO
 */
class Medication
{
    private ?int $id; // Null -> autoincrement in database
    private string $name;
    private string $medicinalSubstance;
    private string $form;

    /**
     * New instance constructor
     * @param int|null $id Unique identifier
     * @param string $name Medication name
     * @param string $medicinalSubstance
     * @param string $form Tablets/injections/syrup/ointment/...
     */
    public function __construct(?int $id, string $name, string $medicinalSubstance, string $form) {
        $this->id = $id;
        $this->name = $name;
        $this->medicinalSubstance = $medicinalSubstance;
        $this->form = $form;
    }

    // Attribute getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getMedicinalSubstance(): string { return $this->medicinalSubstance; }
    public function getForm(): string { return $this->form; }
}