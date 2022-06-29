<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use App\Models\SiteConfiguration;
use App\Services\FileService;
use Illuminate\Http\Response;

class PageController extends Controller
{
    private FileService $fileService;

    /**
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $siteConfig = SiteConfiguration::all();
        $config = $siteConfig->pluck('value', 'key')->toArray();
        $action = route('email');
        $projects = [];

        foreach (Project::all()->toArray() as $key => $project) {
            $projects[$key] = $project;
            $projects[$key]['image_url_full'] = $this->fileService->getPublicUrl($project['file_id_full']);
            $projects[$key]['image_url_crop'] = $this->fileService->getPublicUrl($project['file_id_crop']);
        }

        $file = [];
        foreach (File::all()->toArray() as $item) {
            $file = $item['path'];
        }

        return response(view('index', [
            'config' => $config,
            'projects' => $projects,
            'action' => $action,
            'file' => $file
        ]));
    }
}
