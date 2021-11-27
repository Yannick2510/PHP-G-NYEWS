<?php
class CtrlUser{
    public function __construct()
    {
        global $rep,$vues;
        session_start();

        $tVueErreur = array();

        try{
            $action=$_REQUEST['action'];
            switch($action){
                case NULL:
                    $this->init();
                    break;
                case "cliquerNews":
                    $this->allerAArticle();
                    break;
                case "seConnecter":
                    $this->seConnecter();
                    break;

            }
        }
        catch (PDOException $e)
        {
            //si erreur BD, pas le cas ici
            $dVueEreur[] =	"Erreur inattendue!!! ";
            require ($rep.$vues['erreur']);

        }
        catch (Exception $e2)
            {
            $dVueEreur[] =	"Erreur inattendue!!! ";
            require ($rep.$vues['erreur']);
            }

    }

    function init(){
        global $rep,$vues,$login,$password,$base;
        $GW = new NewsGateway(new Connection($base,$login,''));



        //Gestion des pages de news
        $nbNewsParPage=9;
        $nbNewsTotal=$GW->getNbNews();
        $nbPages=ceil($nbNewsTotal/$nbNewsParPage);
        $page=(isset($_GET['page'])) ? abs(intval($_GET['page'])) : 1;

        $page=($page==0) ? 1 : $page;
        $page=($page>$nbPages) ? $nbPages: $page;
        $tabNews=$GW->findNews($page,$nbNewsParPage);
        require($rep.$vues['vue1']);
    }

    function seConnecter(){
        global $rep,$vues;
        require ($rep.$vues['login']);
    }
    function allerAArticle(){
        global $rep,$vues;
        $url=$_REQUEST['url'];
        //Valider URL dans classe Validation
        header('Location: '.$url);
    }
}
?>