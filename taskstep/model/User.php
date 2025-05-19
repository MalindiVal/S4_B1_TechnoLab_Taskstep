<?php

class User {
    private int $id;
    private string $email;
    private string $password;

    // --- Getters ---
    /**
     * Identifiant de l'utilisateur
     * @return int l'identifiant de l'utilisateur
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Récupération de l'e-mail de l'utilisateur
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Récuperation du mot de passe de l'utilisateur ( mot de passe hashé)
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    // --- Setters ---
    /**
     * Change l'e-mail de l'utilisateur
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * Changemet de mot de passe
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    // --- Hydration ---
    /**
     * Remplit l'objet User à partir d'un tableau associatif
     * @param array $data tableau de données
     * @return void
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
