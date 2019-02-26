# everyday/commonquill

[![Build Status](https://travis-ci.org/Everyday-AS/common-quill.svg?branch=master)](https://travis-ci.org/Everyday-AS/common-quill)
[![StyleCI](https://github.styleci.io/repos/172658588/shield?branch=master)](https://github.styleci.io/repos/172658588)


**everyday/commonquill** is a PHP-based Markdown to Quill parser created by [Everyday](https://everyday.no) which supports the full [CommonMark] spec. **everyday/commonquill** depends on [league/commonmark](https://github.com/thephpleague/commonmark/)'s brilliant AST implementation.

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
echo json_encode($converter->convertToQuill('# Hello World!'));

// {"ops":[{"insert":"Hello World!"},{"insert":"\n",attributes":{"header":1}}]}
```

## Advanced Usage & Customization

Please refer to [thephpleague/commonmark](https://github.com/thephpleague/commonmark/blob/master/README.md)'s docs for more information.
