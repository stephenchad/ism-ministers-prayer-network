<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\BirthdayNotification;
use App\Mail\BirthdayMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class CheckBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'check:birthdays';

    /**
     * The console command description.
     */
    protected $description = 'Check for users with birthdays today and send birthday messages and notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $users = User::whereMonth('birthday', $today->month)
                     ->whereDay('birthday', $today->day)
                     ->get();

        if ($users->isEmpty()) {
            $this->info('No birthdays today.');
            return 0;
        }

        foreach ($users as $user) {
            // Send birthday email
            Mail::to($user->email)->send(new BirthdayMessage($user));

            // Notify admins
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new BirthdayNotification($user));

            $this->info('Sent birthday wishes to: ' . $user->email);
        }

        return 0;
    }
}
