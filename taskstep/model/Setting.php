<?php
class Setting {
    private int $id;
    private bool $tips;
    private string $stylesheet;
    private bool $session;
    private int $userid;

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getTips(): bool {
        return $this->tips;
    }

    public function getStylesheet(): string {
        return $this->stylesheet;
    }

    public function getSession(): bool {
        return $this->session;
    }

    public function getUserId(): int {
        return $this->userid;
    }

    // Setters
    public function setTips(bool $tips): void {
        $this->tips = $tips;
    }

    public function setStylesheet(string $stylesheet): void {
        $this->stylesheet = $stylesheet;
    }

    public function setSession(bool $session): void {
        $this->session = $session;
    }

    public function setUserId(int $userid): void {
        $this->userid = $userid;
    }

    /**
     * Hydrate the object from an associative array
     * @param array $data
     * @return void
     */
    public function hydrate(array $data): void {
        if (isset($data['id'])) {
            $this->setId((int)$data['id']);
        }
        if (isset($data['tips'])) {
            $this->setTips((bool)$data['tips']);
        }
        if (isset($data['stylesheet']) || isset($data['style'])) {
            $this->setStylesheet((string)$data['stylesheet']);
        }
        if (isset($data['session'])) {
            $this->setSession((bool)$data['session']);
        }
        if (isset($data['user_id'])) {
            $this->setUserId((int)$data['user_id']);
        }
    }
}
