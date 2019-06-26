<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{id}", name="blog_detail")
     */
    public function show(Blog $blog)
    {
        return $this->render('blog/index.html.twig', [
            'blog' => $blog,
        ]);
    }
}
