<?php

namespace Everyday\CommonQuill\Tests\Functional;

class BinTest extends AbstractBinTest
{
    /**
     * Tests the behavior of not providing any Markdown input.
     */
    public function testNoArgsOrStdin()
    {
        $cmd = $this->createCommand();
        $cmd->execute();

        $this->assertEquals(1, $cmd->getExitCode());
        $this->assertEmpty($cmd->getOutput());

        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            $this->assertStringContainsString('Usage:', $cmd->getError());
        }
    }

    /**
     * Tests the -h flag.
     */
    public function testHelpShortFlag()
    {
        $cmd = $this->createCommand();
        $cmd->addArg('-h');
        $cmd->execute();

        $this->assertEquals(0, $cmd->getExitCode());
        $this->assertStringContainsString('Usage:', $cmd->getOutput());
    }

    /**
     * Tests the --help option.
     */
    public function testHelpOption()
    {
        $cmd = $this->createCommand();
        $cmd->addArg('--help');
        $cmd->execute();

        $this->assertEquals(0, $cmd->getExitCode());
        $this->assertStringContainsString('Usage:', $cmd->getOutput());
    }

    /**
     * Tests the behavior of using unknown options.
     */
    public function testUnknownOption()
    {
        $cmd = $this->createCommand();
        $cmd->addArg('--foo');
        $cmd->execute();

        $this->assertEquals(1, $cmd->getExitCode());

        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            $this->assertStringContainsString('Unknown option', $cmd->getError());
        }
    }

    /**
     * Returns the full path to the test data file.
     *
     * @param string $file
     *
     * @return string
     */
    protected function getPathToData($file)
    {
        return realpath(__DIR__.'/data/'.$file);
    }
}
