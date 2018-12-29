<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 29.12.2018
 * Time: 12:54
 */

namespace App\Admin\Tree;

use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Display\Tree\BaumNodeType;

/**
 * @see https://github.com/etrepat/baum
 */
class SubjectTree extends BaumNodeType
{
    /**
     * Get tree structure.
     *
     * @param \Illuminate\Database\Eloquent\Collection $collection
     *
     * @return mixed
     */
//    public function getTree(\Illuminate\Database\Eloquent\Collection $collection)
//    {
//        return $collection->toSortedHierarchy();
//    }
}