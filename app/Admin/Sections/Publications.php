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
class Publications extends Section
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
                AdminColumn::relatedLink('user.phone', 'Пользователь'),
                AdminColumn::text('sum', 'Сумма операции'),
                AdminColumn::text('message', 'Комментарий'),
                AdminColumn::text('code', 'Код'),
                \AdminColumnEditable::checkbox('status','Получен','Не получен', 'Статус'),
                AdminColumn::datetime('created_at', 'Дата'),
                AdminColumn::datetime('expires_at', 'Истекает'),
                AdminColumn::custom('Относится', function ($model){
                    /** @var $model Operation */
                    if($model->document_type == Bonus::class){
                        $text = $model->operationable ? $model->operationable->name : 'Бонус профиля';
                        return "<a href='/admin/bonuses/{$model->document_id}/edit'>{$text}</a>";
                    } else {
                        $text = $model->operationable ? "чек № {$model->operationable->i}" : 'Чек ';
                        return "<a href='/admin/checks/{$model->document_id}/edit'>{$text}</a>";
                    }
                }),
                \AdminColumnEditable::checkbox('anullate','Да','Нет', 'Ануллирована'),
            ])
            ->paginate(30)
            ->setApply(function ($query) {
                $query->orderBy('created_at', 'desc');
            });
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
