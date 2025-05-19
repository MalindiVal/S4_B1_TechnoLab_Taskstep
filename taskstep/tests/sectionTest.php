<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/Section.php';

/**
 * Teste la classe Section
 */
class SectionTest extends TestCase
{
    /**
     * Teste l'hydratation d'un objet Section
     * @return void
     */
    public function testHydrate(): void
    {
        $data = [
            'id' => '1',
            'title' => 'Introduction',
            'fancy_title' => '✨ Introduction ✨',
            'total' => '10',
            'finished' => '4',
            'user_id' => '99'
        ];

        $section = new Section();
        $section->hydrate($data);

        $this->assertSame(1, $section->getId());
        $this->assertSame('Introduction', $section->getTitle());
        $this->assertSame('✨ Introduction ✨', $section->getFancyTitle());
        $this->assertSame(10, $section->getTotal());
        $this->assertSame(4, $section->getFinished());
        $this->assertSame(99, $section->getUserId());
    }

    /**
     * Teste les setters de la classe Section
     * @return void
     */
    public function testSetters(): void
    {
        $section = new Section();

        $section->setTitle('Chapitre 1');
        $this->assertSame('Chapitre 1', $section->getTitle());

        $section->setFancyTitle('📚 Chapitre 1 📚');
        $this->assertSame('📚 Chapitre 1 📚', $section->getFancyTitle());

        $section->setUserId(55);
        $this->assertSame(55, $section->getUserId());
    }
}
