<?php

namespace App\Admin\Sections;

use App\Models\AutoMark;
use App\Models\AutoModel;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Form\FormElements;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminColumnFilter;
use AdminFormElement;

/**
 * Class AutoMarks
 *
 * @property \App\Models\AutoMark $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class AutoMarks extends Section implements Initializable
{
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
                \AdminColumn::text('mark_id', 'ID'),
                \AdminColumnEditable::text('name_ru', 'Название(ru)'),
                \AdminColumnEditable::text('mark_name', 'Название(en)'),
                \AdminColumn::text('slug', 'Алиас'),
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
        $display = AdminForm::form()->addElement(
            new FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('name_ru', 'Название(ru)')->required()])
                    ->addColumn([AdminFormElement::text('mark_name', 'Название(en)')->required()]),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('description_url', 'Ссылка на детальное описание')]),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::ckeditor('description', 'Описание')]),
//                AdminFormElement::columns()
//                    ->addColumn([AdminFormElement::multiselect('models','Модели')
//                        ->setOptions(AutoModel::getAutoModels())
//                        ->required()
//                    ]),
            ])
        );
        return $display;
    }

    /**
     * @return FormInterface
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
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
