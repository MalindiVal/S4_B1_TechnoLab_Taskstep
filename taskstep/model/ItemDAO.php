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
    public function getAll(string $orderby): array {
        $tab = array();
        $sql = "SELECT * FROM items";

        $allowedColumns = ["id", "title", "done"]; // à adapter selon ton schéma
        if ($orderby && in_array($orderby, $allowedColumns)) {
            $sql .= " ORDER BY " . $orderby;
        }

        $res = $this->queryMany($sql);
        foreach ($res as $s) {
            $item = new Item();
            $item->hydrate($s);
            $tab[] = $item;
        }

        return $tab;
    }

    /**
     * Récupère un item selon son identifiant
     * @param int $id
     * @return Item
     */
    public function getById(int $id): Item {
        $res = $this->queryOne("SELECT * FROM items WHERE id = :id", [":id" => $id]);
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
        $res = $this->queryMany("SELECT * FROM items WHERE done = :done", [":done" => $num]);
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
        $this->execute("UPDATE items SET done = :done WHERE id = :id", [":done" => $num, ":id" => $id]);
    }

    /**
     * Supprime un item selon son identifiant
     * @param int $id
     */
    public function Delete(int $id): void {
        $this->execute("DELETE FROM items WHERE id = :id", [":id" => $id]);
    }

    /**
     * Supprime tous les items marqués comme terminés (done = 1)
     */
    public function PurgeDoneItem(): void {
        $this->execute("DELETE FROM items WHERE done = 1");
    }
}