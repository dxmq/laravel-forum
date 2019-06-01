<?php

namespace App\Admin\Controllers;

use App\Thread;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ThreadsController extends Controller
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
            ->header('Threads')
            ->description('list')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show(Thread $thread, Content $content)
    {
        return $content
            ->header('Thread')
            ->description('detail')
            ->body($this->detail($thread));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Thread);

        $grid->id('Id');
        $grid->creator()->name('创建者');
        $grid->channel()->name('频道');
        $grid->replies_count('回复数');
        $grid->title('标题');
        $grid->best_reply_id('Best reply id')->display(function ($bestReplyId) {
            return $bestReplyId ?: 'null';
        });
        $grid->locked('Locked')->display(function ($locked) {
            return $locked ? '是' : '否';
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
        });

        $grid->filter(function ($filter) {
            $filter->like('title');


            $filter->where(function ($query) {

                $query->whereHas('channel', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });

            }, '频道');

            $filter->where(function ($query) {

                $query->whereHas('creator', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")->orWhere('email', 'like', "%{$this->input}%");
                });

            }, '创建者名字或邮箱');

            $filter->between('created_at', 'Created Time')->datetime();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($thread)
    {
        $show = new Show($thread);

        $show->id('Id');
        $show->slug('Slug');
        $show->replies_count('Replies count');
        $show->title('Title');
        $show->body('Body')->display(function ($body) {
            return strip_tags($body);
        });
        $show->best_reply_id('Best reply id');
        $show->locked('Locked');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        $show->panel()
            ->tools(function ($tools) {
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
        $form = new Form(new Thread);

        $form->text('slug', 'Slug');
        $form->number('user_id', 'User id');
        $form->number('channel_id', 'Channel id');
        $form->number('replies_count', 'Replies count');
        $form->text('title', 'Title');
        $form->textarea('body', 'Body');
        $form->number('best_reply_id', 'Best reply id');
        $form->switch('locked', 'Locked');

        return $form;
    }
}
