    <main>
        <div class="detailsequipemain">
            <div class="Divdetails">
            <a href="javascript:history.go(-1)" class="buttonE">Retour</a>
                <h1>Détails d'une équipe</h1>
                <div class="gridDetails">
                    <div id="EDgridl1">
                    <label ><b>Nom de l'équipe</b></label>
                    <input type="text" name="nameE" value='<?php echo $Equipe->getNom(); ?>' readonly>
                    </div>
                    <div id="EDgridl2">
                    <label ><b>Nom du Jeu</b></label>
                    <input type="text" name="jeu" value='<?php echo $Equipe->getJeuN(); ?>' readonly>
                    </div>
                    <div id="EDgridl3">
                    <label><b>Nom de l'écurie</b></label>
                    <input type="text" name="ecurieE" value='<?php echo $Equipe->getEcurie(); ?>' readonly>  
                    </div>
                    <div id="EDgridl5">
                    <label ><b>Nb Tournois Gagnés</b></label>
                    <input type="text" name="nbtg" value='<?php echo $Equipe->getNbmatchG(); ?>' readonly>
                    </div>
                    <div id="EDgridl6">
                    <label ><b>Gains Totaux</b></label>
                    <input type="text" name="gt" value='<?php echo $Equipe->SommeTournoiG(); ?>€' readonly>
                    </div>
                    <div id="EDgridl7">
                    <label ><b>Nb Points</b></label>
                    <input type="text" name="nbp" value='<?php echo $Equipe->getPoints(); ?>' readonly>
                    </div>
                    <div id="EDgridl4">
                    </div>
                    <table id="EDgridt1">
                        <thead>
                            <tr>
                                <th >Pseudo</th>
                                <th >Nationalité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Joueurs as $J):?>
                                <tr>
                                  <td><?php echo $J['Pseudo'];?></td>
                                  <td><?php echo $J['Nationalite'];?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tbody>
                            <?php
                            $mysql = DAO::getInstance();
                            $data = $mysql->select("Pseudo,Nationalite",
                             "Joueur J", "where J.IdEquipe= ".$idEquipe."");
                             if($data==Null){
                                $i=0;
                                while($i<4){
                                echo"<tr>";
                                echo "<td><img class='imgB' src='../img/inconnu.png' alt='Rien'></td>";
                                echo "<td><img class='imgB' src='../img/inconnu.png' alt='Rien'></td>";
                                echo "</tr>";
                                $i++;
                                } ;
                            }else {
                                    $ii=0;
                                    foreach($data as $j){
                                        echo "<tr>";
                                        echo "<td>".$j[0]."</td>";
                                        echo "<td>".$j[1]."</td>";
                                        echo "</tr>";
                                        $ii++;
                                    };
                                    while($ii<4){
                                        echo"<tr>";
                                        echo "<td><img class='imgB' src='../img/inconnu.png' alt='Rien'></td>";
                                        echo "<td><img class='imgB' src='../img/inconnu.png' alt='Rien'></td>";
                                        echo "</tr>";
                                        $ii++;
                                    };
                                };
                            ?>
                        </tbody>
                    </table>
                </div>
                <table>
                <thead>
                <tr><th colspan="9">Liste des Tournois Participés</th></tr>    
                <tr>
                    <th>Nom</th>
                    <th>CashPrize</th>
                    <th>Notoriété</th>
                    <th>Lieu</th>
                    <th>Heure de début</th>
                    <th>Date</th>
                    <th>Fin Inscription</th>
                    <th>Jeu</th>
                    <th>Plus d'info</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $listeTournois = new Tournois();
                $listeTournois->tournamentsParticipatedByTeam($idEquipe);?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>