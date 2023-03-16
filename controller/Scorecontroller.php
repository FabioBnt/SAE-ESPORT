<?php
$connx = Connection::getInstance();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'score':
            function ScoreCodeReplacer($buffer)
            {
                $connx = Connection::getInstance();
                $codeToReplace = array('##TOURNAMENTNAME##', '##TOURNAMENTGAME##', '##BUTTONMODIFYSCORE##',
                    '##POULELISTIFEXIST##', '##CLASSEMENTIFFINALPOULE##', '##SCRIPTMODIFYSCORE##');
                $replacementCode = array('', '', '', '', '', '');
                $listePools = null;
                $nomTournoi = null;
                $nomJeu = null;
                $idJeu = null;
                if (isset($_GET['IDJ'])) {
                    $listePools = $_SESSION['game' . $_GET['IDJ']];
                    echo "<script>alert('listePools : " . $listePools . "');</script>";
                    $nomTournoi = $_GET['NomT'];
                    $nomJeu = $_GET['JeuT'];
                    $idJeu = $_GET['IDJ'];
                } else {
                    $listePools = array();
                    $nomTournoi = 'Inconnu';
                    $nomJeu = 'Jeu Inconnu';
                    $idJeu = null;
                }
                $replacementCode[0] = $nomTournoi;
                $replacementCode[1] = $nomJeu;
                $saisirScore = false;
                if ($connx->getRole() == Role::Arbitre && isset($listePools)) {
                    $PoolFinaleExiste = false;
                    foreach ($listePools as $Pool) {
                        if ($Pool->isPoolFinale()) {
                            $PoolFinaleExiste = true;
                            if (!$Pool->checkIfAllScoreSet()) {
                                $saisirScore = true;
                            }
                        }
                    }
                    if (!$PoolFinaleExiste) {
                        $saisirScore = true;
                    }
                }
                if ($saisirScore) {
                    $replacementCode[2] = '<a href="index.php?page=score&IDJ=' . $idJeu . '&NomT=' . $nomTournoi . '&JeuT=' . $nomJeu . '&Modify" class="buttonE" id="ModifS7">Modification</a>';
                }
                if  (isset($_GET['Modify']) && $saisirScore) {
                    $replacementCode[2] = '<a href="index.php?page=score&IDJ=' . $idJeu . '&NomT=' . $nomTournoi . '&JeuT=' . $nomJeu . '" class="buttonE" id="ModifS7">Terminer</a>';
                    $replacementCode[5] = '<script src="js/modifyScore.js"></script>';
                }
                $i = 0;
                $PoolF = null;
                if (!empty($listePools)) {
                    foreach ($listePools as $Pool) {
                        $i++;
                        $replacementCode[3] .= '<table id="tableS' . $i . '"><thead><tr><th colspan="4">Poule';
                        if ($i == 5) {
                            $replacementCode[3] .= 'Finale';
                            $PoolF = $Pool;
                        } else {
                            $replacementCode[3] .= $i;
                        }
                        // hidden id poule
                        $replacementCode[3] .= '<input class="pouleid" type="hidden" value="' . $Pool->getId() . '">';  
                        $replacementCode[3] .= '</th></tr><tr><th>Equipe 1</th><th>Score</th><th>Equipe 2</th><th>Score</th></tr></thead><tbody>';
                        foreach ($Pool->getMatchs() as $match) {
                            $replacementCode[3] .= '<tr>';
                            foreach ($match->getScores() as $key => $ligneValue) {
                                $equipe = $match->getEquipes()[$key];
                                $replacementCode[3] .= '<td>' . $equipe->getName() . '</td>';
                                $replacementCode[3] .= '<td id="'.$key.'" class="score">';
                                if ($ligneValue == null) {
                                    $replacementCode[3] .= 'TBD';
                                } else {
                                    $replacementCode[3] .= $ligneValue;
                                }
                                $replacementCode[3] .= '</td>';
                            }
                            $replacementCode[3] .= '</tr>';
                        }
                        $replacementCode[3] .= '</tbody></table>';
                    }
                } else {
                    $replacementCode[3] .= '<h2 class="buttonE" style="position: absolute; top: 85%; width: 80%; left: 50%;
                    transform: translate(-55%, -60%);"> Le tournoi n\'a pas encore commencé </h2>';
                }
                if ($PoolF != null) {
                    if ($PoolF->checkIfAllScoreSet()) {
                        $replacementCode[4] .= '<table id="tableS6"><thead><tr><th>Classement</th><th>Place</th></tr></thead><tbody>';
                        $i = 0;
                        foreach ($listePools as $Pool) {
                            $i++;
                            if ($i == 5) {
                                $p = $Pool->BestTeams();
                                $in = 1;
                                foreach ($p as $e) {
                                    $replacementCode[4] .= '<tr><td>' . $in . '</td><td>' . $e->getNom() . '</td></tr>';
                                    $in++;
                                }
                            }
                        }
                        $replacementCode[4] .= '</tbody></table>';
                    }
                }

                return (str_replace($codeToReplace, $replacementCode, $buffer));
            }
            // //uncomment to test
            // if(isset($_GET['test'])){
            //     Connection::getInstanceWithoutSession()->establishConnection('admin','$iutinfo',Role::Administrator);
            //     $tournoi = new Tournois();
            //     $pdo = DAO::getInstance()->getPDO();
            //     $pdo->beginTransaction();
            //     $idJeu = 8;
            //     $admin = new Administrator();
            //     $admin->creerTournoi('test',100,'Local','Toulouse','15:00','25/01/2023',array($idJeu));
            //     $id = $mysql->select('IdTournoi','Tournois','where NomTournoi = "test"');
            //     $tournoi->allTournaments();
            //     $t = $tournoi->getTournament($id[0]['IdTournoi']);
            //     Connection::getInstanceWithoutSession()->establishConnection('KCorpLoLCompte', 'PasswordKcorplol', Role::Equipe);
            //     $idE = $mysql->select('IdEquipe','Equipe','where IdJeu = '.$idJeu);
            //     $i = 0;
            //     $maxE = 16;
            //     if($_GET['test'] === '1'){
            //         $maxE = 14;
            //     }
            //     while($i < $maxE){
            //         $equipe = Equipe::getEquipe($idE[$i]['IdEquipe']);
            //         $equipe->Inscrire($t);
            //         $i++;
            //     }
            //     if($_GET['test'] === '1'){
            //         $t->genererLesPools($idJeu);
            //     }
            //     // if test = 2, on set les scores des matchs
            //     if($_GET['test'] === '2'){
            //         $Pools = $t->getPools()[$idJeu];
            //         foreach($Pools as $p){
            //             $matchs = $p->getMatchs();
            //             $j = 0;
            //             foreach($matchs as $m){
            //                 // keys of teams
            //                 $keys = array_keys($m->getEquipes());
            //                 MatchJ::setScore($Pools,$p->getId(),$keys[0],$keys[1],rand(0,$j+3),rand(0,$j+4));
            //                 $j++;
            //                 if ($j === 5) {
            //                     $Pools = $t->getPools()[$idJeu];
            //                 }
            //             }
            //         }
            //     }
            //     $listePools = $t->getPools();
            //     $nomTournoi = $t->getNom();
            //     $nomJeu = $t->getJeux()[$idJeu]->getNom();
            //     $pdo->rollBack();
            // }
            if (isset($_GET['valide'])) {
                echo '<script>alert("Score enregistré")</script>';
            }
            if (isset($_GET['erreur'])) {
                echo '<script>alert("Erreur lors de l\'enregistrement du score")</script>';
            }
            require_once('./view/headerview.html');
            ob_start('ScoreCodeReplacer');
            require_once('./view/scoreview.html');
            ob_end_flush();
            break;
        case 'saisirscore':
            $listePools = null;
            $nomTournoi = null;
            $nomJeu = null;
            $idJeu = null;
            if(isset($_GET['IDJ'])){
                $listePools = $_SESSION['jeu'.$_GET['IDJ']];
                $nomTournoi = $_GET['NomT'];
                $nomJeu = $_GET['JeuT'];
                $idJeu = $_GET['IDJ'];
            }else{
                $listePools = array();
                $nomTournoi = 'Inconnu';
                $nomJeu = 'Jeu Inconnu';
                $idJeu = null;
            }
            if(isset($_GET['score1']) && isset($_GET['score2'])){
                try{
                    MatchJ::setScore($listePools,$_GET['poule'],$_GET['equipe1'], $_GET['equipe2'], $_GET['score1'],$_GET['score2']);
                    $Tournament->allTournaments();
                    $idT = MatchJ::getIdTournamentByPool($_GET['poule']);
                    //vers DetailsTournoi.php?IDT=
                    header( 'Location:./index.php?page=score&IDT='.$idT.'&IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu);
                    exit();
                }catch(Exception $e){
                    // redirect vers la page de SaissirScore.php
                    header('Location:./score.php?IDJ='.$idJeu.'&NomT='.$nomTournoi.'&JeuT='.$nomJeu.'&erreur='.$e->getMessage());
                    exit();
                }
            }
            // si erreur
            if(isset($_GET['erreur'])){
                echo '<script>alert("'.$_GET['erreur'].'")</script>';
            }
            header('Location:index.php?page=listetournoi');
            break;
        default:
            require_once('./controller/Accueilcontroller.php');
            break;
    }
} else {
    require_once('./controller/Accueilcontroller.php');
}
?>