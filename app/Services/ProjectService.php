<?php

namespace App\Services;

use App\Models\AdminNav;
use App\Models\Project;

class ProjectService
{
    /**
     * @param string $title
     * @param string $description
     * @param int $file_id
     * @return int
     */
    public function storeProject(string $title, string $description, int $file_id): int
    {
        $project = $this->createProject();
        $project->title = $title;
        $project->description = $description;
        $project->file_id = $file_id;
        $project->save();


        return $project->id;
    }

    /**
     * @param Project $project
     * @param string $title
     * @param string $description
     * @param int $file_id
     * @return void
     */
    public function updateProject(Project $project, string $title, string $description, int $file_id): void
    {
        $project->title = $title;
        $project->description = $description;
        $project->file_id = $file_id;
        $project->save();
    }

    /**
     * @return Project
     */
    public function createProject(): Project
    {
        return new Project();
    }
}
