<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page') ? $request->get('page') : 1;

        $previousMonth = new \DateTime('last month');
        $url = sprintf('https://api.github.com/search/repositories?q=created:>%s&sort=stars&order=desc&page=%s', $previousMonth->format('Y-m-d'), $page);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
            CURLOPT_USERAGENT => 'User-Agent: Awesome-Octocat-App'
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response);
        return $this->render('default/item.html.twig', ['items' => $result->items, 'page' => $page]);
    }
}
