<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/save/{blog}", name="comment_save", methods={"POST"})
     */
    public function store(Request $request, ValidatorInterface $validator, Blog $blog)
    {
        $comment = new Comment();

        $comment->setFullName($request->get('fullName'));
        $comment->setEmail($request->get('email'));
        $comment->setUrl($request->get('url'));
        $comment->setComment($request->get('comment'));

        $blog->addComment($comment);

        $errors = $validator->validate($comment);
        if(count($errors)>0)
            return $this->render('/blog/index.html.twig', ['errors'=>$errors, 'blog'=> $blog]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($blog);
        $em->flush();

        $this->addFlash('success', 'Your comment has been added successfully');

        return $this->redirectToRoute('blog_detail', ['id'=> $blog->getId()]);
    }

    /**
     * @Route("/blogs/{user}", name="user_blogs")
     */
    public function getUserBlogs(User $user)
    {
        return $this->render('home.html.twig', [
            'blogs' => $user->getBlogs(),
        ]);
    }
}
