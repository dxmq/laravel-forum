<?php

namespace App\Admin\Controllers;

use App\Comment;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Comment')
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
        $grid = new Grid(new Comment);

        $grid->id('Id');
        $grid->owner()->name('Creator');
        $grid->post()->title('Title');
        $grid->body('Body');
        $grid->parent_id('Parent id');
        $grid->level('Level');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
        });

        $grid->filter(function ($filer) {
            $filer->like('title');
            $filer->like('body');
            $filer->between('created_at', 'Created Time')->datetime();
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
        $show = new Show(Comment::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->post_id('Post id');
        $show->parent_id('Parent id');
        $show->body('Body');
        $show->level('Level');
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
        $form = new Form(new Comment);

        $form->number('user_id', 'User id');
        $form->number('post_id', 'Post id');
        $form->number('parent_id', 'Parent id');
        $form->textarea('body', 'Body');
        $form->number('level', 'Level');

        return $form;
    }

    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }
}
