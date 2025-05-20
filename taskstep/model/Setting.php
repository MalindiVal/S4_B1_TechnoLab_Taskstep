<?php
class Setting
{
    private int $id;
    private bool $tips;
    private string $stylesheet;
    private bool $session;
    private int $userid;
    

    // Getters
    /**
     * Identifiant des parametres
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * La possibilité d'afficher des tips
     * @return bool
     */
    public function getTips(): bool
    {
        return $this->tips;
    }

    /**
     * Le CSS dans les parametres
     * @return string
     */
    public function getStylesheet(): string
    {
        return $this->stylesheet;
    }

    /**
     * Si le site utilise les sessions
     * @return bool
     */
    public function getSession(): bool
    {
        return $this->session;
    }

    /**
     * Identifiant de l'utilisateur des parametres
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userid;
    }

    // Setters
    /**
     * Permet de changer les parametres
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Summary of setTips
     * @param bool $tips
     * @return void
     */
    public function setTips(bool $tips): void
    {
        $this->tips = $tips;
    }

    /**
     * Changer le css du site
     * @param string $stylesheet
     * @return void
     */
    public function setStylesheet(string $stylesheet): void
    {
        $this->stylesheet = $stylesheet;
    }

    /**
     * Changer l'utilisation des sessions
     * @param bool $session
     * @return void
     */
    public function setSession(bool $session): void
    {
        $this->session = $session;
    }

    /**
     * Changer l'id utilisateur lier à la table des parametres
     * @param int $userid
     * @return void
     */
    public function setUserId(int $userid): void
    {
        $this->userid = $userid;
    }

    /**
     * Hydrate l'objet à partir d'un tableau
     * @param array $data tableau de données
     * @return void
     */
    public function hydrate(array $data): void
    {
        if (isset($data['id'])) {
            $this->setId((int) $data['id']);
        }
        if (isset($data['tips'])) {
            $this->setTips((bool) $data['tips']);
        }
        if (isset($data['stylesheet'])) {
            $this->setStylesheet((string) $data['stylesheet']);
        }
        if (isset($data['session'])) {
            $this->setSession((bool) $data['session']);
        }
        if (isset($data['user_id'])) {
            $this->setUserId((int) $data['user_id']);
        }
    }
}
