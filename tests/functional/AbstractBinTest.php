<?php

namespace Everyday\CommonQuill\Tests\Functional;

use mikehaertl\shellcommand\Command;
use PHPUnit\Framework\TestCase;

abstract class AbstractBinTest extends TestCase
{
    /**
     * @return string
     */
    protected function getPathToCommonquill()
    {
        return realpath(__DIR__ . '/../../bin/commonquill');
    }

    /**
     * @return Command
     */
    protected function createCommand()
    {
        $path = $this->getPathToCommonquill();

        $command = new Command();
        if ($command->getIsWindows()) {
            $command->setCommand('php');
            $command->addArg($path);
        } else {
            $command->setCommand($path);
        }

        return $command;
    }
}
