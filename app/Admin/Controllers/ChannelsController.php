<?php

namespace App\Admin\Controllers;

use App\Channel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

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
        $content->withInfo('注意：', '删除频道会同时删除该频道下的所有话题，请慎重！');

        return $content
            ->header('Channels')
            ->description('list')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit(Channel $channel, Content $content)
    {
        return $content
            ->header('Channel')
            ->description('edit')
            ->body($this->form()->edit($channel->id));
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
            ->header('Channel')
            ->description('create')
            ->body($this->form());
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
        $grid->name('名字');
        $grid->slug('Slug');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->filter(function ($filter) {
            $filter->like('name');
        });

        $grid->actions(function ($actions) {
            //关闭行操作 编辑
            $actions->disableView();
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
        $form = new Form(new Channel);

        $form->text('name', 'Name')->rules('required|max:15|unique:channels');

        return $form;
    }

    public function update($id)
    {
        $this->form()->update($id);

        $channel = Channel::findOrFail($id);
        $channel->slug = $channel->name;
        $channel->save();

        return redirect('/admin/channels');
    }
}
