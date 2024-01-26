<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Department;
use App\Models\LeadSource;
use App\Models\PipelineStage;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ]);

        Branch::create([
            'name' => 'Karawaci'
        ]);

        Department::create([
            'name' => 'Sales'
        ]);

        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);

        $leadSources = [
            'Website',
            'Online AD',
            'Twitter',
            'LinkedIn',
            'Webinar',
            'Trade Show',
            'Referral',
        ];
        foreach ($leadSources as $leadSource) {
            LeadSource::create(['name' => $leadSource]);
        }

        $tags = [
            'Priority',
            'VIP'
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }

        $pipelineStages = [
            [
                'name' => 'Plan',
                'position' => 1,
                'is_default' => true,
            ],
            [
                'name' => 'Visit',
                'position' => 2,
            ],
            [
                'name' => 'Proposed',
                'position' => 3,
            ],
            [
                'name' => 'Final',
                'position' => 4,
            ],
            [
                'name' => 'Productivity',
                'position' => 5,
            ],
            [
                'name' => 'Actual',
                'position' => 6,
            ],
            [
                'name' => 'Reject',
                'position' => 7,
            ]
        ];

        foreach ($pipelineStages as $stage) {
            PipelineStage::create($stage);
        }

        $this->call(PermissionSeeder::class);
    }
}
