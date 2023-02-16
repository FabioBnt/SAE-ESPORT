<?php
include_once "Equipe.php";
include_once "Poule.php";
include_once "Notoriete.php";
//comparateur d'équipe
function comparatorEquipe(Equipe $e1, Equipe $e2) {
    return ($e1->getPoints() > $e2->getPoints());
}
//créer un tournoi
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
    //constructeur

    /**
     * @throws Exception
     */
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
        
    }
    //calculer la date limite d'inscription
    private function calculerDateLimite($heureDateDebut): void
    {
        // on prend le numero de jours le plus grand entre les jeux de tournoi
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
    //vérifier la création des poules

    /**
     * @throws Exception
     */
    private function verifierPoules(): void{
        if(strtotime($this->getDateLimiteInscription()) > strtotime(date("Y/m/d")) && strtotime($this->dateHeure) < strtotime(date("Y/m/d"))){
            foreach($this->jeux as $jeu){
                if($this->numeroPoules($jeu->getId()) < 4){
                    $this->genererLesPoules($jeu->getId());
                }
            }
        }
    }
    //récupérer les poules du tournoi
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
    //récupérer l'heure de début du tournoi
    public function toString(): string
    {
        return $this->getHeureDebut();
    }
    //générer les poules d'un jeu dans le tournoi
    public function genererLesPoules($idJeu): void
    {
        if(!array_key_exists($idJeu, $this->jeux)){
            throw new Exception('Jeu n\'appartient pas au Tournois');
        }
        $equipes = $this->lesEquipesParticipants($idJeu);
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
        //insert les matchs
        $this->insertConcourir($equipesPoules);
    }
    //générer la poule finale
    public static function genererPouleFinale($idT, $idJeu): void
    {
        $tournoi = new Tournois();
        // tous les tournois
        $tournoi->tousLesTournois();
        $tournoi = $tournoi->getTournoi($idT);
        $equipes =  $tournoi->meilleursEquipesPoulesNonFinale($idJeu);
        $mysql = Database::getInstance();
        $mysql->Insert('Poule (NumeroPoule, EstPouleFinale, IdJeu, IdTournoi)', 4, array(5, 1, $idJeu, $idT));
        $data = $mysql->select('IdPoule','Poule', 'where NumeroPoule = 5 AND IdJeu = '.$idJeu.' AND IdTournoi = '.$idT);
        //date du jour
        $date = date("Y/m/d");
        for($i = 0; $i < 6 ; $i++){
            $n = $i + 1;
            foreach($data as $ligne){
                $mysql->Insert('MatchJ (IdPoule, Numero, dateM, HeureM)', 4, array($ligne['IdPoule'], $n, date("d/m/y" ,strtotime($date)), date("h:m:s" ,strtotime($date))));              
            }
            $date = date('Y-m-d H:i:s', strtotime($date. ' + '.$n.' hours'));
        }
        $equipesPoules = array();
        foreach($equipes as $equipe){
            $mysql->Insert('`Faire_partie` (IdPoule, IdEquipe)', 2, array($data[0]['IdPoule'], $equipe->getId()));
            $equipesPoules[$data[0]['IdPoule']][] = $equipe->getId();
        }
        //insert les matchs
        $tournoi->insertConcourir($equipesPoules);
    }
    // insert concourir fonction
    public function insertConcourir($equipesPoules){
        $mysql = Database::getInstance();
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
    //récupérer les meilleures équipe d'un jeu des poules (non finale)
    public function meilleursEquipesPoulesNonFinale($jeu)
    {
        $equipes = array();
        $poules = $this->getPoules()[$jeu];
        foreach($poules as $poule){
            $equipes[] = $poule->meilleureEquipe();
        }
        return $equipes;
    }
    //mettre a jour les points
    public static function miseAJourDePoints($idT, $idJ)
    {
        // multiplicateur local 1 national 2 inter 3 que sur poule finale 100 60 30 10 pour poule final 5 par match gagné 
        $tournoi = new Tournois();
        // tous les tournois
        $tournoi->tousLesTournois();
        $tournoi = $tournoi->getTournoi($idT);
        $poules = $tournoi->getPoules();
        $poules = $poules[$idJ];
        $equipes = array();
        $poulefin = array();
        foreach($poules as $poule){
            if($poule->estPouleFinale()){
                $poulefin = $poule;
                $equipes = $poule->classementEquipes();
            }
        }
        // ajouter equipe scores
        $mysql = Database::getInstance()->getPDO();
        // mettre a jour table Equipe set score
        // multiplicateur local 1 national 2 inter 3 que sur poule finale 100 60 30 10 pour poule final 5 par match gagné 
        $multiplicateur = 0;
        if($tournoi->getNotoriete() == Notoriete::Local){
            $multiplicateur = 1;
        }else if($tournoi->getNotoriete() == Notoriete::Regional){
            $multiplicateur = 2;
        }else if($tournoi->getNotoriete() == Notoriete::International){
            $multiplicateur = 3;
        }
        $i = 0;
        $scores = array(100, 60, 30, 10);
        foreach($equipes as $key => $value){
            $points = ($scores[$i] * $multiplicateur + 5 * $value);
            $equipes = $poulefin->lesEquipes();
            $equipe = $equipes[$key];
            if($equipe->getPoints() != null){
                $mysql->query('UPDATE Equipe SET NbPointsE = NbPointsE + '.$points.' WHERE IdEquipe = '.$key);
            }
            else{
                $mysql->query('UPDATE Equipe SET NbPointsE = '.$points.' WHERE IdEquipe = '.$key);
            }
            $i++;
            $i = $i % 4;
        }
    }
    //récupérer le nom du tournoi
    public function getNom(){
        return $this->nom;
    }
    //récupérer la notoriété du tournoi
    public function getNotoriete(){
        return $this->notoriete;
    }
    //récupérer le lieu du tournoi
    public function getLieu(){
        return $this->lieu;
    }
    //récupérer le cashprize du tournoi
    public function getCashPrize(){
        return $this->cashPrize;
    }
    //récupérer date heure
    public function getDateHeure(){
        return $this->dateHeure;
    }
    //récupérer la date du tournoi
    public function getDate(){
        return date("d/m/y" ,strtotime($this->dateHeure));
    }
    //récupérer l'heure du tournoi
    public function getHeureDebut(){
        $datetime = new DateTime($this->dateHeure);
        $datetime->setTimezone(new DateTimeZone('Europe/London'));
        return $datetime->format("H:i:s");
    }
    //récupérer les jeux du tournoi
    public function getJeux(){
        return $this->jeux;
    }
    //to string
    public function __toString()
    {
        return $this->nom.' '.$this->cashPrize.'€ '.
        $this->notoriete.' '.
        $this->lieu.' '.
        $this->getHeureDebut().' '.
        $this->getdate();
    }
    //récupérer la liste des infos du tournoi
    public function listeInfo(): array
    {
        return array($this->nom,$this->cashPrize."€",$this->notoriete,$this->lieu,$this->getHeureDebut(),$this->getDate(),$this->dateLimiteInscription , $this->nomsJeux());
    }
    //récupérer le nom des jeux
    private function nomsJeux(): string
    {
        $nomjeux ="";
        foreach($this->jeux as $jeu){
            $nomjeux.=$jeu->getNom().', ';
        }
        $nomjeux = substr($nomjeux, 0, -2);
        return $nomjeux;
    }
    //ajouter un jeu au tournoi
    public function ajouterJeu($id,$jeu){
        $this->jeux[$id] = $jeu;
    }
    //récupérer l'id du tournoi
    public function getIdTournoi(){
        return $this->id;
    }
    //récupérer la date limite d'inscription
    public function getDateLimiteInscription(){
        return $this->dateLimiteInscription;
    }
    //savoir si le tournoi contient un jeu
    public function contientJeu(Jeu $jeu){
        foreach($this->jeux as $j){
            if($j->getId() == $jeu->getId()){
                return true;
            }
        }
        return false;
    }
    //retourne les équipes participantes du tournoi
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
    //récupérer les poules
    public function getPoules(){
        $this->verifierPoules();
        $this->poules = array();
        $this->recupererPoules();
        return $this->poules;
    }
    //récupérer le nb de participants
    public function numeroParticipants($idJeu){
        $mysql = Database::getInstance();
        $data = $mysql->select('count(e.IdEquipe) as total', 'Participer p, Equipe e', 'where p.IdTournoi ='.$this->getIdTournoi().' AND e.IdEquipe = p.IdEquipe AND e.IdJeu = '.$idJeu);
        if(isset($data[0]) && $data[0] != null){
            return $data[0]['total']-'0';
        }else{
            return 0;
        }
    }
    //récupérer le numéro des poules d'un jeu
    public function numeroPoules($idJeu){
        $mysql = Database::getInstance();
        $totalPoules = $mysql->select("count(*) as total", "Poule", "where IdTournoi = ".$this->getIdTournoi()."AND IdJeu = ".$idJeu);
        if(isset($totalPoules[0]) && $totalPoules[0] != null){
            return $totalPoules[0]['total']-'0';
        }else{
            return 0;
        }
    }
    
}

?>