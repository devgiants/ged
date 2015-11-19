<?php

namespace devgiants\ged\DocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('devGiantsGedDocumentBundle:Default:index.html.twig', array('name' => $name));
    }
}
