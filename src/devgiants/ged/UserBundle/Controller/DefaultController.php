<?php

namespace devgiants\ged\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('devGiantsGedUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
