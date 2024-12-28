<?php

return [
    'name' => 'FarmerLoans',
    'max_loan_amount' => env('MAX_LOAN_AMOUNT', 1000000),
    'min_loan_amount' => env('MIN_LOAN_AMOUNT', 1000),
    'max_interest_rate' => env('MAX_INTEREST_RATE', 100),
    'min_interest_rate' => env('MIN_INTEREST_RATE', 1),
    'max_repayment_duration' => env('MAX_REPAYMENT_DURATION', 60),
    'min_repayment_duration' => env('MIN_REPAYMENT_DURATION', 1),
];
