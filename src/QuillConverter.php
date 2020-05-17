<?php

namespace Everyday\CommonQuill;

use Everyday\CommonQuill\Extension\QuillExtension;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\EnvironmentInterface;

class QuillConverter extends Converter
{
    /**
     * Create a new quill converter instance.
     *
     * @param array                $config
     * @param EnvironmentInterface $environment
     */
    public function __construct(array $config = [], ?EnvironmentInterface $environment = null)
    {
        if ($environment === null) {
            $environment = self::createQuillEnvironment();
        }

        if ($environment instanceof ConfigurableEnvironmentInterface) {
            $environment->mergeConfig($config);
        }

        parent::__construct(new DocParser($environment), new QuillRenderer($environment));
    }

    /**
     * @return ConfigurableEnvironmentInterface
     */
    public static function createQuillEnvironment(): ConfigurableEnvironmentInterface
    {
        $environment = Environment::createCommonMarkEnvironment()
            ->addExtension(new QuillExtension());

        $environment->mergeConfig([
            'compact_delta'      => true,
            'allow_unsafe_links' => true,
            'max_nesting_level'  => INF,
        ]);

        return $environment;
    }
}
