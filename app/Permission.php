<?php

namespace App;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    protected $fillable = ['name', 'guard_name', 'group', 'cname'];
    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = 'api';
        parent::__construct($attributes);
    }
    public static function defaultPermissions()
    {
        return [
            ['view_role', '显示角色', '角色管理'],
            ['add_role', '添加角色', '角色管理'],
            ['edit_role', '编辑角色', '角色管理'],
            ['delete_role', '删除角色', '角色管理'],
            ['add_user', '添加用户', '用户管理'],
            ['edit_user', '编辑用户', '用户管理'],
            ['view_user', '显示用户', '用户管理'],
            ['delete_user', '删除用户', '用户管理'],
            ['view_users', '查看用户操作', '用户管理'],
            ['view_permission', '权限列表', '权限管理'],
            ['add_permission', '添加权限', '权限管理'],
            ['edit_permission', '编辑权限', '权限管理'],
            ['delete_permission', '删除权限', '权限管理'],
            ['add_menu', '添加栏目', '栏目管理'],
            ['edit_menu', '编辑栏目', '栏目管理'],
            ['delete_menu', '删除栏目', '栏目管理'],
            ['view_article', '文章列表', '内容管理'],
            ['add_article', '添加文章', '内容管理'],
            ['edit_article', '编辑文章', '内容管理'],
            ['delete_article', '删除文章', '内容管理'],
            ['view_tag', '查看标签', '标签管理'],
            ['add_tag', '添加标签', '标签管理'],
            ['edit_tag', '编辑标签', '标签管理'],
            ['delete_tag', '删除标签', '标签管理'],
            ['view_category', '查看分类', '分类管理'],
            ['add_category', '添加分类', '分类管理'],
            ['edit_category', '编辑分类', '分类管理'],
            ['delete_category', '删除分类', '分类管理'],
            ['view_link', '查看链接', '链接管理'],
            ['add_link', '添加链接', '链接管理'],
            ['delete_link', '删除链接', '链接管理'],
            ['view_comment', '查看评论', '评论管理'],
            ['delete_comment', '删除评论', '评论管理'],
            ['view_report', '查看报表', '报表管理'],
            ['view_log', '查看日志', '日志管理'],
            ['delete_log', '删除日志', '日志管理'],
            ['edit_link', '编辑链接', '链接管理'],
        ];
    }
}
