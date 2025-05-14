<?php

class User {
    private int $id;
    private string $email;
    private string $password;

    // --- Getters ---
    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    // --- Setters ---
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    // --- Hydration ---
    /**
     * Remplit l'objet User à partir d'un tableau associatif (ex: issu d'une BDD)
     */
    public function hydrate(array $data): void {
        if (isset($data['id'])) {
            $this->id = intval($data['id']);
        }

        if (isset($data['email'])) {
            $this->email = $data['email'];
        }

        if (isset($data['password'])) {
            $this->password = $data['password'];
        }
    }
}
