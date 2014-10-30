<?php

namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//for config load
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Finder\Finder;

use Aws\CloudWatch\CloudWatchClient;

use Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch\CloudWatch;
use Monolist\Bundle\WatcherBundle\Entity\CloudWatch_UnHealthyHostCount;

class OverviewController extends Controller
{
	/**
	 * @Route("/", name="_overview")
	 * @Template()
	 */
	public function indexAction()
	{
		//app/config/config.yml::parameters.aws
		$awsConfig = $this->container->getParameter('aws');
		//var_dump($awsConfig['user_id']);die;
		//aws stuff
		$client = CloudWatchClient::factory(array(
			'key'    => $awsConfig['access_key'],           //'YOUR_AWS_ACCESS_KEY_ID',
			'secret' => $awsConfig['secret_key'],           //'YOUR_AWS_SECRET_ACCESS_KEY',
			'region'  => 'eu-west-1',
		));
		$result = $client->listMetrics(array(
			'Namespace' => 'AWS/ELB',
			'MetricName' => 'UnHealthyHostCount',
//			'Dimensions' => array(
//				array(
//					// Name is required
//					'Name' => 'string',
//					'Value' => 'string',
//				),
//				// ... repeated
//			),
//			'NextToken' => 'string',
		));
//		var_dump($result);die;
//		$iterator = $client->getIterator('ListMetrics', array(
//			'Namespace' => 'AWS/ELB'
//		));
//		foreach ($iterator as $metric) {
//			echo $metric['MetricName'];
//			echo '<br />';
//			echo '<br />';
//			var_dump($metric);
//			echo '<br />';
//			echo '<br />';
//		} die;


		//app/config/
		$collectsConfig = $this->container->getParameter('collects');
		$first = array_pop( $collectsConfig );
		var_dump(new $first['requestor_class']); die;

		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $this->container->getParameter('aws') . ' overview!'));
	}

	/**
	 * @Route("/hello/{name}", name="_overview_hello")
	 * @Template()
	 */
	public function helloAction($name)
	{
		$cwEnt = new CloudWatch_UnHealthyHostCount();
		$cwEnt->setValue(0);
		$cwEnt->setTimestamp(time());
		$cwEnt->setIdentifier('test');

		/** @var \Doctrine\Bundle\DoctrineBundle\Registry $doct */
		$doct = $this->get('doctrine');
		$em = $doct->getManager();
		$em->persist($cwEnt);
		$em->flush();
		die;


		$cloudWatch = new CloudWatch();
//		var_dump($cloudWatch->getDir());die;

		$kernel = $this->get('kernel');
//		$path = $kernel->locateResource('@MonolistWatcherBundle/Model/Services/CloudWatch/Metrics/SingleMetric/config/metrics.yml');
		$path = $cloudWatch->getDir() . '/Metrics/SingleMetric/config/metrics.yml';
		$yaml = new Parser();
		$value = $yaml->parse(file_get_contents($path));
//		var_dump($value);

		$finder = new Finder();
		$finderPath = $cloudWatch->getSingleMetricsConfigPath();
		$finder->files()->in($finderPath);
		foreach ($finder as $file) {
			// Print the absolute path
			print $file->getRealpath()."\n";

			// Print the relative path to the file, omitting the filename
			print $file->getRelativePath()."\n";

			// Print the relative path to the file
			print $file->getRelativePathname()."\n";
		}
		die;

		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
	}
}
