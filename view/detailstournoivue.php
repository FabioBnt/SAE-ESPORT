    <main>
        <div class="detailstournoimain">
            <div class="Divdetails">
                <h1>Détails d'un Tournoi</h1>
                <div class="gridDetails">
                    <label id="Dgridl1"><b>Nom du tournoi</b></label>
                    <input id="Dgridi1" type="text" name="nameT" value='<?php echo $tournoi->getNom(); ?>' readonly>
                    <label id="Dgridl2"><b>Date du tournoi</b></label>
                    <input id="Dgridi2" type="text" name="dateT" value='<?php echo $tournoi->getDate(); ?>' readonly>
                    <label id="Dgridl3"><b>Heure du tournoi</b></label>
                    <input id="Dgridi3" type="text" name="heureT" value='<?php echo $tournoi->getHeureDebut(); ?>' readonly>
                    <label id="Dgridl4"><b>Lieu du tournoi</b></label>
                    <input id="Dgridi4" type="text" name="lieuT" value='<?php echo $tournoi->getLieu(); ?>' readonly>
                    <label id="Dgridl5"><b>CashPrize</b></label>
                    <input id="Dgridi5" type="text" name="cashprizeT" value='<?php echo $tournoi->getCashPrize(); ?>€' readonly>
                    <label id="Dgridl6"><b>Notoriété</b></label>
                    <input id="Dgridi6" type="text" name="notorieteT" value='<?php echo $tournoi->getNotoriete(); ?>' readonly>
                    <table id="Dgridt1">
                        <thead>
                            <tr>
                                <th>Jeu</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tournoi->getJeux() as $jeu) : ?>
                                <tr>
                                    <td><?php echo $jeu->getNom() ?></td>
                                    <td><a href="./index.php?page=score&IDJ= <?php echo $jeu->getId(); ?> &NomT= <?php echo $tournoi->getNom(); ?> &JeuT= <?php echo $jeu->getNom(); ?>"><img src="./img/Detail.png" alt="Details" class="imgB"></a></td>
                                </tr>
                                <?php $_SESSION['jeu' . $jeu->getId()] = $poulesJeux; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    if (!isset($_GET['inscrire'])) {
                        if ($connx->getRole() == Role::Equipe) {
                            $nomCompteEquipe = $connx->getIdentifiant();
                            $idEquipe = $mysql->select('E.IdEquipe', 'Equipe E', 'where E.NomCompte = ' . "'$nomCompteEquipe'");
                            $equipe = Equipe::getEquipe($idEquipe[0]['IdEquipe']);
                            if ($tournoi->contientJeu($equipe->getJeu())) {
                                echo '<button class="buttonE" id="Dgrida1" onclick="confirmerInscription(' . $idTournoi . ', ' . $idEquipe[0]['IdEquipe'] . ')">S\'inscrire</button>';
                            }
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
                        <?php foreach ($tournoi->lesEquipesParticipants() as $participant) {
                            echo '<tr><td>' . $participant . '</td>';
                            echo "<td><a href='DetailsEquipe.php?IDE=" . $participant->getId() . "'><img class='imgB' src='../img/detail.png' alt='Details'></a></td></tr>";
                        } ?>
                    </tbody>
                </table>
                <a href="javascript:history.go(-1)" class="buttonE" id="Dgrida2">Retour</a>
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