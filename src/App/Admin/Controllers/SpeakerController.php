<?php

namespace App\App\Admin\Controllers;

use App\App\Admin\Requests\Speaker\StoreSpeakerRequest;
use App\Domain\Department\Actions\DepartmentService;
use App\Domain\Speaker\Actions\SpeakerService;
use App\Domain\Speaker\DataTransferObjects\CreateSpeakerDto;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class SpeakerController
{
    public function __construct(private ResponseFactory $responseFactory)
    {
    }

    public function index(): Response
    {
        return $this->responseFactory->view('admin.speakers.index');
    }

    public function create(DepartmentService $departmentService): Response
    {
        $departments = $departmentService->list();

        return $this->responseFactory->view('admin.speakers.create', [
            'departments' => $departments,
        ]);
    }

    public function store(
        StoreSpeakerRequest $speakerRequest,
        SpeakerService $speakerService,
    ) {
        $value = $speakerRequest->post('firstName').' '.$speakerRequest->post('lastName');
        $slug = Str::of($value)->slug('-');
        $speaker = new CreateSpeakerDto(
            firstName: $speakerRequest->post('firstName'),
            lastName: $speakerRequest->post('lastName'),
            surname: $speakerRequest->post('surname'),
            position: $speakerRequest->post('position'),
            file: $speakerRequest->file('image'),
            slug: $slug,
            departmentId: (int) $speakerRequest->post('departmentId'),
       );

        $speakerService->create($speaker);

        return $this->responseFactory->redirectToRoute('speakers.index');
    }

    public function edit()
    {
        return $this->responseFactory->view('admin.speakers.edit');
    }
}
