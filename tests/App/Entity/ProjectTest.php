<?php

namespace Tests\App\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Project;
use Doctrine\Common\Persistence\ObjectRepository;


class ProjectTest extends WebTestCase {

    /** @test */

    public function a_user_can_create_a_project()
    {
        $project = new Project();
        $project->setTitle(null);
        $project->setBody('ddenem body');

        self::assertNull($project->getTitle());

    }

}