<?php
namespace Idephix\Console;

use Idephix\Task\Task;
use Symfony\Component\Console\Input\ArrayInput;

class InputFactory
{
    /**
     * @param $arguments
     * @param Task $task
     * @return ArrayInput
     */
    public function buildFromUserArgsForTask($arguments, Task $task)
    {
        $defaultArguments = array();
        $inputArguments = array();

        foreach ($task->userDefinedParameters() as $parameter) {
            if ($parameter->isFlagOption()) {
                $defaultArguments['--' . $parameter->name()] = $parameter->defaultValue();
            } else {
                $defaultArguments[$parameter->name()] = $parameter->defaultValue();
            }
        }

        $values = array_replace(array_values($defaultArguments), $arguments);

        // @todo: remove in php 5.3
        if (!empty($values)) {
            $inputArguments = array_combine(array_keys($defaultArguments), $values);
        }

        $input = new ArrayInput($inputArguments);

        return $input;
    }
}
