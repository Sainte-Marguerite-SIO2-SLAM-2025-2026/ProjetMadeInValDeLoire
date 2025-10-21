<?php

namespace App\Models\salle_5;

use CodeIgniter\Model;

class ObjetModel extends Model
{
    function getObjet(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getResult();
        }
        return $result;
    }

    function getUsbFinance(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_finance")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getUsbRh(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_rh")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getUsbAno(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getBaieFermee(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "baie_fermee")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getBaieOuverte(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "baie_ouverte")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getBureau(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "bureau")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getCamera(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "camera")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getCarnet(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "carnet")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getCarnetMdp(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getClavier(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getCle(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getDossier(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcran(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranData(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranEteint1(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranEteint2(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranG1(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranG2(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranG3(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranVerouille(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranMail(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranVeille1(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranVeille2(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getEcranVeille3(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getFenetreFermee(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getFenetreOuverte(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getPorteFermee(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getPorteOuverte(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }

    function getPostItCode(int $numSalle){
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if($query->getNumRows() > 0){
            $result = $query->getRow();
        }
        return $result;
    }
    function getPostItConfidentiel(int $numSalle)
    {
        $result = false;
        $db = db_connect();
        $query = $db->table('objet')
            ->where('salle_numero', $numSalle)
            ->where('libelle', "usb_anonyme")
            ->get();
        if ($query->getNumRows() > 0) {
            $result = $query->getRow();
        }
        return $result;
    }
}