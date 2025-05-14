<?php

class Section{
    private int $id;
    private string $title;
    private string $fancytitle;
    private int $total;
    private int $finished;

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getFancyTitle(): string {
        return $this->fancytitle;
    }

    public function getTotal(): int {
        return $this->total;
    }

    public function getFinished(): int {
        return $this->finished;
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

        if (isset($data["total"])){
            $this->total = $data["total"];
        }

        if (isset($data["finished"])){
            $this->finished = $data["finished"];
        }
    }
}