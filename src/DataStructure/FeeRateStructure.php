<?php
declare(strict_types=1);

namespace App\DataStructure;

use InvalidArgumentException;

class FeeRateStructure
{
    private const FIST_MONTH_INDICATOR = 1;
    private const FIRST_MONTH_LIMIT_INDICATOR = 12;
    private const SECOND_MONTH_LIMIT_INDICATOR = 24;
    /**
     * @var array|int[]
     */
    private array $feeRatesForFirstRange = [
        1000 => 50,
        2000 => 90,
        3000 => 90,
        4000 => 115,
        5000 => 100,
        6000 => 120,
        7000 => 140,
        8000 => 160,
        9000 => 180,
        10000 => 200,
        11000 => 220,
        12000 => 240,
        13000 => 260,
        14000 => 280,
        15000 => 300,
        16000 => 320,
        17000 => 340,
        18000 => 360,
        19000 => 380,
        20000 => 400,
    ];

    /**
     * @var array|int[]
     */
    private array $feeRatesForSecondRange = [
        2000 => 100,
        3000 => 120,
        4000 => 160,
        5000 => 200,
        6000 => 240,
        7000 => 280,
        8000 => 320,
        9000 => 360,
        10000 => 400,
        11000 => 440,
        12000 => 480,
        13000 => 520,
        14000 => 560,
        15000 => 600,
        16000 => 640,
        17000 => 680,
        18000 => 720,
        19000 => 760,
        20000 => 800,
    ];

    /**
     * @return array|int[]
     */
    public function getFeeRatesForFirstRange(): array
    {
        return $this->feeRatesForFirstRange;
    }

    /**
     * @return array|int[]
     */
    public function getFeeRatesForSecondRange(): array
    {
        return $this->feeRatesForSecondRange;
    }

    /**
     * @param int $term
     * @return int[]
     */
    public function getFeeRates(int $term): array
    {
        return match (true) {
            $term >= self::FIST_MONTH_INDICATOR && $term <= self::FIRST_MONTH_LIMIT_INDICATOR => $this->getFeeRatesForFirstRange(),
            $term > self::FIRST_MONTH_LIMIT_INDICATOR && $term <= self::SECOND_MONTH_LIMIT_INDICATOR => $this->getFeeRatesForSecondRange(),
            default => throw new InvalidArgumentException("Invalid term: $term"),
        };
    }
}
