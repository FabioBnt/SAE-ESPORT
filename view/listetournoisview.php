<main>
    <div class="tournoismain">
        <h1>Liste des Tournois</h1>
        <div>
            <div>
                <p><b>Information :</b> Les points d'un tournoi sont donnés aux 4 premières équipes par Jeu et des
                    multiplicateurs sont associés en fonction de la notoriété. Le cashprize revient à la première équipe !
                </p>
            </div>
            <div>
                <h3> Filtre de recherche : </h3>
                <form action="./index.php?page=listetournoi" class="RechercheL" method="GET">
                    <input type="text" name="page" value="listetournoi" hidden>
                    Jeu : <label>
                        <input type="text" name="jeu" value="">
                    </label>
                    Nom : <label>
                        <input type="text" name="nom" value="">
                    </label>
                    Notoriété : <label>
                        <input type="text" name="Notoriety" value="">
                    </label>
                    Date : <label>
                        <input type="date" name="date" value="">
                    </label><br>
                    Lieu : <label>
                        <input type="text" name="lieu" value="">
                    </label>
                    PrixMin : <label>
                        <input type="number" name="prixmin" min="0">
                    </label>
                    PrixMax : <label><input type="number" name="prixmax" min="0"></label>
                    <input type="submit" value="Rénitialiser">
                    <input type="submit" value="Rechercher">
                </form>
            </div>
            <table>
                <thead>
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
                <?php foreach ($liste as $T){?>
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
    </div>
</main>
</body>
</html>