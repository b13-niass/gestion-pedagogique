<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class EtudiantEntity extends Entity
{
    private int $id;
    private int $utilisateur_id;
    private int $classe_id;
    private string $created_at;
    private string $updated_at;
}