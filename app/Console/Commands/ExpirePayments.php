<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use Carbon\Carbon;

class ExpirePayments extends Command
{
    protected $signature = 'payment:expire';
    protected $description = 'Hapus payment & booking yang sudah expired';

    public function handle()
    {
        $expiredPayments = Payment::with('booking')
            ->where('payment_status', 'unpaid')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiredPayments as $payment) {
            if ($payment->booking) {
                $payment->booking->delete();
                // payment otomatis ikut kehapus (cascade)
            }
        }

        $this->info("Expired bookings cleaned: " . $expiredPayments->count());
    }
}

//
// php artisan schedule:work
//