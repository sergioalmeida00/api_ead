<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCertificateRequest;
use App\Mail\SendMailCertificate;
use App\Repositories\CourseRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Repositories\CertificateRepository;

class CertificateController extends Controller
{
    protected $repository;
    protected $repositoryCertificate;
    use TraitsApiResponser;

    public function __construct(CourseRepository $courseRepository, CertificateRepository $repositoryCertificate)
    {
        $this->repository = $courseRepository;
        $this->repositoryCertificate = $repositoryCertificate;
    }

    public function generateCertificate(GenerateCertificateRequest $request)
    {
        $courseId = $request->validated();

        $data = $this->repository->getCourseWatchedLessonCount($courseId);
        $userData = $data['user'];

        if ($this->courseNotCompleted($data['data'])) {
            return $this->error('Curso ainda não concluido', 400);
        }

        if ($this->certificateExists($userData->id, $courseId)) {
            return $this->error('Certificado já existe para este usuário e curso', 400);
        }

        $certificateId = $this->createCertificate($userData->id, $courseId['courseId']);

        $pdfPath = $this->generateCertificatePdf(
            $data['data'],
            $userData,
            $certificateId
        );

        try {
            Mail::to('sergioalmeidaa00@gmail.com')->send(new SendMailCertificate($userData, $pdfPath));
            return $this->success([], 'Enviado com sucesso.', 201);
        } catch (\Exception $e) {
            return $this->error('Erro ao enviar o certificado por email', 500);
        } finally {
            unlink($pdfPath);
        }
    }

    protected function courseNotCompleted($courseData)
    {
        return $courseData['total_lessons'] != $courseData['lessons_watched'];
    }

    protected function certificateExists($userId, $courseId)
    {
        return $this->repositoryCertificate->findCertificate($userId, $courseId);
    }

    protected function createCertificate($userId, $courseId)
    {
        return $this->repositoryCertificate->create([
            'user_id' => $userId,
            'course_id' => $courseId
        ]);
    }

    protected function generateCertificatePdf($courseData, $userData, $certificateDate)
    {
        $pdf = Pdf::loadView('emails.user.certificate', [
            'data' => $courseData,
            'user' => $userData,
            'certificateId' => $certificateDate->id->toString(),
            'certificateDate' => $certificateDate->created_at
        ])
            ->setPaper('a4', 'landscape');

        $pdfPath = public_path("/temp/{$userData->id}.pdf");

        $pdf->save($pdfPath);

        return $pdfPath;
    }
}
