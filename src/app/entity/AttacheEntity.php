<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class AttacheEntity extends Entity
{
    private int $id;
    private int $utilisateur_id;
    private string $created_at;
    private string $updated_at;
}