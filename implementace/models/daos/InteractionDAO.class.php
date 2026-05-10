<?php
namespace app\models\daos;
use app\models\dtos\Interaction;
use PDO;
use app\models\PDODatabase;

/**
 * Data access object for medicinal substance interactions.
 */
class InteractionDAO implements InteractionDAOInterface {
    private PDO $db;

    /**
     * New instance initiator - requests database connection
     */
    public function __construct() {
        $this->db = PDODatabase::getInstance()->getConnection();
    }

    /**
     * Gets all substance's interactions
     * @param string $substanceName Searched substance
     * @return array of Interaction DTOs
     */
    public function getInteractionsBySubstance(string $substanceName): array {
        $sql = "SELECT * FROM interaction WHERE Queried_substance = :substance OR Found_substance = :substance";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':substance' => $substanceName]);

        $interactions = [];
        while ($row = $stmt->fetch()) {
            $interactions[] = new Interaction($row['Queried_substance'], $row['Found_substance'], $row['Description']);
        }
        return $interactions;
    }

    /**
     * Saves a substance's new interaction into the database
     * @param Interaction $interaction Interaction DTO
     * @return bool Insertion successful?
     */
    public function insertInteraction(Interaction $interaction): bool {
        $sql = "INSERT INTO interaction (Queried_substance, Found_substance, Description) 
                VALUES (:queried, :found, :desc)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':queried' => $interaction->getQueriedSubstance(),
            ':found' => $interaction->getFoundSubstance(),
            ':desc' => $interaction->getDescription()
        ]);
    }
}
