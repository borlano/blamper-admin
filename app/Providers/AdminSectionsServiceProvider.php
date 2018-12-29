<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        \App\Models\Publication::class => 'App\Admin\Sections\Publications',
        \App\Models\User::class => 'App\Admin\Sections\Users',
        \App\Models\AutoMark::class => 'App\Admin\Sections\AutoMarks',
        \App\Models\AutoModel::class => 'App\Admin\Sections\AutoModels',
        \App\Models\Subject::class => 'App\Admin\Sections\Subjects',
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}
