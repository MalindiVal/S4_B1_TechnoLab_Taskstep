<?php
require_once("Database.php");
require_once("Setting.php");
class SettingDAO extends Database
{

    /**
     * Summary of getAll
     * @return array
     */
    public function getAll(): Setting {
        $tab = array();

        $res = $this->queryOne("SELECT tips, stylesheet, session FROM settings WHERE user_id = :uid", [
            ':uid' => intval($_SESSION["user_id"])
        ]);

        $setting = new Setting();
        $setting->hydrate($res);

        return $setting;
    }
    

    public function UpdateSetting(Setting $settings): void {
        $sql = "UPDATE settings SET tips = :tips, stylesheet = :stylesheet, session = 1 WHERE user_id = :uid";
        $this->execute($sql, [
            ':tips' => $settings->getTips(),
            ':stylesheet' => $settings->getStylesheet(),
            ':uid' => intval($_SESSION["user_id"])
        ]);
    }
    
}
