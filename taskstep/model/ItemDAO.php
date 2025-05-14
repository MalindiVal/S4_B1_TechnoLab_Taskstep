<?php
require_once("Database.php");
require_once("Item.php");
class ItemDAO extends Database
{
    public function getAll(string $orderby = null) : array{
        $tab = array();
        $sql = "SELECT * FROM items";
        $params = [];
        if($orderby){
            $sql += " ORDER BY :order";
            $params[] += [":order" => $orderby]; 
        }
        $res= $this->queryMany($sql,$params);
        foreach ($res as $s) {
            $item = new Item();
            $item->hydrate($s);
            $tab[]=$item;
        }
        
        return $tab;
        
    }

    public function getById(int $id) : Item {
        $res= $this->queryOne("SELECT * FROM items WHERE id=:id",[":id" => $id]);
        $item = new Item();
        $item->hydrate($res);
        
        return $item;
    }

    public function getChecked(bool $done) : array {
        $tab = array();
        $num = $done ? 1 : 0;
        $res= $this->queryMany("SELECT * FROM items WHERE done=:done",[":done" => $num]);
        foreach ($res as $s) {
            $item = new Item();
            $item->hydrate($s);
            $tab[]=$item;
        }
        return $tab;
    }

    public function setChecked(bool $done,int $id){
        $tab = array();
        $num = $done ? 1 : 0;
        $res= $this->execute("UPDATE items SET done=:done WHERE id=:id",[":done" => $num,":id" => $id]);
    }

    public function Delete(int $id) : void{
        $this->execute("DELETE FROM items WHERE id= :id",[":id" => $id]);
    }

    public function PurgeDoneItem() : void{
        $this->execute("DELETE FROM items WHERE done=1");
    }
}