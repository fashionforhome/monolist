<?php
/**
 * This is the ..... [Description]
 *
 * @category Monolist
 * @package WatcherBundle
 *
 * @author Tino Stöckel <tino.stoeckel@fashionforhome.de>
 *
 * @copyright (c) 2014 by fashion4home GmbH <www.fashionforhome.de>
 * @license GPL-3.0
 * @license http://opensource.org/licenses/GPL-3.0 GNU GENERAL PUBLIC LICENSE
 *
 * @version 1.0.0
 *
 * Date: 03.11.2014
 * Time: 22:04
 */
namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Monolist\Bundle\WatcherBundle\Model\Services\Loader;

class ShowChartController extends Controller
{
	/**
	 * @Route("/", name="_show_chart_index")
	 * @Template()
	 */
	public function indexAction()
	{
		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => ', you are wrong here.'));
	}

	/**
	 * @Route("/hello/{name}", name="_default_hello")
	 * @Template()
	 */
	public function helloAction($name)
	{
		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
	}

	/**
	 * @Route("/single/{metricName}", name="_show_chart_single")
	 * @Template()
	 */
	public function singleAction($metricName)
	{
		return $this->render('MonolistWatcherBundle:Default:single.html.php', array('metricName' => $metricName));
	}

	/**
	 * @Route("/group/{groupName}", name="_show_chart_group")
	 * @Template()
	 * @param $groupName
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function groupAction($groupName)
	{
		$groupMetrics = array();
		$loader = new Loader();
		$groupConfig = $loader->getReportGroupConfig();
		$groupMetrics = $groupConfig[$groupName];

		return $this->render('MonolistWatcherBundle:Default:group.html.php', array('groupName' => $groupName, 'groupMetrics' => $groupMetrics));
	}
}
