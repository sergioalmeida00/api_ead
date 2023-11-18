<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCertificateRequest;
use App\Mail\SendMailCertificate;
use App\Repositories\CourseRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\ApiResponser as TraitsApiResponser;

class CertificateController extends Controller
{
    protected $repository;
    use TraitsApiResponser;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    public function generateCertificate(GenerateCertificateRequest $request)
    {
        $courseId = $request->validated();

        $data = $this->repository->getCourseWatchedLessonCount($courseId);
        $userData = $data['user']->toArray();

        if ($data['data']['total_lessons'] != $data['data']['lessons_watched']) {
            return $this->error('Curso ainda não concluido', 404);
        }

        $pdf = Pdf::loadView('emails.user.certificate', [
            'data' => $data['data'],
            'user' => $userData
        ])
            ->setPaper('a4', 'landscape');
        $url = "/temp/" . $userData['id'] . ".pdf";
        $pdfPath = public_path($url);
        $pdf->save($pdfPath);

        Mail::to('sergioalmeidaa00@gmail.com')->send(new SendMailCertificate($data['user'], $pdfPath));

        unlink($pdfPath);
        return $pdf->stream('certificate.pdf');
    }
}
