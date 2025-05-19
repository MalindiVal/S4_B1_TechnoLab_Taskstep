<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/User.php';

/**
 * Teste la classe User
 */
class UserTest extends TestCase
{
    /**
     * Teste l'hydratation d'un objet User
     * @return void
     */
    public function testHydrate(): void
    {
        $data = [
            'id' => '1',
            'email' => 'user@example.com',
            'password' => 'hashed_password'
        ];

        $user = new User();
        $user->hydrate($data);

        $this->assertSame(1, $user->getId());
        $this->assertSame('user@example.com', $user->getEmail());
        $this->assertSame('hashed_password', $user->getPassword());
    }

    /**
     * Teste les setters de la classe User
     * @return void
     */
    public function testSetters(): void
    {
        $user = new User();

        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());

        $user->setPassword('new_hashed_password');
        $this->assertSame('new_hashed_password', $user->getPassword());
    }
}
