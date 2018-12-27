<?php

namespace App\Admin\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminColumnFilter;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\FormElements;

/**
 * Class Publications
 *
 * @property \App\Models\Publication $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Publications extends Section implements Initializable
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

    /**
     * @return DisplayInterface
     */

    public function initialize()
    {
        $this->title = 'Публикации';
        $this->icon = 'fa fa-fw fa-file-text-o';
    }

    public function onDisplay()
    {
        $display = \AdminDisplay::datatables()
            ->setColumns([
                AdminColumn::relatedLink('id', 'ID'),
                AdminColumn::text('title', 'Заголовок'),
                AdminColumn::text('block_body[0].block', 'Заголовок'),
                AdminColumn::custom("Тип", function(\Illuminate\Database\Eloquent\Model $model) {
                    if($model->type == 5)
                        return "Статья";
                    else
                        return "Вопрос";
                }),
                AdminColumn::custom("Тип", function(\Illuminate\Database\Eloquent\Model $model) {
                    return $model->extra["source"];
                }),
                \AdminColumnEditable::checkbox('status', 'Да',"Нет","Активен"),
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
                    ->addColumn([AdminFormElement::text('title', 'Название')]),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::textarea("extra['source']", 'Текст')->setModelAttributeKey("extra['source']")])
            ])
        );

        return $display;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
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
