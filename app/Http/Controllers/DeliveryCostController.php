<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryCostRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryCostController extends Controller
{
    public function calculate(DeliveryCostRequest $request): Response
    {
        $data = $request->all();

        $cost = count($data['items']) * 1.11;

        return $this->success([
            'cost' => number_format($cost, 2, '.', ''),
        ]);
    }
}
