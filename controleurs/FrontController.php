<?php

class FrontController
{

    public function checkAction($actionsPossibles,$action)
    {
        foreach($actionsPossibles['Admin'] as $value)
        {
            if($value==$action)
                return 'Admin';
        }
        foreach($actionsPossibles['User'] as $value)
        {
            if($value==$action)
                return 'User';
        }
        return false;
    }


    public function __construct()
    {
        global $rep, $vues;
        $tVueErreur = array();

        $actionsPossibles = array('Admin'=>array('ajouterSite','supprimerSite'),'User'=>array('allerAArticle','seConnecter','accesLogin'));
        echo(password_hash('1234',PASSWORD_DEFAULT));
        var_dump($_SESSION['loginA']);
        try {

            $action = $_REQUEST['action'];
            $actor = $this->checkAction($actionsPossibles,$action);
            echo $actor;

            if($actor!=false) {

                $mdlA = new ModeleAdmin();
                $admin = $mdlA->isAdmin($tVueErreur);
                if ($admin == NULL) {

                    new CtrlUser();
                }
                else {
                    echo"   test";
                    new CtrlAdmin();
                }
            }
            else {
                new CtrlUser();
            }
        }
        catch (PDOException $e) {
            $tVueErreur[] = "Erreur sur la Base de donnée !";
            require($rep . $vues['erreur']);
        }
        catch (Exception $e2) {
            $tVueErreur[] = "Erreur inattendue!!! ";
            require($rep . $vues['erreur']);
        }
    }

}