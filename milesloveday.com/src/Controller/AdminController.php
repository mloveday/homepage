<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\CurriculumVitae;
use App\Forms\BlogPostType;
use App\Forms\CVType;
use App\Model\Roadmap\RoadmapEntity;
use App\Repository\BlogPostRepository;
use App\Repository\CurriculumVitaeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @Route("/admin") */
class AdminController extends AbstractController {
    /** @Route("/cv", name="admin_cv") */
    public function index(Request $request, CurriculumVitaeRepository $curriculumVitaeRepository) {

        $cv = $curriculumVitaeRepository->findMostRecentCv();
        $form = $this->createForm(CVType::class, $cv);

        if ($request->getMethod() === Request::METHOD_GET) {

            return $this->render('admin/form.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /** @Route("/blog/new", name="admin_blog_new") */
    public function blogNew(Request $request, BlogPostRepository $blogPostRepository) {

        // we don't want to post until we're ready
        $blogPost = (new BlogPost())->setArchived(true);
        $form = $this->createForm(BlogPostType::class, $blogPost);

        if ($request->getMethod() === Request::METHOD_GET) {

            return $this->render('admin/form.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($blogPost);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_blog_edit', ['slug' => $blogPost->getSlug()]);
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /** @Route("/blog/{slug}", name="admin_blog_edit") */
    public function blogEdit(string $slug, Request $request, BlogPostRepository $blogPostRepository) {

        $blogPost = $blogPostRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(BlogPostType::class, $blogPost);

        if ($request->getMethod() === Request::METHOD_GET) {

            return $this->render('admin/form.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        if ($blogPost->getSlug() !== $slug) {
            return $this->redirectToRoute('admin_blog_edit', ['slug' => $blogPost->getSlug()]);
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}