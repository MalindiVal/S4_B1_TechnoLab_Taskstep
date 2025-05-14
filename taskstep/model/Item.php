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

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getNotes(): string {
        return $this->notes;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function isDone(): bool {
        return $this->done;
    }

    public function getContextId(): int {
        return $this->contextId;
    }

    public function getSectionId(): int {
        return $this->sectionId;
    }

    public function getProjectId(): int {
        return $this->projectId;
    }


    // Setters
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function setNotes(string $notes): void {
        $this->notes = $notes;
    }

    public function setUrl(string $url): void {
        $this->url = $url;
    }

    public function setDone(bool $done): void {
        $this->done = $done;
    }

    public function hydrate(array $data) : void{
        if (isset($data["id"])){
            $this->id = intval($data["id"]);
        }

        if (isset($data["title"])){
            $this->title= $data["title"];
        }

        if (isset($data["notes"])){
            $this->notes = $data["notes"];
        }

        if (isset($data["url"])){
            $this->url = $data["url"];
        }

        if (isset($data["done"])){
            $this->done = intval($data["done"]) > 0;
        }
    }

}