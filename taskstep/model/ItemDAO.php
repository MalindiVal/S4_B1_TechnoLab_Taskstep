<?php
require_once("Database.php");
require_once("Item.php");
class ItemDAO extends Database
{
    /**
     * Récupère tous les items, avec possibilité de tri (ORDER BY)
     * @param string|null $orderby Nom de la colonne pour le tri
     * @return array Tableau d'objets Item
     */
    public function getAll(string $type = null, int $id = null, string $orderby): array {
        $tab = [];
        $sql = "SELECT * FROM items";
        $params = [];
    
        $allowedTypes = ["section", "project", "context", "today"];
        $allowedOrderBy = ["id", "title", "done", "date"];
    
        if ($type !== "all" && in_array($type, $allowedTypes)) {
            if ($type !== "today") {
                $sql .= " WHERE {$type}_id = :id";
                $params[':id'] = $id;
            } else {
                $today = date("Y-m-d");
                $sql .= " WHERE end_date = :today";
                $params[':today'] = $today;
            }
        }
    
        if ($orderby && in_array($orderby, $allowedOrderBy)) {
            $sql .= " ORDER BY {$orderby}";
        }
    
        $res = $this->queryMany($sql, $params);
        foreach ($res as $s) {
            $item = new Item();
            $item->hydrate($s);
            $tab[] = $item;
        }
    
        return $tab;
    }

    public function Update(Item $item){
        $this->execute("UPDATE items SET title=:title , notes= :notes , url = :url , context_id = :context , section_id = :section, project_id = :project , done=:done WHERE id=:id and user_id= :user_id",
        [
            ":title" => $item->getTitle(),
            ":notes" => $item->getNotes(),
            ":url" => $item->getUrl(),
            ":context" => $item->getContextId(),
            ":project" => $item->getProjectId(),
            ":section" => $item->getSectionId(),
            ":user_id" => intval($_SESSION["user_id"]),
            ":id" => $item->getId()
        ]
    );
    }

    public function Add(Item $item){
        $this->execute("INSERT INTO items (title,date,section_id,notes,url,done,context_id,project_id,user_id)".
		"values (:title, :date, :section, :notes,:url, 0, :context, :project,:user_id)",
        [
            ":title" => $item->getTitle(),
            ":notes" => $item->getNotes(),
            ":date" => $item->getDate(),
            ":url" => $item->getUrl(),
            ":context" => $item->getContextId(),
            ":project" => $item->getProjectId(),
            ":section" => $item->getSectionId(),
            ":user_id" => intval($_SESSION["user_id"])
        ]
    );
    }
    

    /**
     * Récupère un item selon son identifiant
     * @param int $id
     * @return Item
     */
    public function getById(int $id): Item {
        $res = $this->queryOne("SELECT * FROM items WHERE id = :id and user_id= :user_id " , [":id" => $id,":user_id" => intval($_SESSION["user_id"])]);
        $item = new Item();
        $item->hydrate($res);
        return $item;
    }

    /**
     * Récupère tous les items cochés ou non cochés
     * @param bool $done
     * @return array Tableau d'objets Item
     */
    public function getChecked(bool $done): array {
        $tab = array();
        $num = $done ? 1 : 0;
        $res = $this->queryMany("SELECT * FROM items WHERE done = :done and user_id= :user_id", [":done" => $num,":user_id" => intval($_SESSION["user_id"])]);
        foreach ($res as $s) {
            $item = new Item();
            $item->hydrate($s);
            $tab[] = $item;
        }
        return $tab;
    }

    /**
     * Met à jour l'état "coché" d'un item (true/false)
     * @param bool $done
     * @param int $id
     */
    public function setChecked(bool $done, int $id): void {
        $num = $done ? 1 : 0;
        $this->execute("UPDATE items SET done = :done WHERE id = :id and user_id= :user_id ", [":done" => $num, ":id" => $id,":user_id" => intval($_SESSION["user_id"])]);
    }

    /**
     * Supprime un item selon son identifiant
     * @param int $id
     */
    public function Delete(int $id): void {
        $this->execute("DELETE FROM items WHERE id = :id and user_id= :user_id", [":id" => $id,":user_id" => intval($_SESSION["user_id"])]);
    }

    /**
     * Supprime tous les items marqués comme terminés (done = 1)
     */
    public function PurgeDoneItem(): void {
        $this->execute("DELETE FROM items WHERE done = 1 and user_id= :user_id", [":user_id" => intval($_SESSION["user_id"])] );
    }

    public function getImediateItems() : array{
        $tab = array();
        $today  = date("Y-m-d");
        $result = $this->queryMany("SELECT * FROM items 
        WHERE date <= :today AND done='0' 
            AND date != '00-00-0000' OR section_id=3 
            AND done='0' ORDER BY date LIMIT 5",[":today" => $today]);
        foreach ($result as $s) {
            $item = new Item();
            $item->hydrate($s);
            $tab[] = $item;
        }
    
        return $tab;
    }
}