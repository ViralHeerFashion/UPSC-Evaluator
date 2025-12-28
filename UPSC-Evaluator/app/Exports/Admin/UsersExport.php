<?php

namespace App\Exports\Admin;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    private $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Name',
            'Mobile',
            'Email',
            'Temporary Password'
        ];
    }

    public function map($user): array
    {
        return [
            date("d-m-Y h:i A", strtotime($user->created_at)),
            $user->name,
            $user->phone,
            $user->email,
            $user->plain_password
        ];
    }

}
