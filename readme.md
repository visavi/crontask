Cron tasks
============

[![Total Downloads](https://poser.pugx.org/visavi/crontask/downloads)](https://packagist.org/packages/visavi/crontask)
[![Latest Stable Version](https://poser.pugx.org/visavi/crontask/v/stable)](https://packagist.org/packages/visavi/crontask)
[![Latest Unstable Version](https://poser.pugx.org/visavi/crontask/v/unstable)](https://packagist.org/packages/visavi/crontask)
[![License](https://poser.pugx.org/visavi/crontask/license)](https://packagist.org/packages/visavi/crontask)

Introduction
------------

This package contains a simple PHP cron task scheduler that helps you version control your cron jobs.

Requirements
------------

This library package requires PHP 7.0 or later

Installation
------------

### Installing via Composer

The recommended way to install crontask is through
[Composer](http://getcomposer.org).

Next, run the Composer command to install the latest version of crontask:

```bash
composer require visavi/crontask
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

$taskList = new \Crontask\TaskList();

// Add task to run at 12:00 every day
$taskList->addTask((new HelloDailyTask)->setExpression('12 0 * * *'));

// Add task to run every hour
$taskList->addTask((new HelloDailyTask)->setExpression('@hourly'));

// Add task to run at 12:00 every Monday
$taskList->addTask((new ShellMondayTask)->setExpression('12 0 * * 1'));

// or
$taskList->addTasks([
    (new HelloDailyTask)->setExpression('12 0 * * 1'),
    (new HelloDailyTask)->setExpression('@hourly'),
    (new ShellMondayTask)->setExpression('12 0 * * 1'),
]);

$taskList->run();
```

CRON Expressions
----------------

A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:

    *    *    *    *    *
    -    -    -    -    -
    |    |    |    |    |
    |    |    |    |    |
    |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
    |    |    |    +---------- month (1 - 12)
    |    |    +--------------- day of month (1 - 31)
    |    +-------------------- hour (0 - 23)
    +------------------------- min (0 - 59)

Mappings
--------
```
@yearly   => 0 0 1 1 *
@annually => 0 0 1 1 *
@monthly  => 0 0 1 * *
@weekly   => 0 0 * * 0
@daily    => 0 0 * * *
@hourly   => 0 * * * *
```

### License

The class is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
