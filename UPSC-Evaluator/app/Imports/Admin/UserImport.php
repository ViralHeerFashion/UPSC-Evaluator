<?php

namespace App\Imports\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\{
    ToCollection,
    WithHeadingRow,
    WithValidation
};
use App\Models\{
    User,
    StudentSheet
};

class UserImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $phones = [];
    protected $emails = [];
    protected $uniqueIds = [];
    protected $institute_id;
    protected $sheet_name;

    public function __construct(int $institute_id, string $sheet_name)
    {
        $this->institute_id = $institute_id;
        $this->sheet_name = $sheet_name;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $student_sheet = new StudentSheet;
        $student_sheet->institute_id = $this->institute_id;
        $student_sheet->sheet_name = $this->sheet_name;
        $student_sheet->save();

        foreach ($collection as $row) {
            $password = Str::random(8);
            $user = new User;
            $user->name = $row['name'];
            $user->phone = $row['mobile_number'];
            $user->email = $row['email_id'];
            $user->unique_id = $row['unique_id'];
            $user->plain_password = $password;
            $user->password = Hash::make($password);
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->institute_id = $this->institute_id;
            $user->student_sheet_id = $student_sheet->id;
            $user->save();
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50'],

            'mobile_number' => [
                'required',
                'digits:10',
                function ($attr, $value, $fail) {
                    if (in_array($value, $this->phones)) {
                        $fail('Duplicate phone inside Excel.');
                    }
                    $this->phones[] = $value;
                },
                Rule::unique('users', 'phone'),
            ],

            'email_id' => [
                'required',
                'email',
                'min: 5',
                function ($attr, $value, $fail) {
                    if (in_array($value, $this->emails)) {
                        $fail('Duplicate email inside Excel.');
                    }
                    $this->emails[] = $value;
                },
                Rule::unique('users', 'email'),
            ],

            'unique_id' => [
                'required',
                'string',
                'min:1',
                'max:10',
                function ($attr, $value, $fail) {
                    if (in_array($value, $this->uniqueIds)) {
                        $fail('Duplicate unique_id inside Excel.');
                    }
                    $this->uniqueIds[] = $value;
                },
                Rule::unique('users', 'unique_id'),
            ],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        return [
            'name' => isset($data['name']) ? trim($data['name']) : null,
            'mobile_number' => isset($data['mobile_number']) ? trim($data['mobile_number']) : null,
            'email_id' => isset($data['email_id']) ? trim($data['email_id']) : null,
            'unique_id' => isset($data['unique_id']) ? trim($data['unique_id']) : null,
        ];
    }
}
