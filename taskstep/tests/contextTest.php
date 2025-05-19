<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/Context.php';

/**
 * Teste la classe Context
 */
class ContextTest extends TestCase
{
    /**
     * Teste l'hydratation d'un objet Context
     * @return void
     */
    public function testHydrate(): void
    {
        $context = new Context();
        $data = [
            'id' => '42',
            'title' => 'Mon Contexte'
        ];

        $context->hydrate($data);

        $this->assertSame(42, $context->getId());
        $this->assertSame('Mon Contexte', $context->getTitle());
    }

    /**
     * Teste la modification du titre d'un context
     * @return void
     */
    public function testSetTitle(): void
    {
        $context = new Context();
        $context->hydrate([
            'id' => 7,
            'title' => 'Titre Initial'
        ]);

        $context->setTitle('Titre Modifié');

        $this->assertSame(7, $context->getId());
        $this->assertSame('Titre Modifié', $context->getTitle());
    }
}
