<?php

namespace App\Admin\Sections;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class AutoMarks
 *
 * @property \App\Models\AutoMark $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class AutoMarks extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    public function initialize()
    {
        $this->title = 'Марки автомобилей';
        $this->icon = 'fa fa-fw fa-file-text-o';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = \AdminDisplay::datatables()
            ->setColumns([
                \AdminColumn::relatedLink('mark_id', 'ID'),
                \AdminColumn::text('name_ru', 'Название'),
            ])
            ->paginate(30);
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        // remove if unused
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function isEditable(Model $model)
    {
        return false;
    }

    public function isDeletable(Model $model)
    {
        return false;
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
