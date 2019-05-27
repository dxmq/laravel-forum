<?php

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Encore\Admin\Auth\Database\Administrator::truncate();
        Encore\Admin\Auth\Database\Administrator::insert(
            [
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'name' => 'Administrator',
            ],
            [
                'username' => 'user1',
                'password' => bcrypt(123456),
                'name' => 'user1'
            ]
        );

        Encore\Admin\Auth\Database\Menu::truncate();
        Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    'parent_id' => 0,
                    'order' => 1,
                    'title' => 'Dashboard',
                    'icon' => 'fa-bar-chart',
                    'uri' => '/',
                ],
                [
                    'parent_id' => 0,
                    'order' => 2,
                    'title' => 'Admin',
                    'icon' => 'fa-tasks',
                    'uri' => '',
                ],
                [
                    'parent_id' => 2,
                    'order' => 3,
                    'title' => 'Users',
                    'icon' => 'fa-users',
                    'uri' => 'auth/users',
                ],
                [
                    'parent_id' => 2,
                    'order' => 4,
                    'title' => 'Roles',
                    'icon' => 'fa-user',
                    'uri' => 'auth/roles',
                ],
                [
                    'parent_id' => 2,
                    'order' => 5,
                    'title' => 'Permission',
                    'icon' => 'fa-ban',
                    'uri' => 'auth/permissions',
                ],
                [
                    'parent_id' => 2,
                    'order' => 6,
                    'title' => 'Menu',
                    'icon' => 'fa-bars',
                    'uri' => 'auth/menu',
                ],
                [
                    'parent_id' => 2,
                    'order' => 7,
                    'title' => 'Operation log',
                    'icon' => 'fa-history',
                    'uri' => 'auth/logs',
                ],
                [
                    'parent_id' => 0,
                    'order' => 8,
                    'title' => '文章管理',
                    'icon' => 'fa-book',
                    'uri' => 'posts'
                ],
                [
                    'parent_id' => 8,
                    'order' => 9,
                    'title' => '文章列表',
                    'icon' => 'fa-bars',
                    'uri' => 'posts',
                ],
                [
                    'parent_id' => 8,
                    'order' => 10,
                    'title' => '分类列表',
                    'icon' => 'fa-circle-o',
                    'uri' => 'categories',
                ],
                [
                    'parent_id' => 8,
                    'order' => 11,
                    'title' => '专题列表',
                    'icon' => 'fa-th',
                    'uri' => 'topics',
                ],
                [
                    'parent_id' => 8,
                    'order' => 12,
                    'title' => '评论列表',
                    'icon' => 'fa-commenting-o',
                    'uri' => 'comments',
                ],
                [
                    'parent_id' => 0,
                    'order' => 13,
                    'title' => '话题管理',
                    'icon' => 'fa-calendar',
                    'uri' => 'threads'
                ],
                [
                    'parent_id' => 13,
                    'order' => 14,
                    'title' => '话题列表',
                    'icon' => 'fa-list-alt',
                    'uri' => 'threads',
                ],
                [
                    'parent_id' => 13,
                    'order' => 15,
                    'title' => '回复列表',
                    'icon' => 'fa-reply',
                    'uri' => 'replies',
                ],
                [
                    'parent_id' => 13,
                    'order' => 16,
                    'title' => '频道列表',
                    'icon' => 'fa-rss',
                    'uri' => 'channels',
                ],
                [
                    'parent_id' => 0,
                    'order' => 17,
                    'title' => '用户管理',
                    'icon' => 'fa-user',
                    'uri' => 'users'
                ],
                [
                    'parent_id' => 17,
                    'order' => 18,
                    'title' => '用户列表',
                    'icon' => 'fa-circle-o',
                    'uri' => 'users',
                ],
            ]
        );

        Encore\Admin\Auth\Database\Permission::truncate();
        Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    'name' => 'All permission',
                    'slug' => '*',
                    'http_method' => '',
                    'http_path' => '*',
                ],
                [
                    'name' => 'Dashboard',
                    'slug' => 'dashboard',
                    'http_method' => 'GET',
                    'http_path' => '/',
                ],
                [
                    'name' => 'Login',
                    'slug' => 'auth.login',
                    'http_method' => '',
                    'http_path' => "/auth/login\r\n/auth/logout",
                ],
                [
                    'name' => 'User setting',
                    'slug' => 'auth.setting',
                    'http_method' => 'GET,PUT',
                    'http_path' => '/auth/setting',
                ],
                [
                    'name' => 'Auth management',
                    'slug' => 'auth.management',
                    'http_method' => '',
                    'http_path' => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
                ],
                [
                    'name' => 'posts',
                    'slug' => 'posts',
                    'http_method' => '',
                    'http_path' => "/posts\r\n/posts/*\r\n/categories\r\n/categories/*\r\n/topics\r\n/topics/*\r\n/comments\r\n/comments/*"
                ],
                [
                    'name' => 'threads',
                    'slug' => 'threads',
                    'http_method' => '',
                    'http_path' => "/threads\r\n/threads/*\r\n/replies\r\n/replies/*\r\n/channels\r\n/channels/*"
                ],
            ]
        );

        Encore\Admin\Auth\Database\Role::truncate();
        Encore\Admin\Auth\Database\Role::insert(
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
            ],
            [
                'name' => 'user1',
                'slug' => 'user1'
            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    'role_id' => 1,
                    'menu_id' => 2
                ],
                [
                    'role_id' => 1,
                    'menu_id' => 17
                ],
                [
                    'role_id' => 1,
                    'menu_id' => 18
                ],
                [
                    'role_id' => 2,
                    'menu_id' => 8
                ],
                [
                    'role_id' => 2,
                    'menu_id' => 9
                ],
                [
                    'role_id' => 2,
                    'menu_id' => 10
                ],
                [
                    'role_id' => 2,
                    'menu_id' => 11
                ],
                [
                    'role_id' => 2,
                    'menu_id' => 12
                ],
                [
                    'role_id' => 3,
                    'menu_id' => 13
                ],
                [
                    'role_id' => 3,
                    'menu_id' => 14
                ],
                [
                    'role_id' => 3,
                    'menu_id' => 15
                ],
                [
                    'role_id' => 3,
                    'menu_id' => 16
                ],
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    'role_id' => 1,
                    'permission_id' => 1
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 2
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 3
                ],
                [
                    'role_id' => 2,
                    'permission_id' => 6
                ],
                [
                    'role_id' => 3,
                    'permission_id' => 2
                ],
                [
                    'role_id' => 3,
                    'permission_id' => 3
                ],
                [
                    'role_id' => 3,
                    'permission_id' => 8
                ],
            ]
        );

        DB::table('admin_role_users')->truncate();
        DB::table('admin_role_users')->insert(
            [
                [
                    'role_id' => 1,
                    'user_id' => 1,
                ],
                [
                    'role_id' => 2,
                    'user_id' => 2
                ]
            ]
        );
        // finish
    }
}
