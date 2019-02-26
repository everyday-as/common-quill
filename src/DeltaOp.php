<?php

namespace Everyday\CommonQuill;

class DeltaOp implements \JsonSerializable
{
    private const ATTRIBUTE_TYPES = [
        // Inline
        'background' => 'string',
        'bold'       => 'boolean',
        'color'      => 'string',
        'font'       => 'string',
        'code'       => 'boolean',
        'italic'     => 'boolean',
        'link'       => 'string',
        'size'       => 'string',
        'strike'     => 'boolean',
        'script'     => 'string',
        'underline'  => 'boolean',
        // Block
        'blockquote' => 'boolean',
        'header'     => 'integer',
        'indent'     => 'integer',
        'list'       => 'string',
        'align'      => 'string',
        'direction'  => 'string',
        'code-block' => 'boolean',
        // Embed attributes
        'alt'   => 'string',
        'title' => 'string',
    ];

    private const EMBED_TYPES = [
        'image',
        'video',
    ];

    private const BLOCK_MODIFIER_TYPES = [
        'blockquote',
        'header',
        'indent',
        'list',
        'align',
        'direction',
        'code-block',
    ];

    /**
     * @var array|string
     */
    private $insert;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * DeltaOp constructor.
     *
     * @param array|string $insert
     * @param array        $attributes
     */
    private function __construct($insert, array $attributes = [])
    {
        $this->setInsert($insert);

        foreach ($attributes as $attribute => $value) {
            if (!empty($value)) {
                $this->setAttribute($attribute, $value);
            }
        }
    }

    /**
     * @param string      $attribute
     * @param string|bool $value
     */
    public function setAttribute(string $attribute, $value): void
    {
        if (!isset(self::ATTRIBUTE_TYPES[$attribute])) {
            throw new \InvalidArgumentException('Unknown attribute: "'.$attribute.'"');
        }

        if (self::ATTRIBUTE_TYPES[$attribute] !== ($type = gettype($value))) {
            throw new \InvalidArgumentException('Unsupported type "'.$type.'" for "'.$attribute.'" attribute');
        }

        $this->attributes[$attribute] = $value;
    }

    /**
     * @param string ...$attributes
     *
     * @return void
     */
    public function removeAttributes(string ...$attributes): void
    {
        foreach ($attributes as $attribute) {
            unset($this->attributes[$attribute]);
        }
    }

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttribute(string $attribute): bool
    {
        return isset($this->attributes[$attribute]);
    }

    /**
     * @param string $attribute
     *
     * @return string
     */
    public function getAttribute(string $attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array|string $insert
     *
     * @return void
     */
    public function setInsert($insert): void
    {
        if (!in_array($type = gettype($insert), ['array', 'string'])) {
            throw new \InvalidArgumentException('Invalid type "'.$type.'" for insert');
        }

        $this->insert = $insert;
    }

    /**
     * @return array|string
     */
    public function getInsert()
    {
        return $this->insert;
    }

    /**
     * @return bool
     */
    public function isEmbed(): bool
    {
        return is_array($this->insert);
    }

    /**
     * Compact the op.
     */
    public function compact()
    {
        $to_remove = [];

        if ($this->hasAttribute('indent') && 0 === $this->getAttribute('indent')) {
            $to_remove[] = 'indent';
        }

        $this->removeAttributes(...$to_remove);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $op = [
            'insert' => $this->insert,
        ];

        if (!empty($this->attributes)) {
            $op['attributes'] = $this->attributes;
        }

        return $op;
    }

    /**
     * Construct a new text op.
     *
     * @param string $text
     * @param array  $attributes
     *
     * @return DeltaOp
     */
    public static function text(string $text, array $attributes = []): self
    {
        return new self($text, $attributes);
    }

    /**
     * Construct a new embed op.
     *
     * @param string $type
     * @param string $data
     * @param array  $attributes
     *
     * @return DeltaOp
     */
    public static function embed(string $type, string $data, array $attributes = []): self
    {
        if (!in_array($type, self::EMBED_TYPES)) {
            throw new \InvalidArgumentException('Unknown embed type: "'.$type.'"');
        }

        return new self([
            $type => $data,
        ], $attributes);
    }

    /**
     * Construct a new block modifier op.
     *
     * @param string $type
     * @param bool   $value
     *
     * @return DeltaOp
     */
    public static function blockModifier(string $type, $value = true): self
    {
        if (!in_array($type, self::BLOCK_MODIFIER_TYPES)) {
            throw new \InvalidArgumentException('Unknown block modifier type: "'.$type.'"');
        }

        return self::text("\n", [$type => $value]);
    }

    /**
     * Apply an array of attributes to an array of DeltaOps.
     *
     * @param DeltaOp[] $ops
     * @param array     $attributes
     *
     * @return void
     */
    public static function applyAttributes(array &$ops, array $attributes): void
    {
        foreach ($ops as $op) {
            foreach ($attributes as $attribute => $value) {
                if (!empty($value)) {
                    $op->setAttribute($attribute, $value);
                }
            }
        }
    }
}
