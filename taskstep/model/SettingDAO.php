<?php
require_once("Database.php");
require_once("Setting.php");
class SettingDAO extends Database
{
    /**
     * Recupération des paramètres d'un utilisateur ( l'id étant stockées dans la session)
     * @return Setting les paramètres de l'utilisateur
     */
    public function getSettingsByUser($idUser): Setting {
        try{
            $sql = "SELECT id, user_id, tips, stylesheet, `session` FROM settings WHERE user_id = ?";
            $res = $this->queryOne($sql, [$idUser]);

            $setting = new Setting();
            $setting->hydrate($res);
        }
        catch(Exception $e){
            throw new Exception("Erreur lors de l'exécution de la requête: " . $e->getMessage());
        }

        return $setting;
    
    }
    
    /**
     * Mise à jour des parametres 
     * @param Setting $settings un objet Setting qui regroupe
     * @return void
     */
    public function UpdateSetting(Setting $settings): void {
        $sql = "UPDATE settings SET tips = :tips, stylesheet = :stylesheet, `session` = 1 WHERE user_id = :uid";
        $this->execute($sql, [
            ':tips' => $settings->getTips(),
            ':stylesheet' => $settings->getStylesheet(),
            ':uid' => intval($_SESSION["user_id"])
        ]);
    }
    
}
