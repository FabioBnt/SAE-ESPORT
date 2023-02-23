    <main>
        <div class="ecuriemain">
            <form action="./index.php?page=creerecurie" id="formecurie" method="POST">
                <h1>Créer une écurie</h1>
                <div class="formulaire">
                    <label id="Eforml1"><b>Nom de l'écurie</b></label>
                    <input id="Eformi1" type="text" placeholder="Entrer le nom d'écurie" name="name" required>
                    <label id="Eforml2"><b>Nom du compte</b></label>
                    <input id="Eformi2" type="text" placeholder="Entrer l'identifiant" name="username" required>
                    <label id="Eforml3"><b>Mot de passe</b></label>
                    <input id="Eformi3" type="password" placeholder="Entrer le mot de passe" name="password" required>
                    <label id="Eforml4"><b>Type</b></label>
                    <select id="Eformt1" name="typeE">
                	    <option value="Professionnelle">Professionnelle</option>
                        <option value="Associative">Associative</option>
                    </select>
                    <input type="submit" class="buttonE" id="valider" value='VALIDER' name="submit" >
                    <input type="button" class="buttonE" id="annuler" value='ANNULER' onclick="window.location.href='./index.php?page=accueil'" >
                </div>
            </form>
        </div>
    </main>
</html>