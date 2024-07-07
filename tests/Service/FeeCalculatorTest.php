<?php
declare(strict_types=1);

namespace Service;

use PHPUnit\Framework\TestCase;
use App\Service\FeeCalculator;
use App\Model\Loan;
use App\DataStructure\FeeRateStructure;

class FeeCalculatorTest extends TestCase
{
    public function testCalculate()
    {
        $feeCalculator = new FeeCalculator(new FeeRateStructure());

        $loan = new Loan(11,3000);
        $this->assertEquals(90, $feeCalculator->calculate($loan));

        $loan2 = new Loan(24, 11500);
        $this->assertEquals(460, $feeCalculator->calculate($loan2));

        $loan3 = new Loan(12, 19250);
        $this->assertEquals(385, $feeCalculator->calculate($loan3));

        $loan4 = new Loan(1, 1000);
        $this->assertEquals(50, $feeCalculator->calculate($loan4));

        $loan5 = new Loan(1, 20000);
        $this->assertEquals(400, $feeCalculator->calculate($loan5));

        $loan6 = new Loan(13, 19000);
        $this->assertEquals(760, $feeCalculator->calculate($loan6));

        $loan7 = new Loan(13, 12100);
        $this->assertEquals(484, $feeCalculator->calculate($loan7));

        $loan8 = new Loan(1, 1000.90);
        $this->assertEquals(50.05, $feeCalculator->calculate($loan8));
    }

    public function testFindNearestValue()
    {
        $feeCalculator = new FeeCalculator(new FeeRateStructure());

        $this->assertEquals(11000,$feeCalculator->findNearestValue(11200, 24));
        $this->assertEquals(9000,$feeCalculator->findNearestValue(8900, 11));
        $this->assertEquals(9000,$feeCalculator->findNearestValue(8900, 13));
        $this->assertEquals(19000,$feeCalculator->findNearestValue(19400, 18));
        $this->assertEquals(20000,$feeCalculator->findNearestValue(19600, 18));
        $this->assertEquals(20000,$feeCalculator->findNearestValue(19500.50, 18));
        $this->assertEquals(19000,$feeCalculator->findNearestValue(19400.50, 18));
        $this->assertEquals(3000,$feeCalculator->findNearestValue(2750, 24));

    }
}
