<?php

namespace Ilovepdf\Constants\SplitSmart;

final class Logistics
{
    public const BOL = 'Split bills of lading by shipment';
    public const PACKING_LIST = 'Split packing lists by order number';
    public const CUSTOMS = 'Split customs forms by shipment or container';
    public const DOC_TYPES = 'Split invoices, packing lists, and certificates';
    public const DELIVERY = 'Split delivery notes by recipient';
    public const SEPARATOR = 'Split shipping batches using separator pages';
    public const DESTINATION = 'Split documents by destination country';
}
