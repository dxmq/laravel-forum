<?php

namespace App\Admin\Controllers;

use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ActivitiesController extends Controller
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
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity);

        $grid->id('Id');
        $grid->log_name('Log name');
        $grid->description('Description');
        $grid->subject_id('Subject id');
        $grid->subject_type('Subject type');
        $grid->causer_id('Causer id');
        $grid->causer_type('Causer type');
        $grid->properties('Properties');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();

            $filter->between('created_at', '创建时间')->datetime();
        });
        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Activity);

        $form->text('log_name', 'Log name');
        $form->textarea('description', 'Description');
        $form->number('subject_id', 'Subject id');
        $form->text('subject_type', 'Subject type');
        $form->number('causer_id', 'Causer id');
        $form->text('causer_type', 'Causer type');
        $form->text('properties', 'Properties');

        return $form;
    }
}
