<?php
function tournamentCodeReplace($buffer)
{
    $Tournament = new Tournament();
    $codeToReplace = array('##FOREACH TOURNAMENT##');
    $replacementCode = array('');
    $liste = $Tournament->allTournaments();
    if (
        isset($_GET['jeu']) || isset($_GET['nom']) || isset($_GET['prixmin']) || isset($_GET['prixmax'])
        || isset($_GET['Notoriety']) || isset($_GET['lieu']) || isset($_GET['date'])
    ) {
        // if not empty value of the input else null
        $jeu = !empty($_GET['jeu']) ? $_GET['jeu'] : null;
        $nom = !empty($_GET['nom']) ? $_GET['nom'] : null;
        $prixmin = !empty($_GET['prixmin']) ? $_GET['prixmin'] : null;
        $prixmax = !empty($_GET['prixmax']) ? $_GET['prixmax'] : null;
        $notoriety = !empty($_GET['Notoriety']) ? $_GET['Notoriety'] : null;
        $lieu = !empty($_GET['lieu']) ? $_GET['lieu'] : null;
        $date = !empty($_GET['date']) ? $_GET['date'] : null;
        try {
            $liste = $Tournament->tournamentsFilter($jeu, $nom, $prixmin, $prixmax, $notoriety, $lieu, $date);
        } catch (Exception $e) {
            $e->getMessage(); // to verify
        }
    }
    $tournamentList = '';
    foreach ($liste as $T) {
        $tournamentList .= '<tr>
            <td>' . $T->getName() . '</td>
            <td> ' . $T->getCashPrize() . '</td>
            <td> ' . $T->getNotoriety() . '</td>
            <td> ' . $T->getLocation() . '</td>
            <td> ' . $T->getHourStart() . '</td>
            <td> ' . $T->getDate() . '</td>
            <td> ' . $T->getregisterDeadline() . '</td>
            <td> ' . $T->namesgames() . "</td>
            <td><a href=\"./index.php?page=detailstournoi&IDT=".$T->getIdTournament()."\"><img class='imgB' src='./img/Detail.png' alt='Details'></a></td>
            </tr>";
    }
    $replacementCode[0] = $tournamentList;
    return (str_replace($codeToReplace, $replacementCode, $buffer));
}
?>