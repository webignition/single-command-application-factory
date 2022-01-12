<?php

declare(strict_types=1);

namespace webignition\SingleCommandApplicationFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

class Factory
{
    public function create(Command $command, string $version): SingleCommandApplication
    {
        $application = new SingleCommandApplication();
        $application->setName((string) $command->getName());
        $application->setDefinition($command->getDefinition());

        $application
            ->setVersion($version)
            ->setCode(function (InputInterface $input, OutputInterface $output) use ($command) {
                return $command->run($input, $output);
            })
        ;

        return $application;
    }
}
