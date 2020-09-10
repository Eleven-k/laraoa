<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\OaDiary;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Admin;

class OaDiaryController extends AdminController
{
    public static $css = [
        '/static/css/diary.css',
    ];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OaDiary(), function (Grid $grid) {
            // $grid->column('id')->sortable();
            $grid->column('created_at');
            $grid->column('content')->replace();
            // $grid->column('finish');
            $grid->column('user_id');
            $grid->column('reply_count');
            // $grid->column('unfinished');
            $grid->column('view_count');

            // $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new OaDiary(), function (Show $show) {
            $show->field('id');
            $show->field('content');
            $show->field('finish');
            $show->field('reply_count');
            $show->field('unfinished');
            $show->field('user_id');
            $show->field('view_count');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        Admin::css(static::$css);
        return Form::make(new OaDiary(), function (Form $form) {
            $form->display('id');

            $form->table('finish', function ($table) {
                $table->text('plan');
                $table->slider('schedule')->options(['max' => 100, 'min' => 1, 'step' => 10, 'postfix' => '%']);
            })->saveAsJson()->disable();

            $form->editor('content')->rules('required|min:5', [
                'required' => '内容不能为空',
                'min' => '内容不能少于5个字符',
            ])->saveAsString();

            $form->table('unfinished', function ($table) {
                $table->text('plan');
            })->saveAsJson();

            $form->hidden('user_id')->value(Admin::user()->name);
            $form->hidden('reply_count')->default(0);
            $form->hidden('view_count')->default(0);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
