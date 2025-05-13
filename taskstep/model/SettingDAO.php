<?php
require_once("Database.php");
class SettingDAO extends Database
{
    public function setSetting(string $type,string $value){
        $this->execute("UPDATE settings SET value= :value WHERE setting=:setting",[':value' => $value,':setting' => $type]);
    }

    public function getSetting(string $type) : string{
        $res= $this->queryOne("SELECT value FROM settings WHERE setting= :setting",[':setting' => $type]);
        return $res["value"];
    }
}
