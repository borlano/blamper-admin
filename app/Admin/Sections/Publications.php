<?php

namespace App\Admin\Sections;

use App\Models\Extra;
use App\Models\Files;
use App\Models\Publication;
use App\Models\Subject;
use App\Services\PublicationServices;
use Illuminate\Http\Request;
use PHPUnit\Util\RegularExpression;
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
use \MongoDB\BSON\ObjectID as MongoId;
/**
 * Class Publications
 *
 * @property \App\Models\Publication $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Publications extends Section implements Initializable
{
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
                AdminColumn::custom("Тип", function(\Illuminate\Database\Eloquent\Model $model) {
                    if($model->type == 5)
                        return "Статья";
                    else
                        return "Вопрос";
                }),
                AdminColumn::custom("Активен", function(\Illuminate\Database\Eloquent\Model $model) {
                    if($model->status == 1)
                        return "Да";
                    else
                        return "<span style='color:red'>Нет</span>";
                }),
                \AdminColumnEditable::text('subjects[0][name]', 'Рубрика'),
                \AdminColumn::datetime('created', 'Дата'),
            ])
            ->paginate(30)
        ->setApply(function ($q){
            return $q->orderBy("id", "DESC")->where("type",5);
        });
        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setPlaceholder('Заголовок'),
            null,
//            AdminColumnFilter::select([1 =>"Да",0 => "Нет"], 'Активен')
//                ->setDisplay('status')
//                ->setPlaceholder('Статус')
//                ->setColumnName('status'),
        ])->setplacement('table.header');
        return $display;
    }

    /**
     * @param int $id
     *
     * @param Request $request
     * @return FormInterface
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
     */
    public function onEdit($id,Request $request)
    {
        $display = AdminForm::form()->addElement(
            new FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('title', 'Заголовок')->required()])
                    ->addColumn([AdminFormElement::select('type', 'Тип',[5 => "Статья", 7 => "Вопрос"])->setDefaultValue(5)]),

                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::checkbox('status', 'Активен')->setDefaultValue(1)])
                    //->addColumn([AdminFormElement::checkbox('removed', 'Удален')])
                    ->addColumn([AdminFormElement::select('subject', 'Рубрика')->required()
                        ->setModelForOptions(Subject::class)
                        ->setLoadOptionsQueryPreparer(function($element,$q){
                            return $q->where("parent_id",1)->orWhere("id", "=",127)->where("is_table", false);
                        })
                        ->setDisplay('name')]),

                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::textarea("short_body", "Краткое описание")->required(),
                        AdminFormElement::image("extra.cover","Изображение")->setSaveCallback(function($file, $path, $filename) use ($id){
                            $withoutExt = Files::create()->_id;
                            $service = PublicationServices::genPathToFile($withoutExt);
                            //$file->move(public_path("/steady/".$service."/".$withoutExt), $withoutExt.".jpg"); //local
                            $file->move(public_path("/steady/".$service."/".$withoutExt), $withoutExt.".jpg"); //prod
                            PublicationServices::resizeImages($withoutExt.".jpg", $withoutExt);
                            return ['path' => "", 'value' => $withoutExt];
                        })->required()
                    ])
                    ->addColumn([AdminFormElement::wysiwyg("extra.source", "Текст","ckeditor")->setHeight(500)->required()])
            ])
        );
        return $display;
    }

    /**
     * @param Request $request
     * @return FormInterface
     * @throws \SleepingOwl\Admin\Exceptions\Form\Element\SelectException
     */
    public function onCreate(Request $request)
    {
        return $this->onEdit(null,$request);
    }

    public function isDeletable(Model $model)
    {
        return true;
    }

    public function onDelete($id, \Cviebrock\LaravelElasticsearch\Manager $elasticsearch){
        //dd($id);
        $data = [
            "index" => "publications",
            "type" => "default",
            "id" => $id,
        ];
        try {
            $elasticsearch->delete($data);
        }catch(\Exception $e){

        }
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    public function isEditable(Model $model)
    {
        return false;
    }
}
