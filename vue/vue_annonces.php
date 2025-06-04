<center>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SESSION['role'] == "manager") {
    include_once("./controleur/getCandidatureByManager.php");
    include_once("./controleur/selectAllSpontanee.php");
    include_once("./controleur/getTitreByCand.php");

    echo '<h1> Vos Annonces </h1>';

    foreach ($getCandidatureByManager as $value) {
        switch ($value['statut']) {
            case 'attente':
                $sClass = 'attente';
                break;
            case 'valide':
                $sClass = 'valide';
                break;
            case 'refuse':
                $sClass = 'refuse';
                break;
            default:
                $sClass = '';
        }

        $getTitreByCand = $annonce->getTitreByCand($value['idCandidature']);
        $titre = !empty($getTitreByCand) ? $getTitreByCand[0] : 'Titre non trouvé';

        echo '<br><div class="col-8 ' . $sClass . ' candidature">';
        echo '<h3> Candidature n°' . $value['idCandidature'] . '</h3>';
        echo '<h4> Annonce : ' . $titre . '</h4>';

        echo '<a class="desc d-flex justify-content-start" href="controleur/candidatureControleur.php?type=cv&id=' . $value['idCandidature'] . '" target="_blank"><font color="black">Voir le CV :</font>cliquer ici</a><br>';

        if (!empty($value['motivation'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/candidatureControleur.php?type=motivation&id=' . $value['idCandidature'] . '" target="_blank"><font color="black">Voir la lettre de motivation :</font>cliquer ici</a><br>';
        }

        if (!empty($value['extraDoc'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/candidatureControleur.php?type=extraDoc&id=' . $value['idCandidature'] . '" target="_blank"><font color="black">Voir le document supplémentaire :</font>cliquer ici</a><br>';
        }

        echo '<p class="desc d-flex justify-content-start"><font color="black">Statut : </font>' . $value['statut'] . '</p>';

        echo '<p class="desc d-flex justify-content-start"><font color="black">Date : ' . $value['dateCand'] . '</font></p>';

        echo '<form action="controleur/updateCandidature.php" method="POST" style="border-radius: 0px; background-color: transparent">
            <input type="hidden" name="id" value="' . $value['idCandidature'] . '">
            <input type="hidden" name="statut" value="valide">
            <input type="submit" value="Valider">
        </form>';

        echo '<form action="controleur/updateCandidature.php" method="POST" style="border-radius: 0px; background-color: transparent">
            <input type="hidden" name="id" value="' . $value['idCandidature'] . '">
            <input type="hidden" name="statut" value="refuse">
            <input type="submit" value="Refuser">
        </form>';

        echo '</div>';
    }

    foreach ($allSpontanee as $value) {
        switch ($value['statut']) {
            case 'attente':
                $sClass = 'attente';
                break;
            case 'valide':
                $sClass = 'valide';
                break;
            case 'refuse':
                $sClass = 'refuse';
                break;
            default:
                $sClass = '';
        }

        echo '<br><div class="col-8 ' . $sClass . ' candidature">';
        echo '<h3> Candidature spontanee n°' . $value['idSpontanee'] . '</h3>';

        echo '<a class="desc d-flex justify-content-start" href="controleur/spontaneeControleur.php?type=cv&id=' . $value['idSpontanee'] . '" target="_blank"><font color="black">Voir le CV :</font>cliquer ici</a><br>';

        if (!empty($value['motivation'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/spontaneeControleur.php?type=motivation&id=' . $value['idSpontanee'] . '" target="_blank"><font color="black">Voir la lettre de motivation :</font>cliquer ici</a><br>';
        }

        if (!empty($value['extraDoc'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/spontaneeControleur.php?type=extraDoc&id=' . $value['idSpontanee'] . '" target="_blank"><font color="black">Voir le document supplémentaire :</font>cliquer ici</a><br>';
        }

        echo '<p class="desc d-flex justify-content-start"><font color="black">Statut : </font>' . $value['statut'] . '</p>';
        echo '<p class="desc d-flex justify-content-start"><font color="black">Date : ' . $value['dateCand'] . '</font></p>';
        
        echo '<form action="controleur/updateSpontanee.php" method="POST" style="border-radius: 0px; background-color: transparent">
            <input type="hidden" name="id" value="' . $value['idSpontanee'] . '">
            <input type="hidden" name="statut" value="valide">
            <input type="submit" value="Valider">
        </form>';

        echo '<form action="controleur/updateSpontanee.php" method="POST" style="border-radius: 0px; background-color: transparent">
            <input type="hidden" name="id" value="' . $value['idSpontanee'] . '">
            <input type="hidden" name="statut" value="refuse">
            <input type="submit" value="Refuser">
        </form>';

        echo '</div>';
    }
}

if ($_SESSION['role'] == "candidat") {
    echo '<h1> Vos candidatures </h1>';
    include_once("./controleur/getCandidature.php");
    include_once("./controleur/getSpontanee.php");
    include_once("./controleur/getTitreByCand.php");

    foreach ($getCandidature as $value) {
        switch ($value['statut']) {
            case 'attente':
                $sClass = 'attente';
                break;
            case 'valide':
                $sClass = 'valide';
                break;
            case 'refuse':
                $sClass = 'refuse';
                break;
            default:
                $sClass = '';
        }

        $getTitreByCand = $annonce->getTitreByCand($value['idCandidature']);
        $titre = !empty($getTitreByCand) ? $getTitreByCand[0] : 'Titre non trouvé';

        echo '<br><div class="col-8 ' . $sClass . ' candidature">';
        /*
        include_once("./controleur/getAnnonce.php");
        foreach ($getAnn as $valueA) {
            echo'
            <div class="col-8 annonce">
                    <h3>'.$valueA['titre'].'</h3>
                    <p class="loc d-flex justify-content-start">Localisation :'.$valueA['adresse'].'</p>
                    <p class="type d-flex justify-content-start">Type de contrat :'.$valueA['typeCon'].'</p>
            </div>';
        }*/
        echo '<h3> Candidature n°' . $value['idCandidature'] . '</h3>';
        echo '<h4> Annonce : ' . $titre . '</h4>';

        echo '<a class="desc d-flex justify-content-start" href="controleur/candidatureControleur.php?type=cv&id=' . $value['idCandidature'] . '" target="_blank"><font color="black">Voir le CV :</font>cliquer ici</a><br>';

        if (!empty($value['motivation'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/candidatureControleur.php?type=motivation&id=' . $value['idCandidature'] . '" target="_blank"><font color="black">Voir la lettre de motivation :</font>cliquer ici</a><br>';
        }

        if (!empty($value['extraDoc'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/candidatureControleur.php?type=extraDoc&id=' . $value['idCandidature'] . '" target="_blank"><font color="black">Voir le document supplémentaire :</font>cliquer ici</a><br>';
        }

        echo '<p class="desc d-flex justify-content-start"><font color="black">Statut : </font>' . $value['statut'] . '</p>';
        echo '<p class="desc d-flex justify-content-start"><font color="black">Date : ' . $value['dateCand'] . '</font></p>';

        echo '</div>';
    }

    foreach ($getSpontanee as $value) {
        switch ($value['statut']) {
            case 'attente':
                $sClass = 'attente';
                break;
            case 'valide':
                $sClass = 'valide';
                break;
            case 'refuse':
                $sClass = 'refuse';
                break;
            default:
                $sClass = '';
        }

        echo '<br><div class="col-8 ' . $sClass . ' candidature">';
        echo '<h3> Candidature spontanee n°' . $value['idSpontanee'] . '</h3>';

        echo '<a class="desc d-flex justify-content-start" href="controleur/spontaneeControleur.php?type=cv&id=' . $value['idSpontanee'] . '" target="_blank"><font color="black">Voir le CV :</font>cliquer ici</a><br>';

        if (!empty($value['motivation'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/spontaneeControleur.php?type=motivation&id=' . $value['idSpontanee'] . '" target="_blank"><font color="black">Voir la lettre de motivation :</font>cliquer ici</a><br>';
        }

        if (!empty($value['extraDoc'])) {
            echo '<a class="desc d-flex justify-content-start" href="controleur/spontaneeControleur.php?type=extraDoc&id=' . $value['idSpontanee'] . '" target="_blank"><font color="black">Voir le document supplémentaire :</font>cliquer ici</a><br>';
        }

        echo '<p class="desc d-flex justify-content-start"><font color="black">Statut : </font>' . $value['statut'] . '</p>';
        echo '<p class="desc d-flex justify-content-start"><font color="black">Date : ' . $value['dateCand'] . '</font></p>';

        echo '</div>';
    }
}
?>
</center>