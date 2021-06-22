<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Entity\History;

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
            'top_cities' => $this->getTopCities()
        ]);
    }

    public function getSrcIframe(City $city)
    {
        return "https://www.google.com/maps/embed/v1/place?key=AIzaSyDfKPgMBNSQNv9A7EoHe1bsqAd3NWKEzHY&q={$city->getName()} {$city->getState()} {$city->getCountry()}&center={$city->getLat()},{$city->getLon()}&zoom=5";
    }

    public function getTopCities()
    {
        $cities = [];
        $cities_ids = $this->getParameter('top_cities');
        $repo = $this->getDoctrine()->getManagerForClass(City::class)->getRepository(City::class);

        foreach ($cities_ids as $key => $owm_id)
        {
            $city = $repo->findOneBy(['owm_id' => $owm_id]);
            $city->src = $this->getSrcIframe($city);
            $cities[] = $city;
        }
        return $cities;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function checkWeather(Request $request): Response
    {
        $repo = $this->getDoctrine()->getManagerForClass(City::class)->getRepository(City::class);
        /** @var City $city */
        $city = $repo->findOneBy(['owm_id' => $request->attributes->get('city')]);
        $city->src = $this->getSrcIframe($city);

        return $this->render('weatherchecker/checkweather.html.twig', [
            'city' => $city,
            'history' => $city->getHistories()->getValues(),
        ]);
    }
}
