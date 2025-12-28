<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->info('🌱 Iniciando seed do banco de dados...');

        $this->call(RoleSeeder::class);
        $this->command->info('✅ Roles criadas');

        $this->call(DemoChurchSeeder::class);
        $this->command->info('✅ Igreja de demonstração criada');

        $this->command->info('🎉 Seed concluído com sucesso!');
        $this->command->newLine();
        $this->command->info('📧 Email de acesso: pastor@demo.com');
        $this->command->info('🔑 Senha: password');
    }
}
