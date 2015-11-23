<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/11/15
 * Time: 08:24
 */

namespace devgiants\ged\DocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploadController extends Controller
{
    public function UploadDocumentAction($fileName)
    {
        $uploadHandler = $this->get('devgiants.ged.document.upload');
        $uploadHandler->setFileInfo($fileName);

        $result = $uploadHandler->handleUpload("{$this->get('kernel')->getRootDir()}/media/");

        if (!$result) {
            $return = array('success' => false, 'msg' => $uploadHandler->getErrorMsg());
        }
        else $return = array('success' => true);

        return new JsonResponse($return);
    }
}
