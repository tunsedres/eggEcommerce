<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Events\BlogCreated;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminBlogController extends AbstractController
{
    /**
     * @Route("/admin/blog/create", name="create_blog")
     */
    public function create()
    {
        return $this->render('admin/blog/edit.html.twig', ['blog' => new Blog(), 'type'=>'Create']);
    }

    /**
     * @Route("/blog/save", name="store_blog", methods={"POST"})
     */

    public function store(Request $request, ValidatorInterface $validator, EventDispatcherInterface $eventDispatcher)
    {
        $blog = new Blog();

        $blog->setTitle($request->get('title'));
        $blog->setBody($request->get('body'));
        $blog->setUser($this->getUser());

        $errors = $validator->validate($blog);

        if(count($errors)>0)
            return $this->render('admin/blog/edit.html.twig', ['errors'=>$errors, 'type'=>'Create', 'blog'=> new Blog()]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);
        $em->flush();

        return $this->redirectToRoute('admin_list_blogs');
    }

    /**
     * @Route("/admin/blog", name="admin_list_blogs")
     */

    public function index()
    {
        $blogEntity = $this->getDoctrine()->getRepository(Blog::class);

        return $this->render('admin/blog/list.html.twig', ['blogs'=>$blogEntity->findAll()]);
    }

    /**
     * @Route("/admin/blog/{blog}/edit",name="blog_edit")
     */

    public function edit(Blog $blog)
    {
        return $this->render('admin/blog/edit.html.twig', ['blog' => $blog, 'type' => 'Edit']);
    }

    /**
     * @Route("/admin/blog/delete/{blog}",name="blog_delete")
     */

    public function delete(Blog $blog)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute('admin_list_blogs');
    }

    /**
     * @Route("/admin/blog/{blog}/update",name="blog_update", methods={"POST"})
     */

    public function update(Request $request, Blog $blog, ValidatorInterface $validator)
    {
        $blog->setTitle($request->get('title'));
        $blog->setBody($request->get('body'));
        $blog->setUpdatedAt(new \DateTime());

        $errors = $validator->validate($blog);

        if(count($errors)>0)
            return $this->render('admin/blog/edit.html.twig', ['blog' => $blog, 'errors'=> $errors]);


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('admin_list_blogs');

    }
}
