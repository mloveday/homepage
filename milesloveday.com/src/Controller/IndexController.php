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
    public function index() {
        return $this->render('index/index.html.twig', []);
    }

    /** @Route("/dashboard", name="dashboard") */
    public function dashboard() {
        return $this->render('index/dashboard.html.twig', []);
    }

    /** @Route("/blog/{slug}", name="blog") */
    public function blog(string $slug, BlogPostRepository $blogPostRepository) {
        $blogPost = $blogPostRepository->getBySlug($slug, $this->getUser() !== null);
        if (!$blogPost) {
            throw new NotFoundHttpException('Blog post not found');
        }
        return $this->render('index/blog-post.html.twig', ['blog_post' => $blogPost]);
    }

    /** @Route("/gallery", name="gallery") */
    public function gallery() {
        return $this->render('index/gallery.html.twig', []);
    }

    /** @Route("/cv", name="cv") */
    public function cv(CurriculumVitaeRepository $curriculumVitaeRepository) {
        $cv = $curriculumVitaeRepository->findMostRecentCv();
        return $this->render('index/cv.html.twig', [
            'cv' => $cv,
        ]);
    }

    /** @Route("/roadmap", name="roadmap") */
    public function roadmap() {
        $todo = [
            new RoadmapEntity('Complete roadmap page', 'Currently incomplete', [
                new RoadmapEntity('Content', 'Requires some meaningful stuff putting into it.'),
                new RoadmapEntity('Styling', 'Currently looks rubbish.'),
            ]),
            new RoadmapEntity('About page / contact', 'Quite important.', [
                new RoadmapEntity('Content','Write small amount of copy for page', []),
                new RoadmapEntity('Contact','Add contact details', []),
            ]),
            new RoadmapEntity('Examples of work', 'Examples of projects worked on', [
                new RoadmapEntity('Content','Create some pages, work out how best to show content (iframe? subdomain? just in current page)', []),
                new RoadmapEntity('Plough dashboard', 'Full-React project including routing - iframe or subdomain', [
                    new RoadmapEntity('Sustainability', 'Reduce opportunity to add lots of data - cron job to delete more than a couple of weeks? Limit numbers of entities?', []),
                    new RoadmapEntity('Data', 'Remove any existing migrations', []),
                    new RoadmapEntity('Accessibility', 'Remove requirement to login', []),
                ]),
                new RoadmapEntity('Adventure game thingy', 'Probably needs a lot of work to get it looking shiny', [
                    new RoadmapEntity('Technical', 'Currently parses files badly', []),
                    new RoadmapEntity('Styling', 'Annoying styling with headers/footers', []),
                ]),
            ]),
            new RoadmapEntity('Photography', 'Page for my photos', [
                new RoadmapEntity('Public gallery', 'Some low res photos', []),
                new RoadmapEntity('Private gallery', 'Show albums, allow viewing & downloading according to user', [
                    new RoadmapEntity('User control', 'Assign roles to users', []),
                    new RoadmapEntity('Shareable links', 'For sharing without login, time-limited', []),
                ]),
            ]),
        ];
        $complete = [
            new RoadmapEntity('Homepage', 'Create a homepage', [
            ]),
            new RoadmapEntity('CV', 'Create a CV', [
            ]),
            new RoadmapEntity('Optimise the site', 'Tech stuff to make the site load quickly and look reasonable', [
                new RoadmapEntity('Assets', 'Reduce render-blocking assets', []),
                new RoadmapEntity('Scripts', 'Go lightweight - no need for heavyweight SPA-style stuff', []),
            ]),
        ];
        return $this->render('index/roadmap.html.twig', [
            'roadmapsToBeDone' => $todo,
            'roadmapsCompleted' => $complete,
        ]);
    }
}