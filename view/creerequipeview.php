<main>
        <div class="equipemain">
            <form action="./index.php?page=creerequipe" id="formeequipe" method="POST">
                <h1>Créer une équipe</h1>
                <div class="formulaire">
                    <label id="Eqforml1"><b>Nom de l'équipe</b></label>
                    <input id="Eqformi1" type="text" placeholder="Entrer le nom de l'équipe" name="name" required>
                    <label id="Eqforml2"><b>Nom du compte</b></label>
                    <input id="Eqformi2" type="text" placeholder="Entrer l'identifiant" name="username" required>
                    <label id="Eqforml3"><b>Mot de passe</b></label>
                    <input id="Eqformi3" type="password" placeholder="Entrer le mot de passe" name="password" required>
                    <label id="Eqforml4"><b>Jeu</b></label>
                    <select name="jeuE" id="Eqformt1">
                        <?php foreach($listeJeux as $jeu){ ?>
                        <option value="<?php $jeu->getId(); ?>"><?php echo $jeu->getName() ?></option>
                        <?php }?>
                    </select>
                    <table id="TabEquipeC">
                        <thead>
                            <tr>
                                <th>Pseudo</th>
                                <th>Nationalité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo1"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat1"></td>
                            </tr>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo2"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat2"></td>
                            </tr>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo3"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat3"></td>
                            </tr>
                            <tr>
                                <td><input placeholder="Anonyme" type="text" name="pseudo4"></td>
                                <td><input placeholder="FR, EN, DE etc" type="text" name="nat4"></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" class="buttonE" id="validerE" value='VALIDER' name="submit">
                    <input type="button" class="buttonE" id="annulerE" value='ANNULER' onclick="window.location.href='./index.php?page=accueil'">
                </div>
            </form>
        </div>
    </main>
</body>
</html>