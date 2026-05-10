<?php

namespace app\models\daos;
use app\models\dtos\Interaction;

/**
 * Defines medicinal substance interaction persistence operations.
 */
interface InteractionDAOInterface
{
    /**
     * Gets interactions for a medicinal substance.
     * @param string $substanceName Substance name
     * @return Interaction[] Matching interactions
     */
    public function getInteractionsBySubstance(string $substanceName): array;

    /**
     * Saves a new medicinal substance interaction.
     * @param Interaction $interaction Interaction DTO
     * @return bool Saving successful?
     */
    public function insertInteraction(Interaction $interaction): bool;
}
