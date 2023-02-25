    <main>
        <div class="detailstournoimain">
            <div class="Divdetails">
                <h1>Détails d'un Tournoi</h1>
                <div class="gridDetails">
                    <label id="Dgridl1"><b>Nom du tournoi</b></label>
                    <input id="Dgridi1" type="text" name="nameT" value='<?php echo $tournoi->getName(); ?>' readonly>
                    <label id="Dgridl2"><b>Date du tournoi</b></label>
                    <input id="Dgridi2" type="text" name="dateT" value='<?php echo $tournoi->getDate(); ?>' readonly>
                    <label id="Dgridl3"><b>Heure du tournoi</b></label>
                    <input id="Dgridi3" type="text" name="heureT" value='<?php echo $tournoi->getHourStart(); ?>' readonly>
                    <label id="Dgridl4"><b>Lieu du tournoi</b></label>
                    <input id="Dgridi4" type="text" name="lieuT" value='<?php echo $tournoi->getLocation(); ?>' readonly>
                    <label id="Dgridl5"><b>CashPrize</b></label>
                    <input id="Dgridi5" type="text" name="cashprizeT" value='<?php echo $tournoi->getCashPrize(); ?>€' readonly>
                    <label id="Dgridl6"><b>Notoriété</b></label>
                    <input id="Dgridi6" type="text" name="NotorietyT" value='<?php echo $tournoi->getNotoriety(); ?>' readonly>
                    <table id="Dgridt1">
                        <thead>
                            <tr>
                                <th>Jeu</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tournoi->getGames() as $jeu){?>
                                <tr>
                                    <td><?php echo $jeu->getName() ?></td>
                                    <td><a href="./index.php?page=score&IDJ= <?php echo $jeu->getId(); ?> &NomT= <?php echo $tournoi->getName(); ?> &JeuT= <?php echo $jeu->getName(); ?>"><img src="./img/Detail.png" alt="Details" class="imgB"></a></td>
                                </tr>
                                <?php $_SESSION['jeu' . $jeu->getId()] = $PoolsJeux; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    if (!isset($_GET['inscrire'])) {
                        if ($connx->getRole() == Role::Team) {
                            if ($tournoi->haveGame($equipe->getGameId())) { ?>
                                <button class="buttonE" id="Dgrida1" onclick="confirmerInscription($idTournoi,$idEquipe)">S\'inscrire</button>
                            <?php }
                        }
                    }
                    ?>
                </div>
                <table id="Dgridt2">
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tournoi->TeamsOfPoolParticipants() as $participant) { ?>
                            <tr>
                                <td><?php echo $participant; ?></td>
                                <td><a href='./index.php?page=detailsequipe&IDE=<?php echo $participant->getId(); ?>'><img class='imgB' src='../img/detail.png' alt='Details'></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="./index.php?page=accueil" class="buttonE" id="Dgrida2">Retour</a>
            </div>
        </div>
        </div>
    </main>
    <script>
        function confirmerInscription(idt, ide) {
            if (confirm("Êtes vous sûr de vouloir vous inscrire?")) {
                window.location.assign("./DetailsTournoi.php?IDT=" + idt + "&inscrire=" + ide);
            }
        }
    </script>
    </body>
    </html>