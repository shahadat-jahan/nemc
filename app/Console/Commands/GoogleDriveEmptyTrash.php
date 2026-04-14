<?php

namespace App\Console\Commands;

use Exception;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoogleDriveEmptyTrash extends Command
{
    protected $signature = 'google:empty-trash';
    protected $description = 'Empty Google Drive Trash';

    public function handle()
    {
        $this->comment('Starting to empty Google Drive trash...');

        // Set up Google Client
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->addScope(Drive::DRIVE);
        $client->refreshToken(config('services.google.refresh_token'));

        $service = new Drive($client);

        $this->info('Emptying Google Drive trash...');

        // Empty trash
        try {
            $service->files->emptyTrash();
            $this->info("Google Drive trash emptied successfully!");
            Log::info('Google Drive trash emptied successfully!');
        } catch (Exception $e) {
            $this->error("Google Drive trash emptied unsuccessfully: " . $e->getMessage());
            Log::error('Google Drive trash emptied unsuccessfully: ' . $e->getMessage());
        }
        $this->comment('Finished emptying Google Drive trash!');
    }
}
