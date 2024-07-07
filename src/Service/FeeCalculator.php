<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Loan;
use App\DataStructure\FeeRateStructure;

class FeeCalculator implements FeeCalculatorInterface
{
    /**
     * @param FeeRateStructure $feeRateStructure
     */
    public function __construct(
        readonly private FeeRateStructure $feeRateStructure
    ) {}

    /**
     * @param Loan $loan
     * @return float
     */
    public function calculate(Loan $loan): float
    {
        $amount = $loan->getAmount();
        $term = $loan->getTerm();
        $feeRates = $this->feeRateStructure->getFeeRates($term);

        if ($this->checkThatAmountHasDecimalValues($amount) && array_key_exists($amount, $feeRates)) {
            return $feeRates[$amount];
        }

        return $this->calculateWithInterpolation($amount, $term);
    }

    /**
     * @param float $amount
     * @param int $term
     * @return float
     */
    private function calculateWithInterpolation(float $amount, int $term): float
    {
        $nearestAmount = $this->findNearestValue($amount, $term);
        $feeRates = $this->feeRateStructure->getFeeRates($term);
        $nearestAmountFee = $feeRates[$nearestAmount];


        dd(2750*120/3000);

        return round($amount * $nearestAmountFee / $nearestAmount, 2);
    }

    /**
     * @param float $targetAmount
     * @param int $term
     * @return int
     */
    public function findNearestValue(float $targetAmount, int $term): int
    {
        $lowestDiff = PHP_INT_MAX;
        $nearestValue = null;
        $feeRates = $this->feeRateStructure->getFeeRates($term);
        foreach ($feeRates as $amount => $feeValue) {
            $diff = abs($targetAmount - $amount);
            if ($diff < $lowestDiff) {
                $lowestDiff = $diff;
                $nearestValue = $amount;
            }
        }
        return $nearestValue;
    }

    /**
     * @param float $amount
     * @return bool
     */
    private function checkThatAmountHasDecimalValues(float $amount): bool
    {
        return (int)$amount == $amount;
    }
}
