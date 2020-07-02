<?php

declare(strict_types=1);

namespace webignition\SingleCommandApplicationFactory\Tests\Unit;

use Closure;
use PHPUnit\Framework\TestCase;
use ReflectionFunction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\SingleCommandApplication;
use webignition\ObjectReflector\ObjectReflector;
use webignition\SingleCommandApplicationFactory\Factory;

class FactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $command = new Command('command name');
        $version = 'version';

        $application = (new Factory())->create($command, $version);

        self::assertInstanceOf(SingleCommandApplication::class, $application);

        self::assertSame($command->getName(), $application->getName());
        self::assertSame($command->getDefinition(), $application->getDefinition());

        $code = ObjectReflector::getProperty($application, 'code', Command::class);

        self::assertInstanceOf(Closure::class, $code);

        $codeReflectionFunction = new ReflectionFunction($code);
        $codeStaticVariables = $codeReflectionFunction->getStaticVariables();
        $closureCommand = $codeStaticVariables['command'];

        self::assertInstanceOf(Command::class, $closureCommand);
        self::assertSame($command, $closureCommand);
    }
}
