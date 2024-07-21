<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class RpsEntity extends Entity
{
    private int $id;
    private int $utilisteur_id;
    private string $created_at;
    private string $updated_at;
}