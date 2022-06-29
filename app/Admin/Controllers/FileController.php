<?php

namespace App\Admin\Controllers;

use App\Models\File;
use App\Http\Controllers\Controller;
use App\Services\FileService;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FileController extends Controller
{
    use HasResourceActions;

    private FileService $service;

    /**
     * @param FileService $service
     */
    public function __construct(FileService $service)
    {
        $this->service = $service;
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
        $grid = new Grid(new File);

        $grid->id('ID');
        $grid->name('name');
        $grid->path('Img')->image();
        $grid->info('info');
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
        $show = new Show(File::findOrFail($id));

        $show->id('ID');
        $show->name('name');
        $show->path('path');
        $show->info('info');
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
        $service = $this->service;
        $form = new Form(new File);
        $form->display('id');
        if ($form->isEditing()) {
            $form->image('path');
        }
        if ($form->isCreating()) {
            $form->image('file');
        }

        $form->text('info', 'info');
        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        $form->saving(function (Form $form) use ($service) {
            if (request()->hasFile('file')) {
                $files = request()->file('file');
                $file = $service->save($files, $form->info);
                admin_toastr(trans('admin.save_succeeded'));
                return redirect(route('admin.file.edit', $file->id));
            }

            return back();
        });

        return $form;
    }
}
