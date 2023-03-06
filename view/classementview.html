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
                        <option value="<?php echo $jeu->getId(); ?>" <?php echo $selected; ?>><?php echo $jeu->getName(); ?></option>
                    <?php } ?>
                </select>
                <input class="buttonE" type="submit" value="Valider">
            </form>
            <?php if(isset($_GET['jeuC'])){?>
               <h1>Classement du jeu <?php echo Game::getGameById($_GET['jeuC'])->getName(); ?></h1>
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
                                    $equipe = new Team($equipe['IdEquipe'], $equipe['NomE'], $equipe['NbPointsE'], $equipe['IDEcurie'], $equipe['IdJeu']);
                                    ?>
                                    <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $equipe->getname(); ?></td>
                                    <td><?php echo $equipe->getPoints(); ?></td>
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