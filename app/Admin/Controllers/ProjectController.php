<?php

namespace App\Admin\Controllers;

use App\Models\File;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Services\ProjectService;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProjectController extends Controller
{
    use HasResourceActions;

    private ProjectService $service;
    private FileService $fileService;

    public function __construct(ProjectService $service, FileService $fileService)
    {
        $this->service = $service;
        $this->fileService = $fileService;
    }


    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header(trans('admin.index'))
            ->description(trans('admin.description'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(trans('admin.detail'))
            ->description(trans('admin.description'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('admin.edit'))
            ->description(trans('admin.description'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header(trans('admin.create'))
            ->description(trans('admin.description'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Project);

        $grid->id('ID');
        $grid->title('title');
        $grid->description('description');
        $grid->category('category');
        $grid->file_id('file_id');
        $grid->created_at(trans('admin.created_at'));
        $grid->updated_at(trans('admin.updated_at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Project::findOrFail($id));

        $show->id('ID');
        $show->title('title');
        $show->description('description');
        $show->category('category');
        $show->file_id('file_id');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Project);

        $form->display('ID');
        $form->text('title', 'title');
        $form->text('description', 'description');
        $form->text('category', 'category');
        $form->select('file_id_full', 'File Full')->options(File::all()->pluck('info', 'id'));
        $form->select('file_id_crop', 'File Crop')->options(File::all()->pluck('info', 'id'));
        $form->display('created_at',trans('admin.created_at'));
        $form->display('updated_at',trans('admin.updated_at'));

        return $form;
    }
}
