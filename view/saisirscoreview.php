<main class="scoredetails">
        <h1 id="labelS1">Saisie des scores du Tournoi <?php echo (string)$nomTournoi.'<br>'. (string)$nomJeu ?> </h1>
        <?php 
        $idJeu=null;
        if(array_key_exists("$idJeu",$listePools)){
        ?>
        <table id='saisirscore'>
            <tr><td colspan="2">Saisie des scores</td></tr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <div>
                <input type="hidden" name="page" value="<?php echo $page;?>"/>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <tr>
                <td><label for="poule">Numéro de la Poule</label></td>
                <td>
                <select name="poule"  onchange='this.form.submit()'>
                    <option default value="">--- Choisir numéro de la poule ---</option>
                    <?php 
                        foreach ($listePools[$idJeu] as $Pool) {
                            $text = "";
                            $num = $Pool->getNumero();
                            if($Pool->estPoolFinale()){
                                $text = "Finale";
                            }else{
                                $text = $num;
                            }
                            $temp = '';
                            if(isset($_GET['Pool'])){
                                if($_GET['Pool'] == $num){
                                    $temp = 'selected';
                                }
                            }
                            ?>
                            <option <?php echo $temp; ?> value="<?php echo $num; ?>"><?php echo $text; ?></option>
                    <?php
                        }
                    ?>
                </select>
                </td>
                </tr>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <?php if(isset($_GET['Pool'])){ ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
            <input type="hidden" name="page" value="<?php echo $page;?>"/>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <input type="hidden" name="poule" value="<?php echo $_GET['poule'];?>"/>
                <?php
                 $equipe1 = null;
                 if(isset($_GET['equipe1'])){
                     $equipe1 = $_GET['equipe1'];
                 }
                $equipe2 = null;
                if(isset($_GET['equipe2'])){
                    $equipe2 = $_GET['equipe2'];
                    ?>
                    <input type="hidden" name="equipe2" value="<?php echo $equipe2;?>"/>
                    <?php
                }
                ?>
                <tr>
                <td><label for="equipe1">Equipe 1</label></td>
                <td>
                <select name="equipe1" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Choisir l'équipe ---</option>
                    <?php 
                        foreach ($listePools[$idJeu] as $Pool) { 
                            if($Pool->getNumero() == $_GET['Pool']){
                                foreach($Pool->TeamsOfPool() as $equipe){
                                    $temp = '';
                                    if($equipe->getId() == $equipe1 ){
                                        $temp = 'selected';
                                    }
                                    if($equipe2 != $equipe->getId()){
                                        ?>
                                        <option <?php echo $temp; ?> value="<?php echo $equipe->getId(); ?>"><?php echo $equipe; ?></option>
                                        <?php
                                    }
                                }
                                break;
                            }
                        }
                    ?>
                </select>
                </td>
                </tr>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <input type="hidden" name="page" value="<?php echo $page;?>"/>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <input type="hidden" name="poule" value="<?php echo $_GET['poule'];?>"/>
                <?php
                $equipe1 = null;
                if(isset($_GET['equipe1'])){
                    $equipe1 = $_GET['equipe1'];
                    ?>
                    <input type="hidden" name="equipe1" value="<?php echo $equipe1;?>"/>
                    <?php
                }
                $equipe2 = null;
                if(isset($_GET['equipe2'])){
                    $equipe2 = $_GET['equipe2'];
                }
                ?>
                <tr>
                <td><label for="equipe2">Equipe 2</label></td>
                <td>
                <select name="equipe2" id="poule" onchange='this.form.submit()'>
                    <option default value="">--- Choisir l'équipe ---</option>
                    <?php 
                        foreach ($listePools[$idJeu] as $Pool) { 
                            if($Pool->getNumero() === $_GET['Pool']){
                                foreach($Pool->TeamsOfPool() as $equipe){
                                    $temp = '';
                                    if($equipe->getId() == $equipe2 ){
                                        $temp = 'selected';
                                    }
                                    if($equipe1 != $equipe->getId()){
                                        ?>
                                        <option <?php echo $temp; ?> value="<?php echo $equipe->getId(); ?>"><?php echo $equipe; ?></option>
                                        <?php
                                    }
                                }
                                break;
                            }
                        }
                    ?>
                </select>
                </td>
                </tr>
                <noscript><input type="submit" value="Submit"></noscript>
            </div>
        </form>
        <?php if(isset($_GET['equipe1']) && isset($_GET['equipe2'])){ ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <input type="hidden" name="page" value="<?php echo $page;?>"/>
                <input type="hidden" name="NomT" value="<?php echo $nomTournoi;?>"/>
                <input type="hidden" name="JeuT" value="<?php echo $nomJeu;?>"/>
                <input type="hidden" name="IDJ" value="<?php echo $idJeu;?>"/>
                <input type="hidden" name="poule" value="<?php echo $poule->getId();;?>"/>
                <input type="hidden" name="equipe1" value="<?php echo $_GET['equipe1'];?>"/>
                <input type="hidden" name="equipe2" value="<?php echo $_GET['equipe2'];?>"/>
                <tr>
                    <td>Score équipe 1:</td>
                    <td><input type="number" name="score1" min="0" required></td>
                </tr>
                <tr>
                    <td>Score équipe 2:</td>
                    <td><input type="number" name="score2" min="0" required></td>
                </tr>
                <tr>
                <?php }?>
                    <a href="javascript:history.go(-1)" class="buttonE">Retour</a>
                    <?php if(isset($_GET['equipe1']) && isset($_GET['equipe2'])){ ?>
                    <input  class="buttonE" type="submit" value="Valider">
                </tr>
            </div>
        </form>
        <?php }} 
        }else{?>
            <h2 class='buttonE' style='position: absolute; top: 85%; width: 80%; left: 50%;
            transform: translate(-55%, -60%);'> Le tournoi n\'a pas encore commencé </h2>
        <?php
        }
        ?>
    </main>
</body>
</html>