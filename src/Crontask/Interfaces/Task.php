<?php
namespace Crontask\Interfaces;

interface Task
{
    public function run();
    public function getExpression();
    public function getOutput();
    public function isRequired();
}
