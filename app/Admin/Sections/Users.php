<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 27.12.2018
 * Time: 16:49
 */

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

class Users extends Section implements Initializable
{
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
        $this->title = 'Пользователи';
        $this->icon = 'fa fa-fw fa-file-text-o';
    }

    public function onDisplay()
    {
        $display = \AdminDisplay::datatables()
            ->setColumns([
                AdminColumn::relatedLink('id', 'ID'),
                AdminColumn::text('email', 'Email'),
                AdminColumn::text('profile.firstname', 'Имя'),
                AdminColumn::text('profile.lastname', 'Фамилия'),
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
        $display = AdminForm::form()->addElement(
            new FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('s', 'Название')->setReadonly(1)])
                    ->addColumn([AdminFormElement::datetime('created', 'дата и время чека')->setReadonly(1)]),

                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('fn', 'Номер фиксального накопителя')->setReadonly(1)])
                    ->addColumn([AdminFormElement::text('i', 'Номер фиксального документа')->setReadonly(1)]),
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