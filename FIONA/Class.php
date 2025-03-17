<?php
class Personne {
    public $id_pers;
    public $nom;

    public function __construct($id_pers, $nom) {
        $this->id_pers = $id_pers;
        $this->nom = $nom;
    }
}

class Lecteur extends Personne {
    public $adresse;
    public $email;

    public function __construct($id_pers, $nom, $adresse, $email) {
        parent::__construct($id_pers, $nom); 
        $this->adresse = $adresse;
        $this->email = $email;
    }

    public function emprunterLivre(Livres $livre, $dateEmprunt) {
        $emprunt = new Emprunt(uniqid(), $livre, $this, $dateEmprunt, null);
        return $emprunt;
    }

    public function retournerLivre(Emprunt $emprunt, $dateRetour) {
        $emprunt->dateRetour = $dateRetour;
        return $emprunt;
    }
}

class Auteur extends Personne {
    public $prenom;
    public $Datenaiss;

    public function __construct($id_pers, $nom, $prenom, $Datenaiss) {
        parent::__construct($id_pers, $nom); 
        $this->prenom = $prenom;
        $this->Datenaiss = $Datenaiss;
    }

    public function ecrireLivre($id_livre, $titre, $Datepub, $categorie) {
        return new Livres($id_livre, $titre, $Datepub, $categorie, $this);
    }
}

class Bibliothecaire extends Personne {
    public function __construct($id_pers, $nom) {
        parent::__construct($id_pers, $nom);
    }

    public function enregistrerEmprunt(Emprunt $emprunt) {
        return $emprunt;
    }

    public function enregistrerRetour(Emprunt $emprunt) {
        return $emprunt;
    }
}

class Livres {
    public $id_livre;
    public $titre;
    public $Datepub;
    public $categorie;
    public $auteur;

    public function __construct($id_livre, $titre, $Datepub, $categorie, Auteur $auteur) {
        $this->id_livre = $id_livre;
        $this->titre = $titre;
        $this->Datepub = $Datepub;
        $this->categorie = $categorie;
        $this->auteur = $auteur;
    }
}

class Emprunt {
    public $id_emprunt;
    public $livre;
    public $lecteur;
    public $dateEmprunt;
    public $dateRetour;

    public function __construct($id_emprunt, Livres $livre, Lecteur $lecteur, $dateEmprunt, $dateRetour) {
        $this->id_emprunt = $id_emprunt;
        $this->livre = $livre;
        $this->lecteur = $lecteur;
        $this->dateEmprunt = $dateEmprunt;
        $this->dateRetour = $dateRetour;
    }

}


$personne = new Personne(1, "Doe");
$auteur = new Auteur($personne->id_pers, $personne->nom, "John", "1980-01-01");
$livre = $auteur->ecrireLivre(101, "PHP for Beginners", "2023-10-01", "Programming");
echo "1. Une personne (" . $auteur->nom . " " . $auteur->prenom . ") écrit un livre et devient un auteur.<br>";
echo "   Livre écrit : " . $livre->titre . " (publié le " . $livre->Datepub . ").<br>";

// 2. Un lecteur qui emprunte un livre
$lecteur = new Lecteur(2, "Alice", "123 Main St", "alice@example.com");
$emprunt = $lecteur->emprunterLivre($livre, "2023-10-10");
echo "2. Un lecteur (" . $lecteur->nom . ") emprunte le livre : " . $emprunt->livre->titre . "<br>";
echo "   Date d'emprunt : " . $emprunt->dateEmprunt . "<br>";

// 3. Un lecteur qui retourne un livre
$lecteur->retournerLivre($emprunt, "2023-10-20");
echo "3. Le lecteur (" . $lecteur->nom . ") retourne le livre : " . $emprunt->livre->titre . "<br>";
echo "   Date de retour : " . $emprunt->dateRetour . "<br>";
?>