<main>
        <div class="classementmain">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="formClassement">
                <h1>Sélectionner un jeu</h1>
                <input type="hidden" name="page" value="<?php echo $page;?>"/>
                <select name="jeuC" id="Clformt1">
                    <?php
                    foreach ($listeJeux as $jeu) {
                        if (isset($_GET['jeuC']) && $_GET['jeuC'] == $jeu->getId()) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        ?>
                        <option value="<?php echo $jeu->getId(); ?>" <?php echo $selected; ?>><?php echo $jeu->getNom(); ?></option>
                    <?php } ?>
                </select>
                <input class="buttonE" type="submit" value="Valider">
            </form>
            <?php if(isset($_GET['jeuC'])){?>
               <h1>Classement du jeu <?php echo Game::getJeuById($_GET['jeuC'])->getNom(); ?></h1>
            <?php } ?>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Place</th>
                            <th>Nom</th>
                            <th>Nb de Points</th>
                            <th>Plus d'informations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(!empty($Classement)){
                                $i = 1;
                                foreach ($listeEquipes as $equipe) {
                                    $equipe = new Equipe($equipe['IdEquipe'], $equipe['NomE'], $equipe['NbPointsE'], $equipe['IDEcurie'], $equipe['IdJeu']);
                                    $infoEquipe = $equipe->listeInfoClassement();
                                    ?>
                                    <tr>
                                    <td><?php echo $i++; ?></td>
                                    <?php foreach ($infoEquipe as $colValue) { ?>
                                            <td><?php echo $colValue;?></td>
                                    <?php } ?>

                                    <td><a href='index.php?page=detailsequipe&IDE="<?php echo $equipe->getId(); ?>"'><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                                    </tr>
                        <?php   }
                            }
                         ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>