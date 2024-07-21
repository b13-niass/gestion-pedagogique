<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class SalleEntity extends Entity
{
    private int $id;
    private string $nom;
    private string $numero;
    private int $nombre_de_place;
    private string $created_at;
    private string $updated_at;
}