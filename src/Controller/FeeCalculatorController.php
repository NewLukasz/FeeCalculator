<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Loan;
use App\Service\FeeCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class FeeCalculatorController extends AbstractController
{
    #[Route('/fee/calculate', name: 'app_fee_calculate', methods: 'POST')]
    public function feeCalculate(
        Request $request,
        FeeCalculator $feeCalculator
    ) : JsonResponse
    {
        $dataFromRequest = $request->getContent();
        $loanData = json_decode($dataFromRequest, true);

        $loan = new Loan($loanData['term'], $loanData['amount']);
        $fee = $feeCalculator->calculate($loan);

        $response = [
            'message' => sprintf('Calculated fee is %s.', $fee)
        ];

        $response['fee_value'] = $fee;
        return $this->json($response);
    }
}
