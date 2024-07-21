<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class SemestreanneeEntity extends Entity
{
    private int $id;
    private int $anneescolaire_id;
    private int $semestre_id;
    private string $created_at;
    private string $updated_at;
}