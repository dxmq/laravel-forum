<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Laravelista\Comments\Comment;

class CommentsController extends Controller
{
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Comments')
            ->description('list')
            ->body($this->grid());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->id('Id');
        $grid->commenter()->name('评论者');
        $grid->commentable_type('Commentable type');
        $grid->commentable()->title('评论的文章');
        $grid->comment('内容');
        $grid->child_id('Child id');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            $filter->like('comment', '评论内容');
            $filter->where(function ($query) {

                $query->whereHas('commenter', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });

            }, '用户');
            $filter->between('created_at', 'Created Time')->datetime();
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
        $form = new Form(new Comment());

        $form->number('commenter_id', 'Commenter id');
        $form->text('commentable_type', 'Comentable type');
        $form->number('commentable_id', 'Commentable id');
        $form->text('comment', 'Comment');
        $form->number('child_id', 'Child id');

        return $form;
    }

    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }
}
