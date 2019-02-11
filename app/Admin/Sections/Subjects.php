<?php

namespace App\Admin\Sections;

use App\Models\Subject;
use App\Services\PublicationServices;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use Illuminate\Http\Request;
use PHPUnit\Util\RegularExpression;
use AdminColumn;
use AdminForm;
use AdminColumnFilter;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SleepingOwl\Admin\Form\FormElements;

/**
 * Class Subject
 *
 * @property \App\Models\Subject $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Subjects extends Section implements Initializable
{
    public function initialize()
    {
        $this->title = 'Рубрики';
        $this->icon = 'fa fa-fw fa-file-text-o';
    }
    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables()
            ->setColumns([
                AdminColumn::text('id', '№'),
                AdminColumn::text('name', 'Заголовок'),
            ])
            ->setApply(function ($q){
                return $q->where("parent_id",1)->orWhere("id", "=",127)->where("is_table", false);
            })
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
                    ->addColumn([AdminFormElement::text('name', 'Название')])
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

    public function isDeletable(Model $model)
    {
        return true;
    }
}
