<?php

namespace App\Admin\Sections;

use App\Models\AutoMark;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Form\FormElements;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminColumnFilter;
use AdminFormElement;

/**
 * Class AutoModels
 *
 * @property \App\Models\AutoModel $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class AutoModels extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Модели автомобилей';
        $this->icon = 'fa fa-fw fa-file-text-o';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = \AdminDisplay::datatables()
            ->setColumns([
                \AdminColumn::relatedLink('model_id', 'ID'),
                \AdminColumn::text('model_name', 'Название модели'),
                \AdminColumn::text('mark.name_ru', 'Название марки'),

            ])
            ->paginate(30);
        return $display;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function onEdit($id)
    {
        $display = AdminForm::form()->addElement(
            new FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name_ru', 'Название(ru)')->required()])
                    ->addColumn([AdminFormElement::text('model_name', 'Название(en)')->required()]),
//                AdminFormElement::columns()
//                    ->addColumn([AdminFormElement::select('mark_id', 'Марка')
//                        ->setOptions(AutoMark::getAutoMarks())
//                    ]),
            ])
        );
        return $display;
    }

    /**
     * @return void
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    public function isEditable(Model $model)
    {
        return true;
    }

    public function isDeletable(Model $model)
    {
        return false;
    }
}
