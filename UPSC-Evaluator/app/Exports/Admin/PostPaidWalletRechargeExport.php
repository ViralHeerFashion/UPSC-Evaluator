<?php

namespace App\Exports\Admin;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class PostPaidWalletRechargeExport implements FromCollection, WithHeadings, WithMapping
{
    private $wallets;

    public function __construct($wallets)
    {
        $this->wallets = $wallets;
    }

    public function collection()
    {
        return $this->wallets;
    }

    public function headings(): array
    {
        return [
            'Institute Name',
            'Student Name',
            'Wallet Amount'
        ];
    }

    public function map($wallet): array
    {
        return [
            $wallet->institute_name,
            $wallet->user_name,
            $wallet->prepaid_wallet_amount
        ];
    }
}