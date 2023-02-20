<main>
        <div class="tournoimain">
            <form action="./index.php?page=creertournoi" id="formetournoi" method="POST">
                <h1>Créer un tournoi</h1>
                <div class="formulaire">
                    <label id="Tforml1"><b>Nom du tournoi</b></label>
                    <input id="Tformi1" type="text" placeholder="Entrer le nom du tournoi" name="name" required>
                    <label id="Tforml2"><b>Date</b></label>
                    <input id="Tformi2" type="date" name="date" min="<?php echo $date; ?>" value="<?php echo $date; ?>" required>
                    <label id="Tforml3"><b>Heure</b></label>
                    <input id="Tformi3" type="time" name="heure" required>
                    <label id="Tforml4"><b>Lieu</b></label>
                    <input id="Tformi4" type="text" placeholder="Entrer le lieu" name="lieu" required>
                    <label id="Tforml5"><b>Cashprize</b></label>
                    <input id="Tformi5" type="number" placeholder="Entrer le montant du cashprize" name="cashprize" required>
                    <label id="Tforml6"><b>Notoriété</b></label>
                    <select id="Tformt1" name="typeT">
                        <option value="Local">Local</option>
                        <option value="Regional">Regional</option>
                        <option value="International">International</option>
                    </select>
                    <label id="Tformt2">Jeux</label>
                    <div id="jeux">
                        <?php foreach ($listeJeux as $jeu):?>
                            <!-- echo '<div><input type="checkbox" name="jeuT[]" value="' . $jeu->getId() . '"> ' . $jeu->getNom() . '</div>'; -->
                        <div><input type="checkbox" name="jeuT[]" value="' . <?php $jeu->getId() ?> . '"><?php echo $jeu->getNom()?> </div>
                        <?php endforeach;?>
                    </div>
                    <input type="submit" class="buttonE" id="validerT" value='VALIDER' name="submit">
                    <input type="button" class="buttonE" id="annulerT" value='ANNULER' onclick="window.location.href='./index.php?page=accueil'">
                </div>
            </form>
        </div>
    </main>
</body>

</html>