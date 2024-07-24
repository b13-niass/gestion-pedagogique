<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class PresenceEntity extends Entity
{
    private int $id;
    private int $session_id;
    private int $etudiant_id;
    private string $created_at;
    private string $updated_at;
}