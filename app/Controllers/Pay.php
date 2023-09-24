<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pay extends BaseController
{
    public function payDelivery(string $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'KEY' => getenv('PAY_KEY'),
            'SECRET' => getenv('PAY_SECRET'),
        ];
        dd($data);
    }
}
