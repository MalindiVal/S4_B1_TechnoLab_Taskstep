<?php

class Section{
    private int $id;
    private string $title;
    private string $fancytitle;

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getFancyTitle(): string {
        return $this->fancytitle;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setFancyTitle(string $fancytitle): void {
        $this->fancytitle = $fancytitle;
    }

    public function hydrate(array $data) : void{
        if (isset($data["id"])){
            $this->id = intval($data["id"]);
        }

        if (isset($data["title"])){
            $this->title= $data["title"];
        }

        if (isset($data["fancytitle"])){
            $this->fancytitle = $data["fancytitle"];
        }
    }
}