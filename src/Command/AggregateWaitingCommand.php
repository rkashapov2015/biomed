<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 09.10.18
 * Time: 14:26
 */

namespace App\Command;

use App\Entity\Common\QueueWaiting;
use App\Entity\Hello\Call;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class AggregateWaitingCommand extends Command
{
    protected $manager;

    public function __construct($name = null, ManagerRegistry $manager)
    {
        $this->manager = $manager;
        parent::__construct($name);
    }
    protected function configure()
    {
        $this->setName('app:helloasterisk-queue-waiting')
            ->setDescription('Get info for queue waiting from helloasterisk')
            ->setHelp('Get info for queue waiting from helloasterisk');

        $this->addArgument('date', InputArgument::REQUIRED, 'Date for query');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dateStr = $input->getArgument('date');
        $output->writeln('date: ' . $dateStr);

        $dt = new \DateTime($dateStr);
        $dt->setTime(0,0,0);
        $rows = $this->manager
            ->getRepository(Call::class, 'helloasterisk')
            ->prepareWaitingData($dt);


        $items = 0;
        foreach ($rows as $row) {

            $models = $this->manager->getRepository(QueueWaiting::class)->findBy(['time_point' => (new \DateTime($row['time_point']))]);
            $queueInfo = new QueueWaiting();
            if (!empty($models)) {
                if ($models[0]->getMaxQueue() != $row['max_queue'] && $models[0]->getAvgQueue() != $row['avg_queue']) {
                    $queueInfo = $models[0];
                } else {
                    continue;
                }

            }

            $queueInfo->setTimePoint((new \DateTime($row['time_point'])));
            $queueInfo->setAvgQueue($row['avg_queue']);
            $queueInfo->setMaxQueue($row['max_queue']);
            $this->manager->getManager()->persist($queueInfo);
            $this->manager->getManager()->flush();
            $items++;
        }
        $output->writeln('Items :' . $items);
    }
}