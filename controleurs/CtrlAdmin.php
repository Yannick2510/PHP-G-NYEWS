<?php
/*
 * Les actions effectuées par l'administrateur seront récupérées ici, en fonction de ces
 * actions différentes méthodes seront appelées, en utilisant notamment le modèle Admin
 */
class CtrlAdmin
{
    public function __construct()
    {
        global $rep, $vues;
        $tVueErreur = array();
        //$this->chargerAdmin();

        try {
            $action = $_REQUEST['action'];
            switch ($action) {
                case "ajouterSite":
                    $this->ajouterSite($tVueErreur);
                    break;
                case "supprimerSite":
                    $this->supprimerSite($tVueErreur);
                    break;
                case "seDeconnecter":
                    $this->deconnexion($tVueErreur);
                    break;
                case "changerNbNewsParPage":
                    $this->modifierNbNewsParPage($tVueErreur);
                    break;
                case "chargerAdmin" || null:
                    $this->chargerAdmin();
                    break;

            }
        } catch (PDOException $e) {
            $tVueErreur[] = "Erreur sur la Base de donnée !";
            require($rep . $vues['erreur']);

        } catch (Exception $e2) {
            $tVueErreur[] = "Erreur inattendue!!! ";
            require($rep . $vues['erreur']);
        }
    }




    function chargerAdmin(){
        global $rep, $vues;
        $mdlA = new ModeleAdmin();
        if ($mdlA->getNombreSite() <= 0) {
            $tabSite = [];
            require($rep . $vues['admin']);
        } else {
            $tabSite = $mdlA->trouverSites();
            require($rep . $vues['admin']);
        }

    }

    function ajouterSite(array &$tVueErreur){
        global $rep, $vues;
        $mdlA = new ModeleAdmin();
        $nom = $_REQUEST['nom'];
        $logo = $_REQUEST['logo'];
        $lien = $_REQUEST['lien'];
        $flux = $_REQUEST['flux'];

        if(Validation::validSite($nom,$logo,$lien,$flux,$tVueErreur)){
            if($mdlA->insererSite($nom,$lien,$logo,$flux))
                $this->chargerAdmin();
            else {
                $tVueErreur[] = "Un site possède déjà ce flux rss";
                require($rep . $vues['erreur']);
            }
        }
        else {
            $tVueErreur[] = "Erreur lors de la validation de l'ajout du site";
            require($rep . $vues['erreur']);
        }
    }


    function supprimerSite(array &$tVueErreur){
        global $rep, $vues;
        $mdlA = new ModeleAdmin();

        $selectedflux = $_POST['choixSuppr'];

        if(Validation::validURL($selectedflux,$tVueErreur)){
            $mdlA->delSite($selectedflux);
            $this->chargerAdmin();
        }
        else{
            $tVueErreur[] = "Erreur lors de la validation de la suppression du site";
            require($rep . $vues['erreur']);
        }

    }

    function modifierNbNewsParPage(array &$tVueErreur){
        global $rep, $vues;
        $nb=$_REQUEST["nbNewsParPage"];
        $mdlA=new ModeleAdmin();
        if(!$mdlA->modifierNbNewsModele($nb)){
            $tVueErreur[]="Erreur lors de la modification du nombre de News";
            require($rep . $vues['erreur']);
        }
        if(empty($tVueErreur)){
            header("Location: index.php?action=chargerAdmin");

        }
    }

    function deconnexion(array &$tVueErreur){
        global $rep, $vues;
        session_unset();
        header("Location: index.php");
    }



}
