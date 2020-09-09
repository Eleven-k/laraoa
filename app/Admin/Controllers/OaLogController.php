<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\OaLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class OaLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OaLog(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('finish');
            $grid->column('content');
            $grid->column('unfinished');
            $grid->column('user_id');
            $grid->column('reply_count');
            $grid->column('view_count');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->toolsWithOutline(false);
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
        return Show::make($id, new OaLog(), function (Show $show) {
            $show->field('id');
            $show->field('finish');
            $show->field('content');
            $show->field('unfinished');
            $show->field('user_id');
            $show->field('reply_count');
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
        return Form::make(new OaLog(), function (Form $form) {
            $form->display('id');

            $form->hasMany('finish', function (Form\NestedForm $form) {
                $form->text('plan');
                $form->slider('schedule')->options(['max' => 100, 'min' => 1, 'step' => 1, 'postfix' => '%']);
            })->useTable()->saving(function ($v) {
                return json_encode($v);
            });

           $form->editor('content')->rules('required|min:5', [
                'required' => '内容不能为空',
                'min' => '内容不能少于5个字符',
            ]);
            
            $form->hasMany('unfinished', function (Form\NestedForm $form) {
                $form->text('plan');
            })->useTable()->saving(function ($v) {
                return json_encode($v);
            });


            // $form->hasMany('tomorrow_work', function (Form\NestedForm $form) {
            //     $form->text('title');
            // })->useTable();

            // $form->embeds('title', function ($form) {
            //     $form->text('key1');
            //     $form->slider('key2')->options(['max' => 100, 'min' => 1, 'step' => 1, 'postfix' => '%']);
            // })->saving(function ($v) {
            //     return json_encode($v);
            // });
            
            // $form->list('title')->rules('required|min:5');

            $form->hidden('user_id')->default(1);
            $form->hidden('reply_count')->default(0);
            $form->hidden('view_count')->default(0);
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
