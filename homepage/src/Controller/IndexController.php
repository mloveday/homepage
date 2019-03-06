<?php

namespace App\Controller;

use App\Entity\CV\CV;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController {

    /** @Route("/") */
    public function index() {
        return $this->render('index/index.html.twig', []);
    }
    /** @Route("/cv") */
    public function cv() {
        $cv = CV::myCv();
        return $this->render('index/cv.html.twig', [
            'cv' => $cv,
        ]);
    }
}