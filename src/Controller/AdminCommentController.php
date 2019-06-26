<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="admin_list_comments")
     */
    public function index()
    {
        //list all comments
        $commentEntity = $this->getDoctrine()->getRepository(Comment::class);

        return $this->render('admin/comment/index.html.twig', ['comments'=>$commentEntity->findAll()]);
    }

    /**
     * @Route("/admin/comments/delete/{comment}",name="comment_delete")
     */

    public function delete(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('admin_list_comments');
    }


}
