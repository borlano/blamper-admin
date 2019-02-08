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
                \AdminColumn::datetime('created', 'Дата регистрации'),
            ])
            ->paginate(30)
            ->setApply(function ($query) {
                $query->orderBy('created_at', 'desc');
            });
        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setPlaceholder('Email'),
//            AdminColumnFilter::text()->setPlaceholder('Имя'),
//            AdminColumnFilter::text()->setPlaceholder('Фамилия'),
        ])->setplacement('table.header');
        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        //dd($this->model->qa_roles);
        $display = AdminForm::form()->addElement(
            new FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('email', 'Email')]),
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('profile.firstname', 'Имя')])
                    ->addColumn([AdminFormElement::text('profile.lastname', 'Фамилия')])
                    ->addColumn([AdminFormElement::select('qa_role', "Роль на форуме",$this->model->qa_roles)])
                    ->addColumn([AdminFormElement::select('adminRole', "Роль на сайте",$this->model->admin_roles)])
                    ->addColumn([AdminFormElement::hidden('_id')]),
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
        return false;
    }
}