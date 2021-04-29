<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- Compatible / UTF / Viewport-->
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Style CSS / Script -->
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/combat.css">
            <link rel="stylesheet" href="css/perso.css">
            <link rel="stylesheet" href="css/item.css">
            <link rel="stylesheet" href="css/map.css">
            <link rel="stylesheet" href="css/entite.css">
            <script src="main.js"></script>
        <!-- Informations Générales -->
            <title>Projet Full Stack - Combat</title>
            <meta name='description' content='Projet Full Stack - Combat'>
            <link rel='shortcut icon' href='favicon.ico'>
            <meta name='author' content='La Providence - Amiens'>
        <!-- Intégration Facebook -->
            <meta property='og:title' content='Projet Full Stack - Combat'>
            <meta property='og:description' content='Projet Full Stack - Combat'>
            <meta property='og:image' content='favicon.ico'>
        <!-- Intégration Twitter -->
            <meta name='twitter:title' content='Projet Full Stack - Combat'>
            <meta name='twitter:description' content='Projet Full Stack - Combat'>
            <meta name='twitter:image' content='favicon.ico'>
    </head>
    <body class="bodyAccueil">
        <?php
            include "session.php";

            // Vérifie que la Session est Valide avec le bon Mot de Passe.
            if($access === true){
                $access = $Joueur1->DeconnectToi();
            }
            // Vérifie qu'il ne s'est pas déconnecté.
            if($access === true){
                include "ihm/fonction-web/menu.php";

                $personnage = $Joueur1->getPersonnage();
                if(is_null($personnage->getId())){
                    ?>
                        <div class="reglement">
                            <p>Il faut créer un personnage d'abord.</p>
                            <p><a href="index.php">Retour à l'origine du tout.</a></p>
                        </div>
                    <?php
                }
                else{
                    ?>
                        <div class="reglement">
                            <?php
                                $personnage->getChoixPersonnage($Joueur1);
                                $map = $personnage->getMap();
                                $tabDirection = $map->getMapAdjacenteLienHTML('nord',$Joueur1); 
                                ?>
                                    <?= $tabDirection['nord'] ?>
                                    <p class="WelcomeCombat">Bienvenue <?= $Joueur1->getPrenom() ?></p>
                                    <p class="ChoixCombattant">Tu as décidé de combattre avec <?= $Joueur1->getNomPersonnage() ?>, il a une fortune de <?= $personnage->getValeur() ?> (NFT)</p>
                                    <div class="avatar">
                                        <!-- AFFICHAGE EN-TÊTE PERSONNAGE ET SAC -->
                                        <div class='entete'>
                                            <div class="avatar">
                                                <?php $personnage->renderHTML() ?>
                                            </div>
                                            <div class="divSac">
                                                <p id='TitleSacoche'>Sacoche</p>
                                                <?php
                                                    // Include Items / Equipement
                                                    include "ihm/map/affichageSacItem.php";
                                                    include "ihm/map/affichageSacEquipement.php";
                                                ?>
                                            </div>
                                        </div>
                                        <div class="InformationCombat">
                                            <p class="PositionCombattant">Ton combattant est sur la position : <?= $map->getNom() ?> </p>
                                            <p class="InfoCombat1">Tu peux maintenant ramasser des conneries par terre.</p>
                                            <p class="InfoCombat2">Si tu en trouves qui sont parfaitement identiques, elles prennent de la valeur 😄 !</p>
                                            <p class="InfoButJeu">But du jeu : Capture le "Super Jedi Légendaire".</p>
                                        </div>
                                        <div class="tableaChass">
                                            <div class="titreMonster">
                                                <p class="TitreMonstreCapture">Voici tes monstres capturés :</p>
                                            </div>
                                            <?php
                                                $MysMob = new Mob($mabase);
                                                foreach($Joueur1->getAllMyMobIds() as $mob){
                                                    ?>
                                                        <div class="monster">
                                                            <?php
                                                                $MysMob->setMobById($mob);
                                                                $MysMob->renderHTML();
                                                            ?>
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                            <p class="titreMonster">Seul un certain pouvoir peut protéger tes monstres d'une capture...</p>
                                        </div>
                                        <p><a href="index.php" >Créer un autre personnage.</a></p>
                                    </div>
                                <?php
                                $tabDirection = $map->getMapAdjacenteLienHTML('nord',$Joueur1);
                            ?>
                        </div>
                    <?php
                }
            }
            else{
                echo $errorMessage;
            }
            include "ihm/fonction-web/footer.php";
        ?>
    </body>
</html>