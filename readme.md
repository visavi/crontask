Cron tasks
============

Introduction
------------

This package contains a simple PHP cron task scheduler that helps you version control your cron jobs.

Requirements
------------

This library package requires PHP 7.0 or later

Installation
------------

### Installing via Composer

The recommended way to install php-scheduler is through
[Composer](http://getcomposer.org).

Next, run the Composer command to install the latest version of php-scheduler:

```bash
composer require visavi/cron-tasks
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

Once you've created your task list script (see Usage below) open a linux shell add the following line to crontab (crontab -e):

```
* * * * * php /path/cron.php
``` 

Usage
-----

The following example shows how to schedule a HelloDaily task (simple echo example) and a ShellMonday task (running a shell task example).

```php
class HelloDailyTask extends \Crontask\Tasks\Task
{
    public function run()
    {
        $this->setOutput('Hello World');
    }
}

class ShellMondayTask extends \Crontask\Tasks\Shell
{
    protected $command = "echo Hello Monday";
}

$taskList = new \Crontask\TaskList;

// Add task to run at 15:04 every day
$taskList->addTask((new HelloDailyTask)->setExpression('4 15 * * *'));

// Add task to run at 15:04 every Monday
$taskList->addTask((new ShellMondayTask)->setExpression('4 15 * * 1'));

$taskList->run();

$output = $taskList->getOutput();
```


