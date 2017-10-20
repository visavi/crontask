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
    public function addTask(TaskInterface $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Get Tasks
     *
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Get Output
     *
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Runs any due task, returning an array containing the output from each task
     *
     * @return array
     */
    public function run()
    {
        $this->output = [];

        foreach ($this->tasks as $task) {
            if ($task->isRequired()) {

                $result = $task->run();

                $this->output[] = [
                    'task'   => get_class($task),
                    'output' => $task->getOutput(),
                    'result' => $result,
                ];
            }
        }

        return $this->output;
    }
}
