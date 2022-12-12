<?php
include_once "Database.php";
include_once "Equipe.php";
include_once "Poule.php";
class Tournoi
{
    private $id;
    private $nom;
    private $cashPrize;
    private $notoriete;
    private $lieu;
    private $heureDebut;
    private $date;
    private $dateLimiteInscription;
    private $poules = array();
    private $jeux = array();

    function __construct($id, $nom, $cashPrize, $notoriete, $lieu, $heureDateDebut, $idEtJeu){
        $this->id =$id;
        $this->nom = $nom;
        $this->cashPrize = $cashPrize;
        $this->notoriete = $notoriete;
        $this->lieu = $lieu;
        $this->heureDebut = date("h:m:s" ,strtotime($heureDateDebut));
        $this->date = date("d/m/y" ,strtotime($heureDateDebut));
        $this->poules = null;
        $this->jeux[$idEtJeu[0]] = $idEtJeu[1];
        $this->calculerDateLimite($heureDateDebut);
        $this->recupererPoules();

    }
    
    private function calculerDateLimite($heureDateDebut)
    {
        // on prend le numero de jours le plus grande entre les jeux de tournoi
        $maxJour = reset($this->jeux)->getlimiteInscription();
        foreach ($this->jeux as $jeu){
            $jours = $jeu->getlimiteInscription();
            if($maxJour > $jours){
                $maxJour = $jours;
            }
        }
        $datetime = date_create($heureDateDebut);
        $intervalJours = date_interval_create_from_date_string("$maxJour days");
        $this->dateLimiteInscription = date_format(date_sub($datetime,$intervalJours),"d/m/y");
    }
    private function recupererPoules()
    {
        $equipes = $this->lesEquipesParticipants();
        $this->poules = array();
        $mysql = Database::getInstance();
        $data = $mysql->select('*', 'Poule', 'where IdTournoi ='.$this->getIdTournoi());
        foreach($data as $ligne){
            $this->poules[$ligne['IdJeu']] = new Poule($ligne['IdPoule'], $ligne['NumeroPoule'], $ligne['EstPouleFinale'], $this->jeux[$ligne['IdJeu']]);
            $dataM = $mysql->select('*', 'MatchJ', 'where IdPoule ='.$ligne['IdPoule']);
            foreach($dataM as $ligneM){
                $this->poules[$ligne['IdJeu']]->addMatch($ligneM['Numero'], $ligneM['dateM'], $ligneM['HeureM'],$equipes);
            }
        }
    }
    public function toString()
    {
        return $this->heureDebut;
    }
    private function genererLesPoules(){
    }
    public function genererPouleFinale()
    {
    }
    private function meilleursEquipes()
    {
        return NULL;
    }
    private function miseAJourDePoints()
    {
    }
    public function getNom(){
        return $this->nom;
    }
    public function getNotoriete(){
        return $this->notoriete;
    }
    public function getLieu(){
        return $this->lieu;
    }
    public function getCashPrize(){
        return $this->cashPrize;
    }
    public function getDate(){
        return $this->date;
    }
    public function getHeureDebut(){
        return $this->heureDebut;
    }
    public function getJeux(){
        return $this->jeux;
    }

    public function __toString()
    {
        return $this->nom.' '.$this->cashPrize.'€ '.
        $this->notoriete.' '.
        $this->lieu.' '.
        $this->heureDebut.' '.
        $this->date;
    }

    public function listeInfo(){
        
        return array($this->nom,$this->cashPrize,$this->notoriete,$this->lieu,$this->heureDebut,$this->date,$this->dateLimiteInscription , $this->nomsJeux());
    }
    private function nomsJeux(){
        $nomjeux ="";
        foreach($this->jeux as $jeu){
            $nomjeux.=$jeu->getNom().', ';
        }
        $nomjeux = substr($nomjeux, 0, -2);
        return $nomjeux;

    }
    public function ajouterJeu($id,$jeu){
        $this->jeu[$id] = $jeu;
    }
    public function getIdTournoi(){
        return $this->id;
    }
    public function getDateLimiteInscription(){
        return $this->dateLimiteInscription;
    }

    public function contientJeu(Jeu $jeu){
        foreach($this->jeux as $j){
            if($j = $jeu){
                return true;
            }
        }
        return false;
    }

    public function lesEquipesParticipants(){
        $equipes = array();
        $mysql = Database::getInstance();
        $data = $mysql->select('*', 'Participer', 'where IdTournoi ='.$this->getIdTournoi());
        foreach($data as $ligne){
            $dataE = $mysql->select('*', 'Equipe e, Jeu j', 'where IdEquipe ='.$ligne['IdEquipe'].' AND j.IdJeu = e.IdJeu');
            foreach($dataE as $ligneM){
                $equipes[$ligneM['IdEquipe']] = new Equipe($ligneM['IdEquipe'], $ligneM['NomE'], $ligneM['NbPointsE'], $ligneM['IDEcurie'], 
                new Jeu($ligneM['IdJeu'],$ligneM['NomJeu'], $ligneM['TypeJeu'], $ligneM['TempsDeJeu'], $ligneM['DateLimiteInscription']));
            }
        }
        return $equipes;
    }
    public function getPoules(){
        return $this->poules;
    }
}

?>