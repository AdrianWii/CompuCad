<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/homepage", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this e xample code with whatever you need
        return $this->render('default/index.html.twig');
    }
}
