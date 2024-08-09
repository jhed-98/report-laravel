<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserer
{
    public function creating(Invoice $invoice)
    {
        $invoice->correlative = Invoice::where('serie', $invoice->serie)->count() + 1;
    }
}
