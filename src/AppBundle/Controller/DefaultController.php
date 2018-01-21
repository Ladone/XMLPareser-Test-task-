<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CurrencyCode;
use AppBundle\Entity\Currency;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SimpleXMLElement;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {   $em = $this->getDoctrine()->getManager();

        $userDate = $request->query->get('date');

        $date = '';

        // render dates
        if($userDate != null)
        {
            $parseData = date_parse($userDate);
            $date = new \DateTime();
            $date->format('d.m.Y');
            $date->setDate($parseData['year'], $parseData['month'], $parseData['day']);
        }
        else
            $date = new \DateTime('now');

        $currencies = $em->getRepository(Currency::class)->findBy(['date' => $date], ['value' => 'DESC']);

        return [
            'currencies' => $currencies,
            'date' => $date,
        ];
    }
}
