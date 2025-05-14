<?php
class Setting{
    private int $id;
    private bool $tips;
    private string $theme;
    private int $userid;

    /**
     * Récupère l'Id du parametre
     * @return int l'id
     */
    public function getId(): int {
        return $this->id;
    }

    public function getTips(): bool {
        return $this->tips;
    }

    public function getTheme(): string {
        return $this->theme;
    }

    public function getUserId(): int {
        return $this->userid;
    }

    // Setters
    public function setTips(bool $tips): void {
        $this->tips = $tips;
    }

    public function setTheme(string $theme): void {
        $this->theme = $theme;
    }

    public function setUserId(int $userid): void {
        $this->userid = $userid;
    }
}