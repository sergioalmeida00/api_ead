<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCertificateRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\userResource;
use App\Repositories\UserRepository;
use App\Http\Traits\ApiResponser as TraitsApiResponser;
use App\Http\Traits\ExportCsvTrait;
use App\Mail\SendMail;
use App\Mail\SendMailCertificate;
use App\Repositories\CourseRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    use TraitsApiResponser, ExportCsvTrait;

    protected $repository;
    protected $repositoryCourse;

    public function __construct(UserRepository $userRepository, CourseRepository $courseRepository)
    {
        $this->repository = $userRepository;
        $this->repositoryCourse = $courseRepository;
    }
    public function register(RegisterUserRequest $request)
    {
        $user = $this->repository->register($request->all());
        $token = $user->createToken($user->name)->plainTextToken;

        return $this->success([
            'token' => $token,
            'user' => new userResource($user)
        ], '', 201);
    }

    public function listUsers($id = '')
    {
        $users = $this->repository->findAll($id);
        return userResource::collection($users);
    }

    public function update(RegisterUserRequest $request, $id)
    {
        $user = $this->repository->findOne($id);

        if (!$user) {
            return $this->error('User is not exists', 404);
        }

        $data = $request->only(['email', 'name']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $this->repository->updateUser($data, $id);

        return $this->success([], '', 204);
    }

    public function exportCSV()
    {
        $users = $this->repository->findAll(null);
        $columns = ['ID', 'NOME', 'EMAIL'];

        $fileName = 'user.csv';

        $response = $this->exportData($users, $columns);

        Mail::to('sergioalmeidaa00@gmail.com')->send(new SendMail($response));

        return $response;
    }

    public function generateCertificate(GenerateCertificateRequest $request)
    {
        $courseId = $request->validated();
        $data = $this->repositoryCourse->getCourseWatchedLessonCount($courseId);


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
