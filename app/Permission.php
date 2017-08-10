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
            ['view_report', '查看报表', '报表管理'],
            ['view_log', '查看日志', '日志管理'],
            ['delete_log', '删除日志', '日志管理'],
            ['view_hospital', '查看医院', '医院管理'],
            ['add_hospital', '添加医院', '医院管理'],
            ['edit_hospital', '编辑医院', '医院管理'],
            ['delete_hospital', '删除医院', '医院管理'],
            ['view_department', '查看科室', '科室管理'],
            ['add_department', '添加科室', '科室管理'],
            ['edit_department', '编辑科室', '科室管理'],
            ['delete_department', '删除科室', '科室管理'],
            ['view_doctor', '查看医生', '医生管理'],
            ['add_doctor', '添加医生', '医生管理'],
            ['edit_doctor', '编辑医生', '医生管理'],
            ['delete_doctor', '删除医生', '医生管理'],
            ['view_disease', '查看疾病', '疾病管理'],
            ['add_disease', '添加疾病', '疾病管理'],
            ['edit_disease', '编辑疾病', '疾病管理'],
            ['delete_disease', '删除疾病', '疾病管理'],
            ['view_media', '查看媒体', '媒体管理'],
            ['add_media', '添加媒体', '媒体管理'],
            ['edit_media', '编辑媒体', '媒体管理'],
            ['delete_media', '删除媒体', '媒体管理'],
            ['view_depart', '查看部门', '部门管理'],
            ['add_depart', '添加部门', '部门管理'],
            ['edit_depart', '编辑部门', '部门管理'],
            ['delete_depart', '删除部门', '部门管理'],
            ['view_patient', '查看预约', '预约管理'],
            ['add_patient', '添加预约', '预约管理'],
            ['edit_patient', '编辑预约', '预约管理'],
            ['delete_patient', '删除预约', '预约管理'],
        ];
    }
}
