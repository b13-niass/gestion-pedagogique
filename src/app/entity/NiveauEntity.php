<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class NiveauEntity extends Entity
{
    private int $id;
    private string $libelle;
    private string $created_at;
    private string $updated_at;
}