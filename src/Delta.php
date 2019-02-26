<?php

namespace Everyday\CommonQuill;

class Delta implements \JsonSerializable
{
    /**
     * @var DeltaOp[]
     */
    private $ops;

    /**
     * Delta constructor.
     *
     * @param DeltaOp[] $ops
     */
    public function __construct(array $ops)
    {
        $this->ops = $ops;
    }

    /**
     * @return array
     */
    public function getOps(): array
    {
        return $this->ops;
    }

    /**
     * Compact the delta, returning the number of passes.
     */
    public function compact(): int
    {
        $passes = 0;

        while (self::doCompactionPass()) {
            $passes++;
        }

        foreach ($this->ops as $op) {
            $op->compact();
        }

        return $passes;
    }

    /**
     * Perform a single compaction pass.
     *
     * @return bool
     */
    public function doCompactionPass(): bool
    {
        $i = -1;
        $start_count = count($this->ops);

        while (isset($this->ops[++$i]) && isset($this->ops[$i + 1])) {
            $op1 = $this->ops[$i];
            $op1_insert = $op1->getInsert();

            if (!is_string($op1_insert)) {
                continue;
            }

            $op2 = $this->ops[$i + 1];
            $op2_insert = $op2->getInsert();

            if (!is_string($op2_insert) || (!isset($this->ops[$i + 2]) && $op2_insert === "\n")) {
                // Nothing more to optimize.
                break;
            }

            $op1_attributes = $op1->getAttributes();

            if ($op1_attributes !== $op2->getAttributes()) {
                continue;
            }

            $this->ops[$i] = DeltaOp::text($op1_insert.$op2_insert, $op1_attributes);

            $this->ops[$i + 1] = false;

            $i++;
        }

        $this->ops = array_values(array_filter($this->ops));

        return $start_count > count($this->ops);
    }

    /**
     * Convert a delta to plaintext.
     *
     * @return string
     */
    public function toPlaintext(): string
    {
        $string = '';

        foreach ($this->ops as $op) {
            if (is_string($insert = $op->getInsert())) {
                $string .= $insert;
            }
        }

        return $string;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $ops = $this->ops;

        // A valid delta must **ALWAYS** end in a new line
        $last = $ops[max(count($ops) - 1, 0)];
        if ($last->getInsert() !== "\n") {
            $ops[] = DeltaOp::text("\n");
        }

        return compact('ops');
    }
}
