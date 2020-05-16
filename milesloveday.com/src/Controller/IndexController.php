<?php

namespace App\Controller;

use App\Model\Roadmap\RoadmapEntity;
use App\Repository\BlogPostRepository;
use App\Repository\CurriculumVitaeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends AbstractController {

    /** @Route("/", name="index") */
    public function index(BlogPostRepository $blogPostRepository) {
        $blogPosts = $blogPostRepository->getList(false);
        return $this->render('index/index.html.twig', ['blogPosts' => $blogPosts]);
    }

    /** @Route("/dashboard", name="dashboard") */
    public function dashboard() {
        return $this->render('index/dashboard.html.twig', []);
    }

    /** @Route("/blog", name="blogs") */
    public function blogs(BlogPostRepository $blogPostRepository) {
        $blogPosts = $blogPostRepository->getList($this->getUser() !== null);
        return $this->render('index/blog.html.twig', ['blogPosts' => $blogPosts]);
    }

    /** @Route("/blog/{slug}", name="blog") */
    public function blog(string $slug, BlogPostRepository $blogPostRepository) {
        $blogPost = $blogPostRepository->getBySlug($slug, $this->getUser() !== null);
        if (!$blogPost) {
            throw new NotFoundHttpException('Blog post not found');
        }
        return $this->render('index/blog-post.html.twig', ['blog_post' => $blogPost]);
    }

    /** @Route("/cv", name="cv") */
    public function cv(CurriculumVitaeRepository $curriculumVitaeRepository) {
        $cv = $curriculumVitaeRepository->findMostRecentCv();
        return $this->render('index/cv.html.twig', [
            'cv' => $cv,
        ]);
    }

    /** @Route("/react-form-example", name="react-form-example") */
    public function reactFormExample()
    {
        return $this->render('index/react-form-example.html.twig');
    }
}