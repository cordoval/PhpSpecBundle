<?php

namespace Cordova\Bundle\PhpSpecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('CordovaPhpSpecBundle:Default:index.html.twig', array('name' => $name));
    }
}
