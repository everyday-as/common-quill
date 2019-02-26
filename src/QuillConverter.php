<?php

namespace Everyday\CommonQuill;

use Everyday\CommonQuill\Extension\QuillExtension;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;

class QuillConverter extends Converter
{
    /**
     * Create a new quill converter instance.
     *
     * @param array            $config
     * @param Environment|null $environment
     */
    public function __construct(array $config = [], Environment $environment = null)
    {
        if ($environment === null) {
            $environment = self::quillEnvironment();
        }

        $environment->mergeConfig($config);

        parent::__construct(new DocParser($environment), new QuillRenderer($environment));
    }

    /**
     * @return Environment
     */
    public static function quillEnvironment(): Environment
    {
        $environment = new Environment();

        $environment->addExtension(new QuillExtension());

        $environment->mergeConfig([
            'compact_delta' => true,
            'allow_unsafe_links' => true,
            'max_nesting_level'  => INF,
        ]);

        return $environment;
    }
}
