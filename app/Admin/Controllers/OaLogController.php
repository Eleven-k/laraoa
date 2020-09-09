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
            $grid->column('title');
            $grid->column('content');
            $grid->column('user_id');
            $grid->column('reply_count');
            $grid->column('view_count');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->enableDialogCreate();
            $grid->toolsWithOutline(false);
            $grid->setDialogFormDimensions('50%', '60%');
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
            $show->field('title');
            $show->field('content');
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
            $form->text('title')->rules('required|min:2');
            $form->textarea('content')->rules('required|min:5');
            $form->text('user_id')->default(1);
            $form->text('reply_count')->default(0);
            $form->text('view_count')->default(0);
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
