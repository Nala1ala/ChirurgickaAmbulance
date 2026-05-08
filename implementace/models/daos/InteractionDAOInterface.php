<?php

namespace app\models\daos;
use app\models\dtos\Interaction;

interface InteractionDAOInterface
{
    public function getInteractionsBySubstance(string $substanceName): array;
    public function insertInteraction(Interaction $interaction): bool;
}