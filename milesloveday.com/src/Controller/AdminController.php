<?php

namespace App\Controller;

use App\Entity\CurriculumVitae;
use App\Forms\CVType;
use App\Model\Roadmap\RoadmapEntity;
use App\Repository\CurriculumVitaeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @Route("/admin") */
class AdminController extends AbstractController {
    /** @Route("/", name="admin_index") */
    public function index(Request $request, CurriculumVitaeRepository $curriculumVitaeRepository) {

        $cv = $curriculumVitaeRepository->findMostRecentCv();
        $form = $this->createForm(CVType::class, $cv);

        if ($request->getMethod() === Request::METHOD_GET) {

            return $this->render('admin/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}