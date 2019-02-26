<?php

namespace Everyday\CommonQuill\Tests\Functional;

use Everyday\CommonQuill\QuillConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Tests the parser against locally-stored examples
 *
 * This is particularly useful for testing minor variations allowed by the spec
 * or small regressions not tested by the spec.
 */
class LocalDataTest extends TestCase
{
    /**
     * @var QuillConverter
     */
    protected $converter;

    protected function setUp()
    {
        $this->converter = new QuillConverter();
    }

    /**
     * @param string $markdown Markdown to parse
     * @param string $array     Expected result
     * @param string $testName Name of the test
     *
     * @dataProvider dataProvider
     */
    public function testExample($markdown, $array, $testName)
    {
        // hack, I know
        $actualResult = json_encode($this->converter->convertToQuill($markdown));

        $failureMessage = sprintf('Unexpected result for "%s" test', $testName);
        $failureMessage .= "\n=== markdown ===============\n" . $markdown;
        $failureMessage .= "\n=== expected ===============\n" . json_encode($array);
        $failureMessage .= "\n=== got ====================\n" . $actualResult;

        $this->assertEquals($array, json_decode($actualResult, true), $failureMessage);
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $finder = new Finder();
        $finder->files()
            ->in(__DIR__ . '/data')
            ->depth('> 0')
            ->name('*.md');

        $ret = [];

        /** @var SplFileInfo $markdownFile */
        foreach ($finder as $markdownFile) {
            $testName = $markdownFile->getBasename('.md');
            $markdown = $markdownFile->getContents();
            $relativePath = $markdownFile->getRelativePath();

            $array = json_decode(file_get_contents(__DIR__ . '/data/' . $relativePath . '/' . $testName . '.json'), true);

            $ret[] = [$markdown, $array, $testName];
        }

        return $ret;
    }
}