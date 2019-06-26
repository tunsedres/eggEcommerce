<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;

class HomeController extends AbstractController
{
    /** @Route("/", name="home_page") */

    public function home()
    {
        $em = $this->getDoctrine()->getManager();

        $blogs = $em->getRepository(Blog::class)->findAll();

        return $this->render('home.html.twig', [
                               'blogs' => $blogs
                            ]);
    }
}
