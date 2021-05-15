<?php

namespace Crontask\Tasks;

use Cron\CronExpression;
use Crontask\Interfaces\TaskInterface;

abstract class Task implements TaskInterface
{
    /**
     * @var string
     */
    protected $expression;

    /**
     * @var null|string|array
     */
    protected $output;

    /**
     * @return mixed
     */
    abstract public function run();

    /**
     * Sets a cron expression
     *
     * @param string $expression
     * @return Task $this
     */
    public function setExpression($expression): Task
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * Gets the current cron expression
     *
     * @return string
     */
    public function getExpression(): string
    {
        return $this->expression;
    }

    /**
     * Sets the output from the task
     *
     * @param null|string|array $output
     * @return Task $this
     */
    public function setOutput($output): Task
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Gets the output from the task
     *
     * @return null|string|array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Checks whether the task is currently due
     * @return bool
     */
    public function isRequired(): bool
    {
        $expression = $this->getExpression();

        if (! $expression) {
            return false;
        }

        $cron = new CronExpression($expression);

        return $cron->isDue();
    }
}
