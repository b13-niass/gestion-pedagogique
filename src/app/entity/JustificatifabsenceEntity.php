<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class JustificatifabsenceEntity extends Entity
{
    private int $id;
    private string $texte;
    private string $fichier;
    private int $session_id;
    private int $etudiant_id;
    private string $created_at;
    private string $updated_at;
}