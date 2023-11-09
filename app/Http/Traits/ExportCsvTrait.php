<?php

namespace App\Http\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportCsvTrait
{
    protected function exportData( $data, $columns)
    {
        // $response = new StreamedResponse(
        //     function () use ($data, $columns) {
        //         $output = fopen('php://output', 'w');
        //         fputcsv($output, $columns);

        //         foreach ($data as $row) {
        //             fputcsv($output, $row->toArray());
        //         }
        //         fclose($output);
        //     }
        // );

        // $response->headers->set('Content-Type', 'text/csv');
        // $response->headers->set('Content-Disposition', "attachment; filename={$fileName}");

        // return $response;
        $output = fopen('php://temp', 'r+');
        fputcsv($output, $columns);

        foreach ($data as $row) {
            fputcsv($output, $row->toArray());
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}
