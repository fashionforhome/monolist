<?php
#namespace Acme\DemoBundle\Command;
namespace Monolist\Bundle\WatcherBundle\Command;

#standard setup
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#Command specific setup
use Monolist\Bundle\WatcherBundle\Entity\WatcherUser;

/**
 * Hello World command for demo purposes.
 *
 * You could also extend from Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
 * to get access to the container via $this->getContainer().
 *
 * @author Tino Stöckel
 */
class WatcherUserCommand extends ContainerAwareCommand
{
	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('monolist:watcherUser')
			->setDescription('Hello World example command')
			->addArgument('name', InputArgument::REQUIRED , 'Name of the user to add.')
			->addArgument('password', InputArgument::REQUIRED , 'Password for the new added user.')
			->setHelp(<<<EOF
The <info>%command.name%</info> command greets somebody or everybody:

<info>php %command.full_name%</info>

The optional argument specifies who to greet:

<info>php %command.full_name%</info> Fabien
EOF
			);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$passwordHash = hash('sha512', $input->getArgument('password'));
		$name = $input->getArgument('name');

		$watcherUser = new WatcherUser();
		$watcherUser->setName($name);
		$watcherUser->setPasswordHash($passwordHash);

		/** @var \Doctrine\Bundle\DoctrineBundle\Registry $doct */
		$doct = $this->getContainer()->get('doctrine');
		$em = $doct->getManager();
		$em->persist($watcherUser);
		$em->flush();

		$output->writeln(sprintf('Name: <comment>%s</comment>!', $watcherUser->getName()));
		$output->writeln('Created WatcherUser id: '.$watcherUser->getId());
	}
}
