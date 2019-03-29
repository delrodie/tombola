<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Tombola;
use AppBundle\Repository\TombolaRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/recherche", name="recherche")
     * @Method("GET")
     */
    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $code = $request->get('code');

        $resultats = $em->getRepository('AppBundle:Tombola')->findByCode(strtolower($code));

        if (!$resultats){
            $resultat['resultats']['error'] = "<span style='font-size: 1.4em;'>Désolé!! </span><br>,<br> Votre code n'a pas été tiré à cette premiere phase. <br><br> Toutefois conservez le soigneusement pour le second tirage.<br><br> Bonne Chance!";
        } else{
            $resultat['resultats'] = $this->getRealCodes($resultats);
        }

        return new Response(json_encode($resultat));
    }

    public function getRealCodes($resultats)
    {
        foreach ($resultats as $resultat){
            $realCodes[$resultat->getId()] = $resultat->getCode();
        }

        return $realCodes;
    }

    /**
     * @Route("/tombola/{id}-premier-tirage", name="resultat")
     * @Method("GET")
     */
    public function resultatAction(Tombola $tombola)
    {
        return $this->render('default/resultat.html.twig',[
            'tombola' => $tombola,
        ]);
    }
}
