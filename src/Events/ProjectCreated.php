<?php


namespace App\Events;


use App\Entity\Project;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ProjectCreated extends EventDispatcher
{
    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

}