<!--page accueil-->
    <main>
        <div class="mainA">
            <div class="titre">
                <h1> Gestionnaire d'une saison de compétition d'E-Sport </h1>
            </div>
            <div id="divbutton">
                <?php if($connx->getRole() == Role::Administrator){ ?>
                <button class="buttonM" onclick="window.location.href='./index.php?page=creertournoi'">Créer Tournoi</button>
                <?php } ?>
                <button class="buttonM" onclick="window.location.href='./index.php?page=listeequipe'">Liste des équipes</button>
                <?php if($connx->getRole() == Role::Administrator){ ?>
                <button class="buttonM" onclick="window.location.href='./index.php?page=creerecurie'">Créer Ecurie</button>
                <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>