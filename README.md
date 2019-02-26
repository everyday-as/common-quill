# everyday/commonquill

**everyday/commonquill** is a PHP-based Markdown to Quill parser created by [Everyday](https://everyday.no) which supports the full [CommonMark] spec. **everyday/commonquill** depends on [league\commonmark](https://github.com/thephpleague/commonmark/)'s brilliant AST implementation.

## Installation

This project can be installed via [Composer]:

``` bash
$ composer require everyday/commonquill
```

## Basic Usage

The `QuillConverter` class provides a simple wrapper for converting CommonMark to Quill Deltas:

```php
use Everyday\CommonQuill\QuillConverter;

$converter = new QuillConverter();
echo $converter->convertToQuill('# Hello World!');

// {"ops":[{"insert":"Hello World!"},{"insert":"\n",attributes":{"header":1}}]}
```

## Advanced Usage & Customization

Please refer to [thephpleague/commonmark](https://github.com/thephpleague/commonmark/blob/master/README.md)'s docs for more information.
