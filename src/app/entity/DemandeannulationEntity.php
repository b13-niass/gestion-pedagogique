<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class DemandeannulationEntity extends Entity
{
    private int $id;
    private string $justification;
    private int $session_id;
    private string $created_at;
    private string $updated_at;
}