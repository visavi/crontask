<?php

use Crontask\Tasks\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{

    public function testSetExpression()
    {
        /** @var Task $stub */
        $stub = $this->getMockForAbstractClass(Task::class);
        $stub->expects($this->any())
            ->method('run')
            ->will($this->returnValue('example output'));

        $stub->setExpression('1 2 3 4 5');
        $this->assertEquals('1 2 3 4 5', $stub->getExpression());
    }

    public function testIsRequired()
    {
        /** @var Task $stub */
        $stub = $this->getMockForAbstractClass(Task::class);
        $stub->expects($this->any())
            ->method('run')
            ->will($this->returnValue('example output'));

        $stub->setExpression('* * * * *');
        $this->assertTrue($stub->isRequired());

        $stub->setExpression(ltrim(date('i G'), 0).' * * *');
        $this->assertTrue($stub->isRequired());

        $stub->setExpression(ltrim(date('i G', strtotime('-1 minute')), 0).' * * *');
        $this->assertFalse($stub->isRequired());
    }
}
