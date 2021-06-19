<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WeathercheckerController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('weatherchecker/index.html.twig', [
            'controller_name' => 'WeathercheckerController',
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function checkWeather(Request $request): Response
    {
        echo_var($request->attributes->all());
        echo_var($request->query->all());
        echo_var($request->request->all());
        echo_var($request->getRequestUri());
        echo_var($request->getQueryString());
        exit();
    }
}
