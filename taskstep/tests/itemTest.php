<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/Item.php';

/**
 * Teste la classe Item
 */
class ItemTest extends TestCase
{
    /**
     * Teste l'hydratation d'un objet Item
     * @return void
     */
    public function testHydrate(): void
    {
        $data = [
            'id' => '123',
            'title' => 'Titre exemple',
            'date' => '2025-06-01',
            'end_date' => '2025-06-02',
            'notes' => 'Quelques notes',
            'url' => 'https://example.com',
            'context_id' => '10',
            'section_id' => '20',
            'project_id' => '30',
            'context' => 'Contexte',
            'section' => 'Section',
            'project' => 'Projet',
            'user_id' => '99',
            'done' => '1',
        ];

        $item = new Item();
        $item->hydrate($data);

        $this->assertSame(123, $item->getId());
        $this->assertSame('2025-06-01', $item->getDate());
        $this->assertSame('2025-06-02', $item->getEndDate());
        $this->assertSame('Titre exemple', $item->getTitle());
        $this->assertSame('Quelques notes', $item->getNotes());
        $this->assertSame('https://example.com', $item->getUrl());
        $this->assertTrue($item->isDone());
        $this->assertSame(10, $item->getContextId());
        $this->assertSame(20, $item->getSectionId());
        $this->assertSame(30, $item->getProjectId());
        $this->assertSame('Contexte', $item->getContext());
        $this->assertSame('Section', $item->getSection());
        $this->assertSame('Projet', $item->getProject());
        $this->assertSame(99, $item->getUserID());
    }

    /**
     * Teste les setters de la classe Item
     * @return void
     */
    public function testSetters(): void
    {
        $item = new Item();

        $item->setTitle('Nouveau titre');
        $this->assertSame('Nouveau titre', $item->getTitle());

        $item->setDate('2025-07-15');
        $this->assertSame('2025-07-15', $item->getDate());

        $item->setEndDate('2025-07-16');
        $this->assertSame('2025-07-16', $item->getEndDate());

        $item->setNotes('Des notes modifiées');
        $this->assertSame('Des notes modifiées', $item->getNotes());

        $item->setUrl('https://phpunit.de');
        $this->assertSame('https://phpunit.de', $item->getUrl());

        $item->setDone(false);
        $this->assertFalse($item->isDone());

        $item->setContextId(5);
        $this->assertSame(5, $item->getContextId());

        $item->setSectionId(6);
        $this->assertSame(6, $item->getSectionId());

        $item->setProjectId(7);
        $this->assertSame(7, $item->getProjectId());

        $item->setUserId(42);
        $this->assertSame(42, $item->getUserID());
    }
}
