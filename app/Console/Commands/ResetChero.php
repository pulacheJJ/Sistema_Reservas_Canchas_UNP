<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetChero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-chero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = \App\Models\User::where('name', 'like', '%Chero Sandoval%')->first();
        if ($user) {
            $this->info("User found: " . $user->name . " (ID: " . $user->id . ")");
            $user->reservas()->delete();
            try {
                $user->update(['sanciones' => 0, 'is_sancionado' => false, 'motivo_sancion' => null]);
            } catch (\Exception $e) {
                $user->update(['is_sancionado' => false, 'motivo_sancion' => null]);
            }
            // Also reset password to default
            $user->password = \Illuminate\Support\Facades\Hash::make('12345678');
            $user->save();
            $this->info("Reservations deleted, penalties removed, and password reset to '12345678'.");
        } else {
            $this->error("User not found.");
        }
    }
}
