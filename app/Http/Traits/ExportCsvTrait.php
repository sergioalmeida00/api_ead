<?php

namespace App\Http\Traits;

use SplFileObject;

trait ExportCsvTrait
{
    protected function exportData($fileName, $data, $columns)
    {
        $file = new SplFileObject($fileName, 'w');
        $file->fputcsv($columns);

        foreach ($data as $row) {
            $file->fputcsv($row->toArray());
        }

        $file = null;
    }
}
