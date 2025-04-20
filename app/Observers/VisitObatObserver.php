<?php

namespace App\Observers;

use App\Models\VisitObat;

class VisitObatObserver
{
    /**
     * Handle the VisitObat "created" event.
     */
    public function created(VisitObat $visitObat): void
    {
        //
    }

    /**
     * Handle the VisitObat "updated" event.
     */
    public function updated(VisitObat $visitObat): void
    {
        //
    }

    public function saved($visitObat)
    {
        $visitObat->kunjungan->payment?->updateTotalTagihan();
    }

    /**
     * Handle the VisitObat "deleted" event.
     */


    public function deleted(VisitObat $visitObat): void
    {
        $visitObat->kunjungan->payment?->updateTotalTagihan();
    }

    /**
     * Handle the VisitObat "restored" event.
     */
    public function restored(VisitObat $visitObat): void
    {
        //
    }

    /**
     * Handle the VisitObat "force deleted" event.
     */
    public function forceDeleted(VisitObat $visitObat): void
    {
        //
    }
}
