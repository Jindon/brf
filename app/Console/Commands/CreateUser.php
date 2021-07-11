<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->option('password') ?? 'welcome';
        $name = substr($email, 0, strpos($email, '@'));

        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
            $this->info('User was created successfully!');
        } catch(\Exception $error) {
            dump($error->getMessage());
            $this->error('An error occurred, please try again!');
        }
    }
}
