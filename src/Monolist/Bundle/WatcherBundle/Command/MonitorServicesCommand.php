<?php
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