<?php

namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Route("/hello/{name}", name="_default_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
    }
}
