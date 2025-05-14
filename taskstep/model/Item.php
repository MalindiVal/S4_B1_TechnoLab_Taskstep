<?php
class Item{
    private int $id;
    private string $title;
    private string $date;
    private string $notes;
    private string $url;
    private int $contextId;
    private int $sectionId;
    private int $projectId;
    private bool $done;

    private int $userId;

    /**
     * Identifiant de l’item
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Titre de l’item
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Date associée à l’item
     * @return string
     */
    public function getDate(): string {
        return $this->date;
    }

    /**
     * Notes ou description de l’item
     * @return string
     */
    public function getNotes(): string {
        return $this->notes;
    }

    /**
     * URL associée
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * Statut : est-ce que l’item est terminé ?
     * @return bool
     */
    public function isDone(): bool {
        return $this->done;
    }

    /**
     * Identifiant du contexte (clé étrangère)
     * @return int
     */
    public function getContextId(): int {
        return $this->contextId;
    }

    /**
     * Identifiant de la section (clé étrangère)
     * @return int
     */
    public function getSectionId(): int {
        return $this->sectionId;
    }

    /**
     * Identifiant du projet (clé étrangère)
     * @return int
     */
    public function getProjectId(): int {
        return $this->projectId;
    }

    /**
     * le créateur du projet (clé étrangère)
     * @return int
     */
    public function getUserID(): int {
        return $this->userId;
    }


    /**
     * Définit le titre de l’item
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Définit la date de l’item
     */
    public function setDate(string $date): void {
        $this->date = $date;
    }

    /**
     * Définit les notes de l’item
     */
    public function setNotes(string $notes): void {
        $this->notes = $notes;
    }

    /**
     * Définit l’URL de l’item
     */
    public function setUrl(string $url): void {
        $this->url = $url;
    }

    /**
     * Définit si l’item est terminé ou non
     */
    public function setDone(bool $done): void {
        $this->done = $done;
    }

    /**
     * Définit l’identifiant du contexte
     */
    public function setContextId(int $contextId): void {
        $this->contextId = $contextId;
    }

    /**
     * Définit l’identifiant de la section
     */
    public function setSectionId(int $sectionId): void {
        $this->sectionId = $sectionId;
    }

    /**
     * Définit l’identifiant du projet
     */
    public function setProjectId(int $projectId): void {
        $this->projectId = $projectId;
    }

    /**
     * Définit l’identifiant du createur
     */
    public function setUserId(int $userId): void {
        $this->$userId = $$userId;
    }

     /**
     * Hydrate l'objet à partir d'un tableau associatif de données.
     * @param array $data Données à injecter dans l'objet
     */
    public function hydrate(array $data): void {
        if (isset($data["id"])) {
            $this->id = intval($data["id"]);
        }

        if (isset($data["title"])) {
            $this->title = $data["title"];
        }

        if (isset($data["date"])) {
            $this->date = $data["date"];
        }

        if (isset($data["notes"])) {
            $this->notes = $data["notes"];
        }

        if (isset($data["url"])) {
            $this->url = $data["url"];
        }

        if (isset($data["contextId"])) {
            $this->contextId = intval($data["contextId"]);
        }

        if (isset($data["sectionId"])) {
            $this->sectionId = intval($data["sectionId"]);
        }

        if (isset($data["projectId"])) {
            $this->projectId = intval($data["projectId"]);
        }

        if (isset($data["user_id"])) {
            $this->userId = intval($data["user_id"]);
        }

        if (isset($data["done"])) {
            $this->done = intval($data["done"]) > 0;
        }
    }

}