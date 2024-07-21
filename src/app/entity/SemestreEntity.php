<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class SemestreEntity extends Entity
{
    private int $id;
    private string $libelle;
    private string $created_at;
    private string $updated_at;
}