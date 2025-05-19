<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/Setting.php';

/**
 * Teste la classe Setting
 */
class SettingTest extends TestCase
{
    /**
     * Teste l'hydratation d'un objet Setting
     * @return void
     */
    public function testHydrate(): void
    {
        $data = [
            'id' => '1',
            'tips' => '1',
            'stylesheet' => 'dark-theme.css',
            'session' => '0',
            'user_id' => '42'
        ];

        $setting = new Setting();
        $setting->hydrate($data);

        $this->assertSame(1, $setting->getId());
        $this->assertTrue($setting->getTips());
        $this->assertSame('dark-theme.css', $setting->getStylesheet());
        $this->assertFalse($setting->getSession());
        $this->assertSame(42, $setting->getUserId());
    }

    /**
     * Teste les setters de la classe Setting
     * @return void
     */
    public function testSetters(): void
    {
        $setting = new Setting();

        $setting->setId(5);
        $this->assertSame(5, $setting->getId());

        $setting->setTips(true);
        $this->assertTrue($setting->getTips());

        $setting->setStylesheet('light-theme.css');
        $this->assertSame('light-theme.css', $setting->getStylesheet());

        $setting->setSession(true);
        $this->assertTrue($setting->getSession());

        $setting->setUserId(99);
        $this->assertSame(99, $setting->getUserId());
    }
}
