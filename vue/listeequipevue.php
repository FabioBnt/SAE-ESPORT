
    <main>
        <div class="listeEquipemain">
            <div class="divEquip1">
                <?php if($connx->getRole() == Role::Ecurie):?>
                    <a href='./index.php?page=creerequipe' class='buttonE'>Créer Equipe</a>
            </div>
                <h1>Mes équipes</h1>
                <div>
                    <table id='TabEquipe'>
                        <thead>
                            <tr>
                                <th >Nom</th>
                                <th >Jeu</th>
                                <th >Plus dinformations</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listeE as $E):?>
                            <tr>
                                <td><?php echo $E->getNom();?></td>
                                <td><?php echo $E->getJeuN();?></td>
                                <td><a href="./index.php?page=detailsequipe&IDE=<?php echo $E->getId(); ?>"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            <?php endif;?>
            <h1>Liste des équipes</h1>
            <div>
                <table id="TabEquipe">
                    <thead>
                        <tr>
                            <th >Nom</th>
                            <th >Ecurie</th>
                            <th >Jeu</th>
                            <th >Plus d'informations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listeE2 as $E):?>
                            <tr>
                                <td><?php echo $E->getNom();?></td>
                                <td><?php echo $E->getEcurie();?></td>
                                <td><?php echo $E->getJeuN();?></td>
                                <td><a href="./index.php?page=detailsequipe&IDE=<?php echo $E->getId(); ?>"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>