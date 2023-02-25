    <main>
        <div class="detailsequipemain">
            <div class="Divdetails">
            <a href="javascript:history.go(-1)" class="buttonE">Retour</a>
                <h1>Détails d'une équipe</h1>
                <div class="gridDetails">
                    <div id="EDgridl1">
                    <label ><b>Nom de l'équipe</b></label>
                    <input type="text" name="nameE" value='<?php echo $Equipe->getName(); ?>' readonly>
                    </div>
                    <div id="EDgridl2">
                    <label ><b>Nom du Jeu</b></label>
                    <input type="text" name="jeu" value='<?php echo $Equipe->getGameName(); ?>' readonly>
                    </div>
                    <div id="EDgridl3">
                    <label><b>Nom de l'écurie</b></label>
                    <input type="text" name="OrganizationE" value='<?php echo $Equipe->getOrganization(); ?>' readonly>  
                    </div>
                    <div id="EDgridl5">
                    <label ><b>Nb Tournois Gagnés</b></label>
                    <input type="text" name="nbtg" value='<?php echo $Equipe->getNbmatchWin(); ?>' readonly>
                    </div>
                    <div id="EDgridl6">
                    <label ><b>Gains Totaux</b></label>
                    <input type="text" name="gt" value='<?php echo $Equipe->sumTournamentWin(); ?>€' readonly>
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
                            <?php 
                            if($data==null){
                                $i=0;
                                while($i<4){ ?>
                                <tr>
                                    <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                                    <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                                </tr>
                                <?php $i++;
                                } ;
                            }else{
                                $i=0;
                                foreach ($Joueurs as $J){?>
                                    <tr>
                                    <td><?php echo $J['Pseudo'];?></td>
                                    <td><?php echo $J['Nationalite'];?></td>
                                    </tr>
                                <?php $i++;
                                }
                                while($i<4){ ?>
                                    <tr>
                                        <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                                        <td><img class='imgB' src='./img/inconnu.png' alt='Rien'></td>
                                    </tr>
                                    <?php $i++;
                                };
                            }?>
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
                <?php foreach ($data as $T){?>
                    <tr>
                    <td><?php echo $T->getName();?></td>
                    <td><?php echo $T->getCashPrize();?></td>
                    <td><?php echo $T->getNotoriety();?></td>
                    <td><?php echo $T->getLocation();?></td>
                    <td><?php echo $T->getHourStart();?></td>
                    <td><?php echo $T->getDate();?></td>
                    <td><?php echo $T->getregisterDeadline();?></td>
                    <td><?php echo $T->namesgames();?></td>
                    <td><a href="./index.php?page=detailstournoi&IDT=<?php echo $T->getIdTournament()?>"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>