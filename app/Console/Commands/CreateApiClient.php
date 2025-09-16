<?php

namespace App\Console\Commands;

use App\Models\ApiClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateApiClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Example usage: php artisan api-client:create
     */
    protected $signature = 'api-client:create
                            {name? : The name of the client}
                            {email? : The email of the client}
                            {--password= : Optional password (will be generated if not provided)}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new API client and issue a Sanctum token';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name') ?? $this->ask('Client name');
        $email = $this->argument('email') ?? $this->ask('Client email');

        $password = $this->option('password') ?? str()->random(16);

        $client = ApiClient::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $token = $client->createToken('default')->plainTextToken;

        $this->info('✅ API Client created successfully!');
        $this->line("ID: {$client->id}");
        $this->line("Name: {$client->name}");
        $this->line("Email: {$client->email}");
        $this->line("Password: {$password}");
        $this->line("Token: {$token}");

        return self::SUCCESS;
    }
}
