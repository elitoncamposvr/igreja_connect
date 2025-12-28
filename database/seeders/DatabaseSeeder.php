<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Iniciando seed do banco de dados...');
        $this->command->newLine();

        // 1. Roles do sistema (independente de igreja)
        $this->call(RoleSeeder::class);
        $this->command->info('✅ Roles criadas');
        $this->command->newLine();

//        $this->call(CategorySeeder::class);
//        $this->command->info('✅ Categorias criadas');
//        $this->command->newLine();
//
//        $this->call(PaymentMethodSeeder::class);
//        $this->command->info('✅ Métodos de pagamento criados');
//        $this->command->newLine();
//
//        $this->call(MessageTemplateSeeder::class);
//        $this->command->info('✅ Template de mensagens criados');
//        $this->command->newLine();

//      2. Igreja de demonstração (cria igreja + usuários + membros + dados)
        $this->call(DemoChurchSeeder::class);
        $this->command->info('✅ Igreja de demonstração criada');
        $this->command->newLine();

        $this->command->info('🎉 Seed concluído com sucesso!');
        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📧 DADOS DE ACESSO:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🔐 Painel Admin: http://localhost:8000/admin');
        $this->command->info('');
        $this->command->info('👨‍💼 Pastor (Acesso Total):');
        $this->command->info('   Email: pastor@demo.com');
        $this->command->info('   Senha: password');
        $this->command->info('');
        $this->command->info('💰 Tesoureiro (Financeiro):');
        $this->command->info('   Email: tesoureiro@demo.com');
        $this->command->info('   Senha: password');
        $this->command->info('');
        $this->command->info('📝 Secretário (Membros/Eventos):');
        $this->command->info('   Email: secretario@demo.com');
        $this->command->info('   Senha: password');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
