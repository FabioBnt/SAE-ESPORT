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
        $PoolF = null;
        if(array_key_exists("$idJeu",$listePools)){
            foreach ($listePools[$idJeu] as $Pool) {
                $i++;
                ?>
                <table id="tableS <?php echo $i; ?>"><thead><tr><th colspan="4">Poule
                <?php
                if($i==5){
                    echo'Finale';
                    $PoolF= $Pool;
                }else{echo $i;}; ?>
                </th></tr><tr><th>Equipe 1</th><th>Score</th><th>Equipe 2</th><th>Score</th></tr></thead><tbody>
                <?php foreach ($Pool->getMatchs() as $match){ ?>
                    <tr>
                    <?php foreach ($this->scores as $key => $ligneValue) {
                        $equipe = $this->equipes[$key]; ?>
                        <td><?php echo $equipe;?></td>
                        <?php if($ligneValue == null){ ?>
                            <td>TBD</td> 
                        <?php }else{ ?>
                            <td><?php echo $ligneValue;?></td> 
                        <?php }
                    } ?>
                    </tr> <?php
                } ?>
                </tbody></table>
            <?php }
        }else{ ?>
            <h2 class='buttonE' style='position: absolute; top: 85%; width: 80%; left: 50%;
            transform: translate(-55%, -60%);'> Le tournoi n'a pas encore commencé </h2>
        <?php }
        if($PoolF!=null){
            if($PoolF->checkIfAllScoreSet()){
                
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
            if(array_key_exists("$idJeu",$listePools)){
                foreach ($listePools[$idJeu] as $Pool) {
                    $i++;
                    if($i==5){
                        $p = $Pool -> BestTeams();
                        $in=1;
                        foreach($p as $e){ ?>
                            <tr>
                                <td><?php echo $in;?></td>
                                <td><?php echo $e->getNom();?></td>
                            </tr>
                            <?php $in++;
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