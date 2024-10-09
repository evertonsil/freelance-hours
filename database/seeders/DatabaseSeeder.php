<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(200)->create();

        //fazendo uma consulta com 10 usuários de forma randômica
        User::query()->inRandomOrder()->limit(10)->get()
            //a cada usuário cria um novo projeto
            ->each(fn(User $u) => Project::factory()->create(['created_by' => $u->id]));
    }
}
