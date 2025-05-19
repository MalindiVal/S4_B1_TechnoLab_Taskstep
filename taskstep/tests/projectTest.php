<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/Project.php';

/**
 * Teste la classe Project
 */
class ProjectTest extends TestCase
{
    /**
     * Teste l'hydratation d'un objet Project
     * @return void
     */
    public function testHydrate(): void
    {
        $data = [
            'id' => '15',
            'title' => 'Nouveau Projet',
            'user_id' => '42'
        ];

        $project = new Project();
        $project->hydrate($data);

        $this->assertSame(15, $project->getId());
        $this->assertSame('Nouveau Projet', $project->getTitle());
        $this->assertSame(42, $project->getUserID());
    }

    /**
     * Teste la modification
     * @return void
     */
    public function testSetters(): void
    {
        $project = new Project();

        $project->setTitle('Projet Test');
        $this->assertSame('Projet Test', $project->getTitle());

        // Correction du setter nécessaire avant que ce test passe
        $project->setUserId(77);
        $this->assertSame(77, $project->getUserID());
    }
}
