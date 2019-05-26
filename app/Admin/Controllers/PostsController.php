<?php

namespace App\Admin\Controllers;

use App\Post;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PostsController extends Controller
{
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $content->breadcrumb(
            ['text' => '文章管理', 'url' => '/posts'],
            ['text' => '文章列表']
        );

        return $content
            ->header('Posts')
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
    public function show(Post $post, Content $content)
    {
        $content->breadcrumb(
            ['text' => '文章管理', 'url' => '/posts'],
            ['text' => '文章详情']
        );
        return $content
            ->header('Post')
            ->description('detail')
            ->body($this->detail($post));
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post);

        $grid->id('Id');
        $grid->title('标题');
        $grid->creator()->name('创建者');
        $grid->category()->name('分类');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            //关闭行操作 编辑
            $actions->disableEdit();
        });

        $grid->filter(function ($filter) {
            // 设置created_at字段的范围查询
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
    protected function detail($post)
    {
        $show = new Show($post);

        $show->id('Id');
        $show->title('Title');
        $show->slug('Slug');
        $show->body('Body');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
            });;

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Post);

        $form->text('title', 'Title');
        $form->text('slug', 'Slug');
        $form->textarea('body', 'Body');
        $form->text('user_id', 'User id');
        $form->number('category_id', 'Category id');

        return $form;
    }

    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }
}
