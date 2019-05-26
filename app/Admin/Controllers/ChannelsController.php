<?php

namespace App\Admin\Controllers;

use App\Channel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ChannelsController extends Controller
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
        admin_toastr('删除频道会同时删除该频道下的所有话题，请慎重！', 'warning');

        return $content
            ->header('Channels')
            ->description('list')
            ->body($this->grid());
    }

    /**
     * @param Channel $channel
     * @param Content $content
     * @return Content
     */
    public function show(Channel $channel, Content $content)
    {
        return $content
            ->header('Channel')
            ->description('detail')
            ->body($this->detail($channel));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Channel);

        $grid->id('Id');
        $grid->name('Name');
        $grid->slug('Slug');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
        });

        $grid->filter(function ($filter) {
            $filter->like('name');
        });
        return $grid;
    }

    /**
     * @param $channel
     * @return Show
     */
    protected function detail($channel)
    {
        $show = new Show($channel);

        $show->id('Id');
        $show->name('Name');
        $show->slug('Slug');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Channel);

        $form->text('name', 'Name');
        $form->text('slug', 'Slug');

        return $form;
    }
}
