<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Route as RouteFromCollection;
use Symfony\Component\Routing\RouterInterface;

class SitemapController extends AbstractController {

    /** @Route("/sitemap.txt", name="sitemap") */
    public function sitemap(RouterInterface $router) {
        $routeCollection = $router->getRouteCollection();
        if (is_null($routeCollection)) {
            return $this->render('');
        }
        $routes = array_filter($routeCollection->all(), function (RouteFromCollection $route) { return substr($route->getPath(), 0, 2) !== '/_';});

        return new Response(
            'https://milesloveday.com' . implode("\nhttps://milesloveday.com", array_map(function (RouteFromCollection $route) { return $route->getPath();}, $routes)),
            Response::HTTP_OK,
            ['content-type' => 'text']
            );
    }
}