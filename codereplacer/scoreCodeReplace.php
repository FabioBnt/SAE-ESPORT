<?php
function scoreCodeReplace($buffer)
{
    $connx = Connection::getInstance();
    $codeToReplace = array(
        '##TOURNAMENTNAME##',
        '##TOURNAMENTGAME##',
        '##BUTTONMODIFYSCORE##',
        '##POULELISTIFEXIST##',
        '##CLASSEMENTIFFINALPOULE##',
        '##SCRIPTMODIFYSCORE##'
    );
    $replacementCode = array('', '', '', '', '', '');
    $listePools = null;
    $nomTournoi = null;
    $nomJeu = null;
    $idJeu = null;
    if (isset($_GET['IDJ'])) {
        $listePools = $_SESSION['game' . $_GET['IDJ']];
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
            if ($Pool->isPoolFinal()) {
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
    if (isset($_GET['Modify']) && $saisirScore) {
        $replacementCode[2] = '<a class="buttonE" id="ModifS7">Terminer</a>';
        $replacementCode[5] = '<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
        $replacementCode[5] .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>';
        $replacementCode[5] .= '<script src="./js/modifyScore.js"></script>';
        // add ajax script
    }
    $i = 0;
    $PoolF = null;
    if (!empty($listePools)) {
        foreach ($listePools as $Pool) {
            $i++;
            $replacementCode[3] .= '<table id="tableS' . $i . '" class="'.$Pool->getId().'"><thead><tr><th colspan="4">Poule';
            if ($i == 5) {
                $replacementCode[3] .= 'Finale';
                $PoolF = $Pool;
            } else {
                $replacementCode[3] .= $i;
            }
            // hidden id poule
            $replacementCode[3] .= '<div class="modifyScore" style="display: none;">';
            $replacementCode[3] .= $Pool->getId().'</div>';
            $replacementCode[3] .= '</th></tr><tr><th>Equipe 1</th><th>Score</th><th>Score</th><th>Equipe 2</th></tr></thead><tbody>';
            foreach ($Pool->getMatchs() as $match) {
                $replacementCode[3] .= '<tr>';
                $j = 0;
                foreach ($match->getScores() as $key => $ligneValue) {
                    $equipe = $match->getTeams()[$key];
                    $name = '<td>' . $equipe->getName() . '</td>';
                    $score = '<td id="' . $key . '" class="score">';
                    if ($ligneValue == null) {
                        $score .= 'TBD';
                    } else {
                        $replacementCode .= $ligneValue;
                    }
                    $score .= '</td>';
                    $j++;
                    $replacementCode[3] .= ($j % 2 == 1) ? $name.' '.$score : $score.' '.$name;
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
                    $p = $Pool->bestTeams();
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
?>