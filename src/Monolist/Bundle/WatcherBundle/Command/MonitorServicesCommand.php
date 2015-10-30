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
 * Date: 04.11.2014
 * Time: 22:04
 */
namespace Monolist\Bundle\WatcherBundle\Command;

#standard setup
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#command specific setup
use Monolist\Bundle\WatcherBundle\Model\Services\Loader;

/**
 * Command for start the requests for all metrics of all services.
 *
 * @author Tino Stöckel
 */
class MonitorServicesCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('monolist:monitor:services')
			->setDescription('Starts to request all metrics of all registered services.')
			->setHelp('The <info>%command.name%</info> command needs no parameters.');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<info>Script is starting</info>');

		$loader = new Loader();
		$services = $loader->getServices();

		foreach ($services as $service) {
			$service->collectAndSaveSingleMetrics();
		}

		$output->writeln('<info>Script is done.</info>');
	}
} 