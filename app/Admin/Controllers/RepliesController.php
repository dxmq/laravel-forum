<?php

namespace App\Admin\Controllers;

use App\Reply;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RepliesController extends Controller
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
            ->header('Replies')
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
    public function show($id, Content $content)
    {
        return $content
            ->header('Reply')
            ->description('detail')
            ->body($this->detail($id));
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reply);

        $grid->id('Id');
        $grid->thread()->title('Thread title');
        $grid->owner()->name('owner');
        $grid->body('Body')->display(function ($body) {
            return strip_tags($body);
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
        });

        $grid->filter(function ($filter) {
            $filter->where(function ($query) {

                $query->whereHas('thread', function ($query) {
                    $query->where('title', 'like', "%{$this->input}%");
                });

            }, '根据话题筛选回复（thread）');

            $filter->where(function ($query) {

                $query->whereHas('owner', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")->orWhere('email', 'like', "%{$this->input}%");
                });

            }, '谁回复的（name or email）');

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
    protected function detail($id)
    {
        $show = new Show(Reply::findOrFail($id));

        $show->id('Id');
        $show->thread_id('Thread id');
        $show->user_id('User id');
        $show->body('Body');
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
        $form = new Form(new Reply);

        $form->number('thread_id', 'Thread id');
        $form->number('user_id', 'User id');
        $form->textarea('body', 'Body');

        return $form;
    }
}
