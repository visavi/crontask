<?php

use Crontask\Tasks\Shell;
use PHPUnit\Framework\TestCase;

class ShellTest extends TestCase
{
    public function testSetCommand()
    {
        $command = "echo Hello World";
        $shellTask = new Shell();
        $shellTask->setCommand($command);

        $this->assertEquals($command, $shellTask->getCommand());
    }

    public function testAddArgument()
    {
        $shellTask = new Shell();
        $shellTask->addArgument('command argument 1');

        $this->assertEquals(['command argument 1'], $shellTask->getArguments());
    }

    public function testRun()
    {
        $shellTask = new Shell();
        $shellTask->setCommand("echo Hello World");
        $shellTask->run();

        $this->assertContains('Hello World', $shellTask->getOutput());
    }
}
