<?php
require_once("Database.php");
require_once("Setting.php");
class SettingDAO extends Database
{
    /**
     * Summary of setSetting
     * @param string $type
     * @param string $value
     * @return void
     */
    public function setSetting(string $type,string $value){
        $this->execute("UPDATE settings SET value= :value WHERE setting=:setting",[':value' => $value,':setting' => $type]);
    }

    /**
     * Summary of getSetting
     * @param string $type
     * @return string
     */
    public function getSetting(string $type) : string{
        $res= $this->queryOne("SELECT value FROM settings WHERE setting= :setting",[':setting' => $type]);
        return $res["value"];
    }

    /**
     * Summary of getAll
     * @return array
     */
    public function getAll() : array{
        $tab = array();
        
        
        return $tab;
        
    }

    public function UpdateSetting(): void {
        
    }
}
