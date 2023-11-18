<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCertificateRequest;
use App\Mail\SendMailCertificate;
use App\Repositories\CourseRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class CertificateController extends Controller
{
    protected $repository;
    public function __construct(CourseRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    public function generateCertificate(GenerateCertificateRequest $request)
    {
        $courseId = $request->validated();
        $data = $this->repository->getCourseWatchedLessonCount($courseId);


        if ($data['data']['total_lessons'] != $data['data']['lessons_watched']) {
            return $this->error('Curso ainda não concluido', 404);
        }

        $pdf = Pdf::loadView('emails.user.certificate', [
            'data' => $data['data'],
            'user' => $data['user']->toArray()
        ])
            ->setPaper('a4', 'landscape');
        $pdfPath = public_path('/temp/certificate.pdf');
        $pdf->save($pdfPath);

        Mail::to('sergioalmeidaa00@gmail.com')->send(new SendMailCertificate($data['user'], $pdfPath));

        unlink($pdfPath);
        return $pdf->stream('certificate.pdf');
    }
}
