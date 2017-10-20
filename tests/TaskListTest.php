<?php

use Crontask\TaskList;
use Crontask\Tasks\Task;
use PHPUnit\Framework\TestCase;

class TaskListTest extends TestCase
{

    public function testAddTask()
    {
        $stubTask = $this->getMockForAbstractClass(Task::class);
        $stubTask->expects($this->any())
            ->method('run')
            ->will($this->returnValue('task 1'));

        $taskList = new TaskList();
        $taskList->addTask($stubTask);

        $this->assertContains($stubTask, $taskList->getTasks());
    }

    public function testSetTasks()
    {
        $stubTask1 = $this->getMockForAbstractClass(Task::class);
        $stubTask1->expects($this->any())
            ->method('run')
            ->will($this->returnValue('task 1'));

        $stubTask2 = $this->getMockForAbstractClass(Task::class);
        $stubTask2->expects($this->any())
            ->method('run')
            ->will($this->returnValue('task 2'));

        $taskList = new TaskList();
        $taskList->addTasks([$stubTask1, $stubTask2]);

        $this->assertContains($stubTask1, $taskList->getTasks());
        $this->assertContains($stubTask2, $taskList->getTasks());
    }

    public function testRun()
    {
        $stubTask1 = $this->getMockBuilder(Task::class)->getMock();
        $stubTask1->expects($this->any())->method('run')->will($this->returnValue('result 1'));
        $stubTask1->expects($this->any())->method('getOutput')->will($this->returnValue('output 1'));
        $stubTask1->expects($this->any())->method('isRequired')->will($this->returnValue(true));

        $stubTask2 = $this->getMockBuilder(Task::class)->getMock();
        $stubTask2->expects($this->any())->method('run')->will($this->returnValue('result 2'));
        $stubTask2->expects($this->any())->method('getOutput')->will($this->returnValue('output 2'));
        $stubTask2->expects($this->any())->method('isRequired')->will($this->returnValue(true));

        $taskList = new TaskList();
        $taskList->addTasks([$stubTask1, $stubTask2]);
        $taskList->run();

        $output = $taskList->getOutput();

        $this->assertCount(2, $output);
        $this->assertEquals('output 1', $output[0]['output']);
        $this->assertEquals('output 2', $output[1]['output']);
    }
}
