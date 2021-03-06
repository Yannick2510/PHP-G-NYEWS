<?php

class Validation
{

    public static function nettoyerString($string):string
    {
        return filter_var($string,FILTER_SANITIZE_STRING);
    }

    public static function nettoyerURL($url):string
    {
        return filter_var($url,FILTER_SANITIZE_URL);
    }

    public static function validString(string $string, array &$tVueErreur):bool
    {
        if(empty($string)){
            $tVueErreur[]="Chaine vide";
            return false;
        }
        if ($string!=self::nettoyerString($string))
        {
            $tVueErreur[]="Utilisation de caractères non valides";
            return false;
        }
        return true;
    }

    /**
     * @param string $url
     * @param array $tVueErreur
     * @return bool
     * Permet de valider ou non une URL passée en paramètre et d'écrire, le cas écheant, l'erreur dans le tableau d'erreurs.
     */
    public static function validURL(string $url,array &$tVueErreur):bool {
        if(empty($url)){
            $tVueErreur[]="URL vide";
            return false;
        }
        if($url!=self::nettoyerURL($url)){
            $tVueErreur[]="Caractères interdits dans l'URL";
            return false;
        }
        return true;
    }

    /**
     * @param $login
     * @param $pass
     * @param array $tVueErreur
     * @return bool
     * Permet de valider ou non un login et mot de passe passés en paramètre et d'écrire, le cas écheant, l'erreur dans le tableau d'erreurs.
     */
    public static function validLogin($login,$pass,array &$tVueErreur):bool
    {
        if (empty($login)) {
            $tVueErreur[] = "Login oublié";
            return false;
        }

        if (empty($pass)) {
            $tVueErreur[] = "Mot de passe oublié";
            return false;
        }

        if ($login!=self::nettoyerString($login) || $pass!=self::nettoyerString($pass)) {
            $tVueErreur[] = "Utilisation de caractères interdits";
            return false;
        }
        return true;
    }

    /**
     * @param string $nom
     * @param string $logo
     * @param string $lien
     * @param string $fluxRSS
     * @param array $tVueErreur
     * @return bool
     * Permet de valider ou non les attributs d'un site passés en paramètre et d'écrire, le cas écheant, l'erreur dans le tableau d'erreurs.
     */
    public static function validSite(string $nom,string $logo, string $lien, string $fluxRSS, array &$tVueErreur):bool{

        if(empty($nom)){
            $tVueErreur[]="Nom manquant";
            return false;
        }

        if(empty($lien)){
            $tVueErreur[]="Lien manquant";
            return false;
        }

        if(empty($fluxRSS)){
            $tVueErreur[]="fluxRSS manquant";
            return false;
        }

        if(empty($logo)){
            $tVueErreur[]="Logo manquant";
            return false;
        }

        if ($nom!=self::nettoyerString($nom) || $logo!=self::nettoyerURL($logo) || $fluxRSS!=self::nettoyerString($fluxRSS) || $lien!=self::nettoyerURL($lien))
        {
            $tVueErreur[]="Utilisation de caractères interdits";
            return false;
        }
        if(!filter_var($logo,FILTER_VALIDATE_URL)){
            $tVueErreur[]="URL du Logo non valide";
            return false;
        }
        if(!filter_var($lien,FILTER_VALIDATE_URL)){
            $tVueErreur[]="URL non valide";
            return false;
        }
        if(!filter_var($fluxRSS,FILTER_VALIDATE_URL)){
            $tVueErreur[]="URL flux RSS non valide";
            return false;
        }
        return true;

    }
}

?>