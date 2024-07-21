<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class ClasseEntity extends Entity
{
    private int $id;
    private string $libelle;
    private int $filiere_id;
    private int $niveau_id;
    private string $created_at;
    private string $updated_at;
}