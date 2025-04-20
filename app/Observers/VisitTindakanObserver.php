<?php

namespace App\Observers;

use App\Models\VisitTindakan;

class VisitTindakanObserver
{
    /**
     * Handle the VisitTindakan "created" event.
     */
    public function created(VisitTindakan $visitTindakan): void
    {
        //
    }

    /**
     * Handle the VisitTindakan "updated" event.
     */
    public function updated(VisitTindakan $visitTindakan): void
    {
        //
    }

    public function saved($visitTindakan)
    {
        $visitTindakan->kunjungan->payment?->updateTotalTagihan();
    }

    /**
     * Handle the VisitTindakan "deleted" event.
     */
    public function deleted(VisitTindakan $visitTindakan): void
    {
        $visitTindakan->kunjungan->payment?->updateTotalTagihan();
    }

    /**
     * Handle the VisitTindakan "restored" event.
     */
    public function restored(VisitTindakan $visitTindakan): void
    {
        //
    }

    /**
     * Handle the VisitTindakan "force deleted" event.
     */
    public function forceDeleted(VisitTindakan $visitTindakan): void
    {
        //
    }
}
