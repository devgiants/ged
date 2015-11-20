<?php

namespace devgiants\ged\DocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function addDocumentsAction()
    {
        return $this->render('devGiantsGedDocumentBundle:Default:add.html.twig',
            array()
        );
    }

    public function searchDocumentsAction()
    {
        return $this->render('devGiantsGedDocumentBundle:Default:search.html.twig',
            array()
        );
    }
}
