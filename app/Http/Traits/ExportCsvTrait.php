<?php

namespace App\Http\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportCsvTrait
{
    protected function exportData($fileName, $data, $columns)
    {
        $response = new StreamedResponse(
            function () use ($data, $columns) {
                $output = fopen('php://output', 'w');
                fputcsv($output, $columns);

                foreach ($data as $row) {
                    fputcsv($output, $row->toArray());
                }
                fclose($output);
            }
        );

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$fileName}");

        return $response;
    }
}
