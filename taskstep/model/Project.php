<?php

class Project{
    private int $id;
    private string $title;
    
    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

   

    public function hydrate(array $data) : void{
        if (isset($data["id"])){
            $this->id = intval($data["id"]);
        }

        if (isset($data["title"])){
            $this->title= $data["title"];
        }
    }
}