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
        $previousMonth = new \DateTime('last month');
        $url = sprintf('https://api.github.com/search/repositories?q=created:>%s&sort=stars&order=desc', $previousMonth->format('Y-m-d'));
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
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        dump($response);exit;


        $data = '{
            "name": "Aragorn",
            "race": "Human"
        }';

        $data = file_get_contents($url);
        $wizards = json_decode($data, true);
        exit;

        $character = json_decode($data);
        echo $character->name;exit;


        $json = file_get_contents($url);
        $obj = json_decode($json);
        print_r($obj);exit;


        //https://api.github.com/search/repositories?q=created:>2017-10-22&sort=stars&order=desc
        //https://api.github.com/search/repositories?q=created:>2017-10-22&sort=stars&order=desc&page=2


        return $this->render('default/index.html.twig');
    }
}
