<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class CourEntity extends Entity
{
    private int $id;
    private string $intitule;
    private string $heureGlobale;
    private int $professeur_id;
    private int $semestreannee_id;
    private int $module_id;
    private string $created_at;
    private string $updated_at;
}