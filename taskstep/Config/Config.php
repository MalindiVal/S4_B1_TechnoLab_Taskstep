<?php
class Config {
    private static $param;

    /**
     * Recupère le parametre se trouvant dans un fichier
     * @param mixed $nom le nom du parametre
     * @param mixed $valeurParDefaut Valeur par défaut
     * @return mixed La valeur retrouvée
     */
    public static function get($nom, $valeurParDefaut = null) {
        if (isset(self::getParameter()[$nom])) {
            $valeur = self::getParameter()[$nom];
        }
        else {
            $valeur = $valeurParDefaut;
        }
        return $valeur;
    }

    // Renvoie le tableau des paramètres en le chargeant au besoin
    private static function getParameter() {
        if (self::$param == null) {
            $cheminFichier = __DIR__."\prod.ini";
            if (!file_exists($cheminFichier)) {
                $cheminFichier = __DIR__."\dev.ini";
            }
            if (!file_exists($cheminFichier)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            }
            else {
                self::$param = parse_ini_file($cheminFichier);
            }
        }
        return self::$param;
    }
}