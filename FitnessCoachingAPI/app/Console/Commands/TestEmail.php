<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Client;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if (!$email) {
            // Try to get a client email from database
            $client = Client::first();
            if ($client) {
                $email = $client->email;
                $this->info("Using client email: {$email}");
            } else {
                $email = $this->ask('Enter email address to send test email to:');
            }
        }

        if (!$email) {
            $this->error('Email address is required!');
            return 1;
        }

        $this->info("Sending test email to: {$email}");

        try {
            // Create a dummy client for the email template
            $client = Client::where('email', $email)->first();
            
            if (!$client) {
                // Create a temporary client object for testing
                $client = new Client([
                    'full_name' => 'Test User',
                    'email' => $email,
                ]);
            }

            Mail::send('emails.client-approved', ['client' => $client], function ($message) use ($email, $client) {
                $message->to($email, $client->full_name)
                    ->subject('Test Email - Fitness Coaching System');
            });

            $this->info('✅ Email sent successfully!');
            $this->info('Check your inbox (or Mailtrap if using it).');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Common issues:');
            $this->line('1. Check your .env file has correct MAIL_* settings');
            $this->line('2. Run: php artisan config:clear');
            $this->line('3. Verify your email credentials are correct');
            $this->line('4. Check storage/logs/laravel.log for detailed errors');
            
            return 1;
        }
    }
}

