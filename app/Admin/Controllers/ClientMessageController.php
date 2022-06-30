<?php

namespace App\Admin\Controllers;

use App\Models\ClientMessage;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ClientMessageController extends Controller
{
    use HasResourceActions;

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
        $grid = new Grid(new ClientMessage);

        $grid->id('ID');
        $grid->name('name');
        $grid->email('email');
        $grid->phone('phone');
        $grid->message('message');
        $grid->column('processed')->bool();
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
        $show = new Show(ClientMessage::findOrFail($id));

        $show->id('ID');
        $show->name('name');
        $show->email('email');
        $show->phone('phone');
        $show->message('message');
        $show->processed('processed');
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
        $form = new Form(new ClientMessage);

        $form->display('id');
        $form->display('name', 'name');
        $form->display('email', 'email');
        $form->display('phone', 'phone');
        $form->display('message', 'message');
        $form->switch('is_processed', 'processed')
            ->states([
                'on' => ['value' => 1, 'text' => 'Processed'],
                'off' => ['value' => 0, 'text' => 'Not Processed'],
            ]);
        $form->display('created_at',trans('admin.created_at'));
        $form->display('updated_at',trans('admin.updated_at'));

        return $form;
    }
}
