<?php
include_once "Equipe.php";
include_once "Poule.php";

function comparatorEquipe(Equipe $e1, Equipe $e2) {
    return ($e1->getPoints() > $e2->getPoints());
}
class Tournoi
{
    private $id;
    private $nom;
    private $cashPrize;
    private $notoriete;
    private $lieu;
    private $dateLimiteInscription;
    private $poules = null;
    private $jeux = array();
    private $dateHeure;

    public function __construct($id, $nom, $cashPrize, $notoriete, $lieu, $heureDateDebut, $idEtJeu){
        $this->id =$id;
        $this->nom = $nom;
        $this->cashPrize = $cashPrize;
        $this->notoriete = $notoriete;
        $this->lieu = $lieu;
        $this->dateHeure = $heureDateDebut;
        $this->poules = null;
        $this->jeux[$idEtJeu[0]] = $idEtJeu[1];
        $this->calculerDateLimite($heureDateDebut);
        $this->verifierPoules();

    }
    
    private function calculerDateLimite($heureDateDebut): void
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
    private function verifierPoules(): void{
        if(strtotime($this->getDateLimiteInscription()) > strtotime(date("Y/m/d")) && strtotime($this->dateHeure) < strtotime(date("Y/m/d"))){
            foreach($this->jeux as $jeu){
                if($this->numeroPoules($jeu->getId()) < 4){
                    $this->genererLesPoules($jeu->getId());
                }
            }
        }
    }
    private function recupererPoules(): void
    {
        $equipes = $this->lesEquipesParticipants();
        $this->poules = array();
        $mysql = Database::getInstance();
        $data = $mysql->select('*', 'Poule', 'where IdTournoi ='.$this->getIdTournoi());
        foreach($data as $ligne){
            $this->poules[$ligne['IdJeu']][$ligne['IdPoule']] = new Poule($ligne['IdPoule'], $ligne['NumeroPoule'], $ligne['EstPouleFinale'], $this->jeux[$ligne['IdJeu']]);
            $dataM = $mysql->select('*', 'MatchJ', 'where IdPoule ='.$ligne['IdPoule']);
            foreach($dataM as $ligneM){
                $this->poules[$ligne['IdJeu']][$ligne['IdPoule']]->addMatch($ligneM['Numero'], $ligneM['dateM'], $ligneM['HeureM'],$equipes);
            }
        }
    }
    public function toString()
    {
        return $this->getHeureDebut();
    }

    public function genererLesPoules($idJeu): void
    {
        if(!array_key_exists($idJeu, $this->jeux)){
            throw new Exception('Jeu n\'appartient pas au Tournois');
        }
        $equipes = $this->lesEquipesParticipants($idJeu);
        /*
        if(count($equipes) != 16){
            throw new Exception('Tournoi n\'a pas assez des participants');
        }
        
        if(strtotime($this->getDateLimiteInscription()) < strtotime(date("Y/m/d"))){
            throw new Exception('Inscriptions n\'est pas fermé');
        }
        */
        usort($equipes, 'comparatorEquipe');
        $mysql = Database::getInstance();
        for($i = 1; $i < 5; $i++ ){
            $mysql->Insert('Poule (NumeroPoule, EstPouleFinale, IdJeu, IdTournoi)', 4, array($i, 0, $idJeu, $this->id));
        }
        $data = $mysql->select('IdPoule','Poule ', 'where IdJeu ='.$idJeu.' AND IdTournoi = '.$this->id);
        $date = $this->dateHeure;
        for($i = 0; $i < 6 ; $i++){
            $n = $i + 1;
            foreach($data as $ligne){
                $mysql->Insert('MatchJ (IdPoule, Numero, dateM, HeureM)', 4, array($ligne['IdPoule'], $n, date("d/m/y" ,strtotime($date)), date("h:m:s" ,strtotime($date))));              
            }
            $date = date('Y-m-d H:i:s', strtotime($date. ' + '.$n.' hours'));
        }
        $i = 0;
        $equipesPoules = array();
        foreach($equipes as $equipe){
            $i %= 4;
            $mysql->Insert('`Faire_partie` (IdPoule, IdEquipe)', 2, array($data[$i]['IdPoule'], $equipe->getId()));
            $equipesPoules[$data[$i]['IdPoule']][] = $equipe->getId();
            $i++;
        }
        foreach($equipesPoules as $key => $value){
            $n = 1;
            while(count($value) < 4){
                $value[] = null;
            }
            if($value[0] && $value[1]){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[0], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[1], $key, $n, NULL));
                $n++;
            }
            if($value[0] && $value[2]){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[0], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[2], $key, $n, NULL));
                $n++;
            }
            if($value[0] && $value[3]){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[0], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[3], $key, $n, NULL));
                $n++;
            }
            if($value[1] && $value[2]){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[1], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[2], $key, $n, NULL));   
                $n++;
            }
            if($value[1] && $value[3]){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[1], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[3], $key, $n, NULL)); 
                $n++;
            }
            if($value[2] && $value[3]){
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[2], $key, $n, NULL));  
                $mysql->Insert('Concourir (IdEquipe, IdPoule, Numero, Score)',4, array($value[3], $key, $n, NULL));  
            }      
        }

    }
    public function genererPouleFinale($jeu)
    {
        // get the fisrt of every poule and then make the poule finale
        $equipes =  $this->meilleursEquipesPoulesNonFinale($jeu);
        $mysql = Database::getInstance();
        $mysql->Insert('Poule (NumeroPoule, EstPouleFinale, IdJeu, IdTournoi)', 4, array(5, 1, $jeu, $this->id));
        $data = $mysql->select('IdPoule','Poule ', 'where IdJeu ='.$jeu.' AND IdTournoi = '.$this->id);
        foreach($equipes as $equipe){
            $mysql->Insert('`Faire_partie` (IdPoule, IdEquipe)', 2, array($data[0]['IdPoule'], $equipe->getId()));
        }
        // TODO make the matchs of poule finale by dividing the teams in 2
        

    }
    private function meilleursEquipesPoulesNonFinale($jeu)
    {
        // get the fisrt of every poule
        $equipes = array();
        $poules = $this->getPoules($jeu);
        foreach($poules as $poule){
            $equipes[] = $poule->meilleurEquipe();
        }
        return $equipes;
    }
    private function miseAJourDePoints()
    {
        // TODO
        // update the points of every team
        //Combien de points gagne une équipe selon son classement  ?
        // multiplicateur local 1 national 2 inter 3 que sur poule finale 100 60 30 10 pour poule final 5 par match gagné 
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
        return date("d/m/y" ,strtotime($this->dateHeure));
    }
    public function getHeureDebut(){
        return date("h:m:s" ,strtotime($this->dateHeure));
    }
    public function getJeux(){
        return $this->jeux;
    }

    public function __toString()
    {
        return $this->nom.' '.$this->cashPrize.'€ '.
        $this->notoriete.' '.
        $this->lieu.' '.
        $this->getHeureDebut().' '.
        $this->getdate();
    }

    public function listeInfo(): array
    {
        
        return array($this->nom,$this->cashPrize,$this->notoriete,$this->lieu,$this->getHeureDebut(),$this->getDate(),$this->dateLimiteInscription , $this->nomsJeux());
    }
    private function nomsJeux(): string
    {
        $nomjeux ="";
        foreach($this->jeux as $jeu){
            $nomjeux.=$jeu->getNom().', ';
        }
        $nomjeux = substr($nomjeux, 0, -2);
        return $nomjeux;

    }
    public function ajouterJeu($id,$jeu){
        $this->jeux[$id] = $jeu;
    }
    public function getIdTournoi(){
        return $this->id;
    }
    public function getDateLimiteInscription(){
        return $this->dateLimiteInscription;
    }

    public function contientJeu(Jeu $jeu){
        foreach($this->jeux as $j){
            if($j == $jeu){
                return true;
            }
        }
        return false;
    }

    public function lesEquipesParticipants($idJeu = null){
        $equipes = array();
        $mysql = Database::getInstance();
        $data = $mysql->select('*', 'Participer', 'where IdTournoi ='.$this->getIdTournoi());
        if ($idJeu == null){
            foreach($data as $ligne){
                $dataE = $mysql->select('*', 'Equipe e, Jeu j', 'where IdEquipe ='.$ligne['IdEquipe'].' AND j.IdJeu = e.IdJeu');
                foreach($dataE as $ligneM){
                    $equipes[$ligneM['IdEquipe']] = new Equipe($ligneM['IdEquipe'], $ligneM['NomE'], $ligneM['NbPointsE'], $ligneM['IDEcurie'], 
                    new Jeu($ligneM['IdJeu'],$ligneM['NomJeu'], $ligneM['TypeJeu'], $ligneM['TempsDeJeu'], $ligneM['DateLimiteInscription']));
                }
            }
        }else{
            foreach($data as $ligne){
                $dataE = $mysql->select('*', 'Equipe e, Jeu j', 'where IdEquipe ='.$ligne['IdEquipe'].' AND j.IdJeu = e.IdJeu AND j.IdJeu='.$idJeu);
                foreach($dataE as $ligneM){
                    $equipes[$ligneM['IdEquipe']] = new Equipe($ligneM['IdEquipe'], $ligneM['NomE'], $ligneM['NbPointsE'], $ligneM['IDEcurie'], 
                    new Jeu($ligneM['IdJeu'],$ligneM['NomJeu'], $ligneM['TypeJeu'], $ligneM['TempsDeJeu'], $ligneM['DateLimiteInscription']));
                }
            }
        }
        return $equipes;
    }
    public function getPoules(){
        $this->poules = array();
        $this->recupererPoules();
        return $this->poules;
    }
    public function numeroParticipants($idJeu){
        $mysql = Database::getInstance();
        $data = $mysql->select('count(e.IdEquipe) as total', 'Participer p, Equipe e', 'where p.IdTournoi ='.$this->getIdTournoi().' AND e.IdEquipe = p.IdEquipe AND e.IdJeu = '.$idJeu);
        return($data[0]['total'] - '0');
    }
    public function numeroPoules($idJeu){
        $mysql = Database::getInstance();
        $totalPoules = $mysql->select("count(*) as total", "Poule", 'where IdTournoi = '.$this->getIdTournoi().'AND IdJeu = '.$idJeu);
        return $totalPoules[0]['total']-'0';
    }
}

?>