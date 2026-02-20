<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villes = ['Dakar', 'Thies', 'Saint-Louis', 'Ziguinchor', 'Touba'];
        $competences = ['PHP, Laravel', 'Vue.js, Tailwind', 'Node.js, React', 'Python, Django', 'Java, Spring'];

        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Membre::create([
                'nom' => 'Nom' . $i,
                'prenom' => 'Prenom' . $i,
                'email' => 'membre' . $i . '@example.com',
                'telephone' => '+221 77 ' . rand(100, 999) . ' ' . rand(1000, 9999),
                'ville' => $villes[array_rand($villes)],
                'competences' => $competences[array_rand($competences)],
                'statut' => (bool) rand(0, 1),
                'date_naissance' => now()->subYears(rand(20, 40))->subDays(rand(1, 365)),
                'adresse' => 'Adresse ' . $i . ' rue de ' . $villes[array_rand($villes)],
            ]);
        }
    }
}
