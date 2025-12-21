<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@ehb.be')->first();

        News::updateOrCreate(
            ['title' => 'Nieuwe activiteiten in de moskee'],
            [
                'content' => "Dit is een voorbeeld nieuwsbericht.\n\nHier kan je later echte nieuwsitems plaatsen via het admin panel.",
                'published_at' => Carbon::now()->subDays(3),
                'created_by' => $admin?->id,
                'image_path' => null,
            ]
        );

        News::updateOrCreate(
            ['title' => 'Ramadan: gebedstijden en iftar'],
            [
                'content' => "Ramadan Mubarak!\n\nBekijk hier de gebedstijden en praktische info rond iftar.",
                'published_at' => Carbon::now()->subDay(),
                'created_by' => $admin?->id,
                'image_path' => null,
            ]
        );

        News::updateOrCreate(
            ['title' => 'Vrijwilligers gezocht'],
            [
                'content' => "We zoeken vrijwilligers voor evenementen en onderhoud.\n\nInteresse? Neem contact op via het contactformulier.",
                'published_at' => Carbon::now()->subHours(4),
                'created_by' => $admin?->id,
                'image_path' => null,
            ]
        );
    }
}

