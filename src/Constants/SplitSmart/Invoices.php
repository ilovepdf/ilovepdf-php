<?php

namespace Ilovepdf\Constants\SplitSmart;

final class Invoices
{
    public const INV_NUMBER = 'Split invoices by invoice number';
    public const VENDOR = 'Split invoices by supplier or vendor';
    public const BILLING_PERIOD = 'Split invoices by date or billing period';
    public const ONE_PER = 'Split batch into one invoice per PDF';
    public const PO_NUMBER = 'Split invoices by purchase order number';
    public const CURRENCY_TAX = 'Split invoices by currency or tax ID';
}
