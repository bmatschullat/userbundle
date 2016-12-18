<?php
/**
 * @author Bennet Matschullat, Marketline GmbH <b.matschullat@marketline.de>
 * @date 23.06.2016 - 09:36
 * @github <bmatschullat>
 * @project - PhpStorm
 */

namespace Dreimweb\UserBundle\Command;



use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:sendmails')
            ->setDescription('Send all Mails from que')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$this->denyAccessUnlessGranted(['ROLE_DEVELOPER'], null, 'Unzureichende Rechte fuer diese Seite');
	    $repo = $this->getContainer()->get('doctrine');
	    $logger = $this->getContainer()->get('logger');
	    $manager = $repo->getManager();
	    $mails = $repo->getRepository('DreimwebUserBundle:Email')->findBy(['flagstate' => 0]);

	    /** @var Email $mail */
	    foreach ($mails as $mail) {
		    $mail->setFlagstate(true);
		    $message = \Swift_Message::newInstance()
			    ->setSubject($mail->getSubject())
			    ->setFrom('noreply@appname.de', 'appname')
			    ->setReplyTo('info@appname.de')
			    ->setTo($mail->getReceiver())
			    ->setBody($mail->getBodyMessage(), 'text/html');
		    $type = $message->getHeaders()->get('Content-Type');

		    $output->writeln(sprintf('mail "%s" to "%s"', $mail->getSubject(), $mail->getReceiver()));
		    $type->setValue('text/html');
		    $type->setParameter('charset', 'utf-8');

		    // push to the logger
		    $logger->info(sprintf('mail "%s" to "%s"', $mail->getSubject(), $mail->getReceiver()));

		    $this->getContainer()->get('mailer')->send($message);
		    $manager->persist($mail);
	    }


	    $manager->flush();
		$output->writeln('OK');
    }
}