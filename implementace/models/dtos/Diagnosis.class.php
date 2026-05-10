<?php

namespace app\models\dtos;
/**
 * Diagnosis (lookup table) DTO
 */
class Diagnosis
{
    private ?int $id; //Nullable -> autoincrement in database
    private string $name;

    /**
     * New instance constructor
     * @param int|null $id Diagnosis identifier
     * @param string $name
     */
    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    // Attribute getters
    /**
     * Gets the diagnosis identifier.
     * @return int|null Diagnosis identifier
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the diagnosis name.
     * @return string Diagnosis name
     */
    public function getName(): string
    {
        return $this->name;
    }
}
