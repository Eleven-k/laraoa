<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\OaDiary;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Admin;
use Dcat\Admin\Support\JavaScript;

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
            $grid->column('created_at')->sortable()->width('12%');

            $grid->column('content')->display(function ($content) {
                $content_01 = $content;
                $content_02 = htmlspecialchars_decode($content_01);
                $content_03 = str_replace("&nbsp;", "", $content_02);
                $contents = strip_tags($content_03);
                $con = mb_substr($contents, 0, 100, "utf-8");
                return $con;
            })->limit(69)->link(function ($value) {
                return admin_url('diaries/', $this->id);
            })->width('67%');

            // $grid->column('finish');
            $grid->column('user_id')->width('10%');
            $grid->column('reply_count')->width('5%');
            // $grid->column('unfinished');
            $grid->column('view_count')->width('6%');

            // $grid->column('updated_at')->sortable();

            $grid->model()->orderBy('id', 'desc');
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
            $show->field('finish')->explode()->label();
            $show->field('content')->unescape();
            $show->field('unfinished');
            // $show->field('user_id');
            // $show->field('reply_count');
            // $show->field('view_count');
            $show->field('created_at');
            // $show->field('updated_at');

            // $show->row(function (Show\Row $show) {
            //     $show->width(3)->id;
            // });

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
                $table->slider('schedule')->options(['max' => 100, 'min' => 1,'step' => 10, 'grid' => false, ]);
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
