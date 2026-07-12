<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\AnnouncementMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onyx:announce 
                            {--subject= : The subject of the announcement} 
                            {--message= : The message content of the announcement}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an announcement email to all active users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $subject = $this->option('subject');
        $message = $this->option('message');

        if (!$subject) {
            $subject = $this->ask('Enter the announcement subject:');
        }

        if (!$message) {
            $message = $this->ask('Enter the announcement message:');
        }

        if (empty($subject) || empty($message)) {
            $this->error('Subject and message cannot be empty.');
            return Command::FAILURE;
        }

        $users = User::active()->get();

        if ($users->isEmpty()) {
            $this->info('No active users found.');
            return Command::SUCCESS;
        }

        $this->info("Queuing announcement to {$users->count()} active users...");

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new AnnouncementMail($user, $subject, $message));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to queue announcement to {$user->email}: " . $e->getMessage());
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Announcement queued successfully to all active users.');

        return Command::SUCCESS;
    }
}
