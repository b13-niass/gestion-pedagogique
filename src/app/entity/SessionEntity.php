<?php
namespace GPD\App\Entity;

use GPD\Core\Entity\Entity;

class SessionEntity extends Entity
{
    private int $id;
    private int $salle_id;
    private int $cour_id;
    private string $heureDebut;
    private string $heureFin;
    private string $etat_global;
    private string $etat_avancement;
    private string $date_session;
    private string $module_name;
    private string $presence="";
    private string $created_at;
    private string $updated_at;
}