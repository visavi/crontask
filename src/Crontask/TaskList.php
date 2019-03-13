<?php

namespace Crontask;

use Crontask\Interfaces\TaskInterface;

class TaskList
{
    /**
     * @var array
     */
    protected $tasks = [];

    /**
     * @var array
     */
    protected $output = [];

    /**
     * Create new tasks list
     *
     * @param array $tasks
     */
    public function addTasks($tasks)
    {
        foreach ($tasks as $task) {
            $this->addTask($task);
        }
    }

    /**
     * Adds a new task to the list
     *
     * @param TaskInterface $task
     * @return TaskList $this
     */
    public function addTask(TaskInterface $task): TaskList
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Set tasks
     *
     * @param array $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Get Tasks
     *
     * @return array
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * Get required tasks
     *
     * @return array
     */
    public function getTasksRequired(): array
    {
        return array_filter($this->tasks, function (TaskInterface $task) {
            return $task->isRequired();
        });
    }

    /**
     * Get Output
     *
     * @return array
     */
    public function getOutput(): array
    {
        return $this->output;
    }

    /**
     * Runs any due task, returning an array containing the output from each task
     *
     * @return array
     */
    public function run(): array
    {
        $this->output = [];

        foreach ($this->getTasksRequired() as $task) {
            $result = $task->run();
            $this->output[] = [
                'task'   => get_class($task),
                'output' => $task->getOutput(),
                'result' => $result,
            ];
        }

        return $this->output;
    }
}
