<?php

namespace App\Observers;

use App\Models\Cases;
use App\Models\Company;

class CaseObserver
{
    /**
     * Handle the Cases "created" event.
     *
     * @param  \App\Models\Cases  $cases
     * @return void
     */
    public function created(Cases $cases)
    {
        if($cases->company_id > 0){
            Company::where('id', $cases->company_id)->update([
                'last_active' => now()
            ]);
        }
    }

    /**
     * Handle the Cases "updated" event.
     *
     * @param  \App\Models\Cases  $cases
     * @return void
     */
    public function updated(Cases $cases)
    {
        if($cases->company_id > 0){
            Company::where('id', $cases->company_id)->update([
                'last_active' => now()
            ]);
        }
    }

    /**
     * Handle the Cases "deleted" event.
     *
     * @param  \App\Models\Cases  $cases
     * @return void
     */
    public function deleted(Cases $cases)
    {
        if($cases->company_id > 0){
            Company::where('id', $cases->company_id)->update([
                'last_active' => now()
            ]);
        }
    }

    /**
     * Handle the Cases "restored" event.
     *
     * @param  \App\Models\Cases  $cases
     * @return void
     */
    public function restored(Cases $cases)
    {
        if($cases->company_id > 0){
            Company::where('id', $cases->company_id)->update([
                'last_active' => now()
            ]);
        }
    }

    /**
     * Handle the Cases "force deleted" event.
     *
     * @param  \App\Models\Cases  $cases
     * @return void
     */
    public function forceDeleted(Cases $cases)
    {
        if($cases->company_id > 0){
            Company::where('id', $cases->company_id)->update([
                'last_active' => now()
            ]);
        }
    }
}
