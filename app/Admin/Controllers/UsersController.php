<?php

namespace App\Admin\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
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
            ->header('Users')
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
    public function show(User $user, Content $content)
    {
        return $content
            ->header('User')
            ->description('detail')
            ->body($this->detail($user));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit(User $user, Content $content)
    {
        return $content
            ->header('User')
            ->description('edit')
            ->body($this->form()->edit($user->id));
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
            ->header('User')
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
        $grid = new Grid(new User);

        $grid->id('Id');
        $grid->name('名字');
        $grid->slug('Slug');
        $grid->email('邮箱');
        $grid->email_verified_at('邮箱验证时间')->display(function ($emailVerifiedAt) {
            return $emailVerifiedAt ?: 'null';
        });
        $grid->description('简介');
        $grid->github_name()->display(function ($githubName) {
            return $githubName ?: 'null';
        });
        $grid->provider('登录方式');
        $grid->avatar_path('头像地址');
        $grid->confirmed('Email is confirmed?')->display(function ($confirmed) {
            return $confirmed ? '是' : '否';
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        $grid->filter(function ($filter) {
            $filter->like('name');
            $filter->like('email');
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail(User $user)
    {
        $show = new Show($user);

        $show->id('Id');
        $show->name('Name');
        $show->slug('Slug');
        $show->email('Email');
        $show->email_verified_at('Email verified at');
        $show->password('Password');
        $show->description('Description');
        $show->avatar_path('Avatar path');
        $show->confirmed('Confirmed');
        $show->confirmation_token('Confirmation token');
        $show->remember_token('Remember token');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', 'Name');
        $form->text('slug', 'Slug');
        $form->email('email', 'Email');
        $form->datetime('email_verified_at', 'Email verified at')->default(date('Y-m-d H:i:s'));
        $form->password('password', 'Password');
        $form->text('description', 'Description');
        $form->text('avatar_path', 'Avatar path');
        $form->switch('confirmed', 'Confirmed');

        return $form;
    }
}
