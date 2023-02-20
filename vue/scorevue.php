<main class="scoredetails">
        <a href="javascript:history.go(-1)" class="buttonE" id="RetourS8">Retour</a>
        <h1 id="labelS1">Score du Tournoi <?php echo (string)$nomTournoi.'<br>'. (string)$nomJeu ?> </h1>
        <?php 
            if($saisirScore){
                ?>
                <a href="index.php?page=saisirscore&IDJ=<?php echo $idJeu;?>&NomT=<?php echo $nomTournoi ?>&JeuT=<?php echo $nomJeu;?>" class="buttonE" id="ModifS7">Modification</a>
                <?php
            }
        ?>
        <?php
        $i = 0;
        $pouleF = null;
        if(array_key_exists("$idJeu",$listePoules)){
            foreach ($listePoules[$idJeu] as $poule) {
                $i++;
                ?>
                <table id="tableS <?php echo $i; ?>"><thead><tr><th colspan="4">Poule
                <?php
                if($i==5){
                    echo'Finale';
                    $pouleF= $poule;
                }else{echo $i;};
                echo '</th></tr><tr><th>Equipe 1</th><th>Score</th><th>Equipe 2</th><th>Score</th></tr></thead><tbody>';
                foreach ($poule->getMatchs() as $match){
                    echo "<tr>";
                    foreach ($this->scores as $key => $ligneValue) {
                        $equipe = $this->equipes[$key];
                        echo "<td>", $equipe, "</td>";
                        if($ligneValue == null){
                            echo "<td>", 'TBD', "</td>"; 
                        }else{
                            echo "<td>", $ligneValue, "</td>"; 
                        }
                    }
                    echo "</tr>";
                }
                echo '</tbody></table>';
            }
        }else{
            echo '<h2 class=\'buttonE\' style=\'position: absolute; top: 85%; width: 80%; left: 50%;
            transform: translate(-55%, -60%);\'> Le tournoi n\'a pas encore commencé </h2>';
        }
        if($pouleF!=null){
            if($pouleF->checkIfAllScoreSet()){
                
        ?>
        <table id="tableS6">
            <thead>
                <tr>
                    <th>Classement</th>
                    <th>Place</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $i = 0;
            if(array_key_exists("$idJeu",$listePoules)){
                foreach ($listePoules[$idJeu] as $poule) {
                    $i++;
                    if($i==5){
                        $p = $poule -> meilleuresEquipes();
                        $in=1;
                        foreach($p as $e){
                            echo "<tr>";
                            echo "<td>$in</td>";
                            echo "<td>";
                            echo $e->getNom();
                            echo "</td>";
                            echo "</tr>";
                            $in++;
                        }
                    }
                }
            }
            }
            }
            ?>
            </tbody>
        </table>
    </main>
</body>
</html>