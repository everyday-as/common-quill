<?php

namespace Everyday\CommonQuill;

use Everyday\CommonQuill\Extension\QuillExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Environment\EnvironmentInterface;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Parser\MarkdownParser;

class QuillConverter extends Converter
{
    public function __construct(array $config = [], ?EnvironmentInterface $environment = null)
    {
        if ($environment === null) {
            $environment = self::createQuillEnvironment($config);
        }

        parent::__construct(new MarkdownParser($environment), new QuillRenderer($environment));
    }

    public static function createQuillEnvironment(array $config): EnvironmentInterface
    {
        return (new Environment($config))
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new QuillExtension());
    }
}
