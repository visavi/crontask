<?php
namespace Crontask;

use Crontask\Interfaces\Task as TaskInterface;

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
     * Adds a new task to the list
     * @param TaskInterface $task
     * @return TaskList $this
     */
    public function addTask(TaskInterface $task)
    {
        $this->tasks[] = $task;
        return $this;
    }

    /**
     * @param array $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Runs any due task, returning an array containing the output from each task
     * @return array
     */
    public function run()
    {
        $this->output = [];

        foreach ($this->tasks AS $task) {
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
