<?php

namespace App\Exports\Admin;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class ProcessFileExport implements FromCollection, WithHeadings, WithMapping
{
    private $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->files;
    }

    public function headings(): array
    {
        return [
            'Institute',
            'Batch',
            'File Name',
            'No Of Pages'
        ];
    }

    public function map($file): array
    {
        return [
            $file->upload_batch->institute->name,
            date("d-m-Y h:i A", strtotime($file->upload_batch->created_at)),
            $file->file_name,
            $file->no_of_pages
        ];
    }
}
