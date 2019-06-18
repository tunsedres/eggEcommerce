<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/create", name="create_project")
     */
    public function create()
    {
        return $this->render('project/create.html.twig');
    }

    /**
     * @Route("/project/save", name="store_project")
     */

    public function store(Request $request, ValidatorInterface $validator)
    {
        $project = new Project();

        $project->setTitle($request->get('title'));
        $project->setBody($request->get('body'));

        $errors = $validator->validate($project);

        if(count($errors)>0)
            return $this->render('project/create.html.twig', ['errors'=>$errors]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        return $this->redirectToRoute('list_projects');
    }

    /**
     * @Route("/projects", name="list_projects")
     */

    public function index()
    {
        $projectEntity = $this->getDoctrine()->getRepository(Project::class);

        return $this->render('project/list.html.twig', ['projects'=>$projectEntity->findAll()]);
    }

    /**
     * @Route("/project/{project}/edit",name="project_edit")
     */

    public function edit(Project $project)
    {
        return $this->render('project/edit.html.twig', ['project' => $project]);
    }

    /**
     * @Route("/project/delete/{project}",name="project_delete")
     */

    public function delete(Project $project)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('list_projects');
    }

    /**
     * @Route("/project/{project}/update",name="project_update")
     */

    public function update(Request $request, Project $project, ValidatorInterface $validator)
    {
        $project->setTitle($request->get('title'));
        $project->setBody($request->get('body'));

        $errors = $validator->validate($project);

        if(count($errors)>0)
            return $this->render('project/edit.html.twig', ['project' => $project, 'errors'=> $errors]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('list_projects');

    }
}
