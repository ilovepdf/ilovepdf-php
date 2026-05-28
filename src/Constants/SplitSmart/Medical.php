<?php

namespace Ilovepdf\Constants\SplitSmart;

final class Medical
{
    public const PATIENT = 'Split records by patient name or ID';
    public const LABS = 'Split lab results into individual reports';
    public const VISIT = 'Split documents by visit or appointment date';
    public const PRESCRIPTIONS = 'Split prescriptions from clinical notes';
    public const CLAIMS = 'Split insurance documents by claim number';
    public const DOC_TYPE = 'Split medical files by document type';
    public const CONSENT = 'Split consent forms from treatment records';
}
