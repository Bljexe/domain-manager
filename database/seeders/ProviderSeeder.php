<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            ['name' => 'Hostinger', 'status' => true],
            ['name' => 'GoDaddy', 'status' => true],
            ['name' => 'Namecheap', 'status' => true],
            ['name' => 'Bluehost', 'status' => true],
            ['name' => 'Cloudflare', 'status' => true],
            ['name' => 'Google Domains', 'status' => true],
            ['name' => 'AWS Route 53', 'status' => true],
            ['name' => 'HostGator', 'status' => true],
        ];

        foreach ($providers as $provider) {
            Provider::updateOrCreate(['name' => $provider['name']], $provider);
        }
    }
}
