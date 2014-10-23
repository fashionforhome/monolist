<?php

namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OverviewController extends Controller
{
	/**
	 * @Route("/", name="_overview")
	 * @Template()
	 */
	public function indexAction()
	{
		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => 'overview!'));
	}

	/**
	 * @Route("/hello/{name}", name="_overview_hello")
	 * @Template()
	 */
	public function helloAction($name)
	{
		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
	}
}
