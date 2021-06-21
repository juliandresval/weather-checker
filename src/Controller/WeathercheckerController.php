<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Entity\Ciudad;
use App\Repository\CityRepository;
use App\Repository\CiudadRepository;

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

    public function getTopCities()
    {
        $cities = [];
        $cities_ids = $this->getParameter('top_cities');
        $repo = $this->getDoctrine()
            ->getManagerForClass(Ciudad::class)
            ->getRepository(Ciudad::class)
        ;
        foreach ($cities_ids as $key => $city)
        {
            $city = $repo->findOneByExternalId($city);
            $city->src = "https://www.google.com/maps/embed/v1/place?key=AIzaSyDfKPgMBNSQNv9A7EoHe1bsqAd3NWKEzHY&q={$city->getName()} {$city->getState()} {$city->getCountry()}&center={$city->getLat()},{$city->getLon()}&zoom=5";
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
        echo_var($request->attributes->all());
        echo_var($request->query->all());
        echo_var($request->request->all());
        echo_var($request->getRequestUri());
        echo_var($request->getQueryString());
        exit();
    }

    public function populateCiudadesTable(Request $request): Response
    {
        $em = $this->getDoctrine()->getManagerForClass(City::class);
        $i = 0;

        // cities 209579
        $cities_file = realpath(__DIR__ . '/../../public/uploads/openweathermap/city.list.json');
        $cities = json_decode(file_get_contents($cities_file), true);

        foreach ($cities as $key => $item)
        {
            if (in_array($item['country'], ['US','MX','CO','ES','EN','UK','BR','VE','AR']))
            {
                $i++;
                $City = new Ciudad();
                $City->setName($item['name']);
                $City->setExternalId(is_array($item['id']) ? array_values($item['id'])[0] : $item['id']);
                $City->setCountry($item['country']);
                $City->setLon(is_array($item['coord']['lon']) ? array_values($item['coord']['lon'])[0] : $item['coord']['lon']);
                $City->setLat(is_array($item['coord']['lat']) ? array_values($item['coord']['lat'])[0] : $item['coord']['lat']);
                $City->setState($item['state']);
                $City->setFindname(null);

                $em->persist($City);

                if ($i >= 50)
                {
                    echo_var("i: {$i}, se prepara para hacer flush a base de datos en {$City->getName()}");
                    $em->flush();
                    $em->clear();
                    $i = 0;
                }
            }
            unset($cities[$key]);
        }
        $em->flush();
        $em->clear();
        exit();

        return $this->render('weatherchecker/test.html.twig', ['method' => __METHOD__,]);
    }

    public function populateCitiesTable(Request $request): Response
    {
        $em = $this->getDoctrine()->getManagerForClass(City::class);
        $i = 0;

        // history 37208
        $history_file = realpath(__DIR__ . '/../../public/uploads/openweathermap/history.city.list.json');
        $history = json_decode(file_get_contents($history_file), true);

        foreach ($history as $key => $item)
        {
            if (in_array($item['city']['country'], ['US','MX','CO','ES','EN','UK','BR','VE','AR']))
            {
                $i++;
                $City = new City();
                $City->setName($item['city']['name']);
                $City->setOwmId($item['id']['$numberLong'] ?? $item['id']);
                $City->setCountry($item['city']['country']);
                $City->setLon(is_array($item['city']['coord']['lon']) ? array_values($item['city']['coord']['lon'])[0] : $item['city']['coord']['lon']);
                $City->setLat(is_array($item['city']['coord']['lat']) ? array_values($item['city']['coord']['lat'])[0] : $item['city']['coord']['lat']);
                $City->setFindname($item['city']['findname']);

                $em->persist($City);

                if ($i >= 50)
                {
                    echo_var("i: {$i}, se prepara para hacer flush a base de datos en {$City->getName()}");
                    $em->flush();
                    $em->clear();
                    $i = 0;
                }
            }
            unset($history[$key]);
        }
        $em->flush();
        $em->clear();
        exit();

        return $this->render('weatherchecker/test.html.twig', ['method' => __METHOD__,]);
    }
}
