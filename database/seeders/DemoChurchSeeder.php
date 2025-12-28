<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\ChurchSettings;
use App\Models\User;
use App\Models\Member;
use App\Models\Family;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\MessageTemplate;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoChurchSeeder extends Seeder
{
    private Church $church;
    private array $members = [];
    private array $categories = [];
    private array $paymentMethods = [];

    public function run(): void
    {
        $this->command->info('🏛️  Criando igreja de demonstração...');
        $this->command->newLine();

        // 1. Criar igreja
        $this->createChurch();

        // 2. Criar configurações
        $this->createChurchSettings();

        // 3. Criar categorias financeiras (INLINE - não chamar seeder separado)
        $this->createCategories();

        // 4. Criar métodos de pagamento (INLINE)
        $this->createPaymentMethods();

        // 5. Criar templates de mensagens (INLINE)
        $this->createMessageTemplates();

        // 6. Criar usuários administrativos
        $this->createUsers();

        // 7. Criar membros
        $this->createMembers();

        // 8. Criar famílias
        $this->createFamilies();

        // 9. Criar doações
        $this->createDonations();

        // 10. Criar transações
        $this->createTransactions();

        // 11. Criar eventos
        $this->createEvents();

        $this->command->newLine();
        $this->command->info('✅ Igreja de demonstração criada com sucesso!');
    }

    private function createChurch(): void
    {
        $this->command->info('📍 Criando igreja...');

        $this->church = Church::create([
            'name' => 'Igreja Batista Central',
            'slug' => 'igreja-batista-central',
            'email' => 'contato@igrejacentral.com.br',
            'phone' => '(83) 3322-1234',
            'cnpj' => '12.345.678/0001-90',

            // Endereço
            'street' => 'Rua das Flores',
            'number' => '123',
            'neighborhood' => 'Centro',
            'city' => 'Campina Grande',
            'state' => 'PB',
            'zip_code' => '58400-000',

            // Configurações
            'status' => 'active',
            'denomination' => 'Batista',
            'founded_at' => now()->subYears(25),

            // Plano
            'plan' => 'media',
            'subscription_started_at' => now()->subMonths(6),
            'subscription_ends_at' => now()->addMonths(6),
            'is_trial' => false,
        ]);

        $this->command->info("   ✓ Igreja '{$this->church->name}' criada");
    }

    private function createChurchSettings(): void
    {
        $this->command->info('⚙️  Criando configurações...');

        ChurchSettings::create([
            'church_id' => $this->church->id,

            // Financeiro
            'allow_pix' => true,
            'pix_key' => 'contato@igrejacentral.com.br',
            'allow_credit_card' => true,
            'allow_recurring_donations' => true,

            // Comunicação
            'enable_whatsapp' => true,
            'enable_email' => true,
            'enable_sms' => false,

            // Relatórios
            'public_financial_reports' => true,
            'show_donor_names' => false,

            // Membros
            'require_member_photo' => false,
            'require_cpf' => false,

            // Eventos
            'enable_attendance_control' => true,
            'require_qr_code_checkin' => false,

            'timezone' => 'America/Fortaleza',
        ]);

        $this->command->info('   ✓ Configurações criadas');
    }

    private function createCategories(): void
    {
        $this->command->info('💰 Criando categorias financeiras...');

        $incomeCategories = [
            ['name' => 'Dízimos', 'color' => '#10B981'],
            ['name' => 'Ofertas', 'color' => '#3B82F6'],
            ['name' => 'Doações Especiais', 'color' => '#8B5CF6'],
            ['name' => 'Eventos', 'color' => '#F59E0B'],
            ['name' => 'Venda de Materiais', 'color' => '#6366F1'],
        ];

        $expenseCategories = [
            ['name' => 'Aluguel', 'color' => '#EF4444'],
            ['name' => 'Água', 'color' => '#06B6D4'],
            ['name' => 'Energia Elétrica', 'color' => '#F59E0B'],
            ['name' => 'Internet', 'color' => '#8B5CF6'],
            ['name' => 'Salários', 'color' => '#EC4899'],
            ['name' => 'Manutenção', 'color' => '#F97316'],
            ['name' => 'Material de Limpeza', 'color' => '#14B8A6'],
            ['name' => 'Missões', 'color' => '#10B981'],
            ['name' => 'Obra Social', 'color' => '#84CC16'],
            ['name' => 'Material Didático', 'color' => '#6366F1'],
        ];

        foreach ($incomeCategories as $category) {
            $this->categories[] = Category::create([
                'church_id' => $this->church->id,
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => 'income',
                'color' => $category['color'],
                'is_default' => true,
            ]);
        }

        foreach ($expenseCategories as $category) {
            $this->categories[] = Category::create([
                'church_id' => $this->church->id,
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => 'expense',
                'color' => $category['color'],
                'is_default' => true,
            ]);
        }

        $this->command->info('   ✓ ' . count($this->categories) . ' categorias criadas');
    }

    private function createPaymentMethods(): void
    {
        $this->command->info('💳 Criando métodos de pagamento...');

        $methods = [
            ['name' => 'Dinheiro', 'type' => 'cash'],
            ['name' => 'PIX', 'type' => 'pix'],
            ['name' => 'Cartão de Crédito', 'type' => 'credit_card'],
            ['name' => 'Cartão de Débito', 'type' => 'debit_card'],
            ['name' => 'Transferência Bancária', 'type' => 'bank_transfer'],
            ['name' => 'Cheque', 'type' => 'check'],
        ];

        foreach ($methods as $method) {
            $this->paymentMethods[] = PaymentMethod::create([
                'church_id' => $this->church->id,
                'name' => $method['name'],
                'slug' => Str::slug($method['name']),
                'type' => $method['type'],
                'is_active' => true,
            ]);
        }

        $this->command->info('   ✓ ' . count($this->paymentMethods) . ' métodos criados');
    }

    private function createMessageTemplates(): void
    {
        $this->command->info('📱 Criando templates de mensagens...');

        $templates = [
            [
                'name' => 'Boas-vindas Novo Membro',
                'slug' => 'boas-vindas',
                'type' => 'welcome',
                'content' => 'Olá {{name}}! 🙏 Seja muito bem-vindo(a) à {{church_name}}!',
            ],
            [
                'name' => 'Aniversário',
                'slug' => 'aniversario',
                'type' => 'birthday',
                'content' => 'Feliz aniversário, {{name}}! 🎉🎂',
            ],
            [
                'name' => 'Agradecimento Doação',
                'slug' => 'agradecimento-doacao',
                'type' => 'donation_thanks',
                'content' => 'Obrigado pela sua doação de R$ {{amount}}! 🙏',
            ],
            [
                'name' => 'Lembrete de Evento',
                'slug' => 'lembrete-evento',
                'type' => 'event_reminder',
                'content' => 'Lembrete: {{event_name}} amanhã às {{event_time}}!',
            ],
        ];

        foreach ($templates as $template) {
            MessageTemplate::create([
                'church_id' => $this->church->id,
                'name' => $template['name'],
                'slug' => $template['slug'],
                'type' => $template['type'],
                'content' => $template['content'],
                'is_active' => true,
            ]);
        }

        $this->command->info('   ✓ ' . count($templates) . ' templates criados');
    }

    private function createUsers(): void
    {
        $this->command->info('👥 Criando usuários administrativos...');

        // Pastor (admin total)
        $pastor = User::create([
            'church_id' => $this->church->id,
            'name' => 'Pastor João Silva',
            'email' => 'pastor@demo.com',
            'password' => Hash::make('password'),
            'phone' => '(83) 99999-1111',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $pastor->roles()->attach(Role::where('slug', 'pastor')->first()->id);

        // Tesoureiro
        $treasurer = User::create([
            'church_id' => $this->church->id,
            'name' => 'Maria Santos',
            'email' => 'tesoureiro@demo.com',
            'password' => Hash::make('password'),
            'phone' => '(83) 99999-2222',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $treasurer->roles()->attach(Role::where('slug', 'tesoureiro')->first()->id);

        // Secretário
        $secretary = User::create([
            'church_id' => $this->church->id,
            'name' => 'Carlos Oliveira',
            'email' => 'secretario@demo.com',
            'password' => Hash::make('password'),
            'phone' => '(83) 99999-3333',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $secretary->roles()->attach(Role::where('slug', 'secretario')->first()->id);

        $this->command->info('   ✓ 3 usuários criados');
    }

    private function createMembers(): void
    {
        $this->command->info('👨‍👩‍👧‍👦 Criando membros...');

        $memberNames = [
            ['name' => 'Pedro Alves', 'email' => 'pedro@email.com', 'status' => 'member'],
            ['name' => 'Ana Costa', 'email' => 'ana@email.com', 'status' => 'member'],
            ['name' => 'José Pereira', 'email' => 'jose@email.com', 'status' => 'member'],
            ['name' => 'Mariana Lima', 'email' => 'mariana@email.com', 'status' => 'member'],
            ['name' => 'Ricardo Santos', 'email' => 'ricardo@email.com', 'status' => 'member'],
            ['name' => 'Juliana Ferreira', 'email' => 'juliana@email.com', 'status' => 'member'],
            ['name' => 'Fernando Souza', 'email' => 'fernando@email.com', 'status' => 'congregant'],
            ['name' => 'Camila Rocha', 'email' => 'camila@email.com', 'status' => 'congregant'],
            ['name' => 'Lucas Martins', 'email' => 'lucas@email.com', 'status' => 'visitor'],
            ['name' => 'Beatriz Silva', 'email' => 'beatriz@email.com', 'status' => 'visitor'],
        ];

        foreach ($memberNames as $index => $memberData) {
            $this->members[] = Member::create([
                'church_id' => $this->church->id,
                'congregation_id' => null, // ← SEMPRE NULL no demo
                'name' => $memberData['name'],
                'email' => $memberData['email'],
                'phone' => sprintf('(83) 9%04d-%04d', 8000 + $index, 1000 + $index),
                'cpf' => sprintf('%03d.%03d.%03d-%02d',
                    rand(100, 999),
                    rand(100, 999),
                    rand(100, 999),
                    rand(10, 99)
                ),
                'birth_date' => now()->subYears(rand(20, 60))->subDays(rand(0, 364)),
                'gender' => $index % 2 === 0 ? 'male' : 'female',
                'status' => $memberData['status'],
                'baptism_date' => now()->subYears(rand(1, 10)),
                'conversion_date' => now()->subYears(rand(1, 15)),
                'membership_date' => now()->subYears(rand(1, 8)),
                'marital_status' => ['single', 'married', 'married', 'married'][rand(0, 3)],
                'street' => 'Rua ' . chr(65 + $index),
                'number' => (string) rand(100, 999),
                'neighborhood' => ['Centro', 'Catolé', 'Bodocongó', 'Prata'][rand(0, 3)],
                'city' => 'Campina Grande',
                'state' => 'PB',
                'zip_code' => '58400-' . str_pad((string)($index * 10), 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
            ]);
        }

        $this->command->info('   ✓ ' . count($this->members) . ' membros criados');
    }

    private function createFamilies(): void
    {
        $this->command->info('👨‍👩‍👧 Criando famílias...');

        // Família 1: Pedro e Ana
        $family1 = Family::create([
            'church_id' => $this->church->id,
            'name' => 'Família Alves',
            'head_member_id' => $this->members[0]->id,
        ]);
        $family1->members()->attach($this->members[0]->id, ['relationship' => 'head']);
        $family1->members()->attach($this->members[1]->id, ['relationship' => 'spouse']);

        // Família 2: José e Mariana
        $family2 = Family::create([
            'church_id' => $this->church->id,
            'name' => 'Família Pereira',
            'head_member_id' => $this->members[2]->id,
        ]);
        $family2->members()->attach($this->members[2]->id, ['relationship' => 'head']);
        $family2->members()->attach($this->members[3]->id, ['relationship' => 'spouse']);

        // Família 3: Ricardo e Juliana
        $family3 = Family::create([
            'church_id' => $this->church->id,
            'name' => 'Família Santos',
            'head_member_id' => $this->members[4]->id,
        ]);
        $family3->members()->attach($this->members[4]->id, ['relationship' => 'head']);
        $family3->members()->attach($this->members[5]->id, ['relationship' => 'spouse']);

        $this->command->info('   ✓ 3 famílias criadas');
    }

    private function createDonations(): void
    {
        $this->command->info('💵 Criando doações...');

        if (empty($this->members) || empty($this->paymentMethods)) {
            $this->command->warn('   ⚠ Doações não criadas: membros ou métodos de pagamento ausentes.');
            return;
        }

        $count = 0;

        // Criar doações dos últimos 6 meses
        for ($month = 0; $month < 6; $month++) {
            $date = now()->subMonths($month);

            // Cada membro doa 1-2 vezes por mês
            foreach (array_slice($this->members, 0, 6) as $member) {
                // Escolher método aleatório seguro
                $randomMethod = $this->paymentMethods[array_rand($this->paymentMethods)];

                // Dízimo
                Donation::create([
                    'church_id' => $this->church->id,
                    'member_id' => $member->id,
                    'payment_method_id' => $randomMethod->id,
                    'type' => 'tithe',
                    'amount' => rand(100, 500),
                    'donated_at' => $date->copy()->addDays(rand(1, 15)),
                    'payment_status' => 'confirmed',
                    'receipt_issued' => (bool)rand(0, 1),
                ]);
                $count++;

                // Oferta (50% de chance)
                if (rand(0, 1) === 1) {
                    $randomMethod2 = $this->paymentMethods[array_rand($this->paymentMethods)];

                    Donation::create([
                        'church_id' => $this->church->id,
                        'member_id' => $member->id,
                        'payment_method_id' => $randomMethod2->id,
                        'type' => 'offering',
                        'amount' => rand(20, 100),
                        'donated_at' => $date->copy()->addDays(rand(16, 28)),
                        'payment_status' => 'confirmed',
                        'receipt_issued' => false,
                    ]);
                    $count++;
                }
            }
        }

        $this->command->info("   ✓ {$count} doações criadas");
    }

    private function createTransactions(): void
    {
        $this->command->info('💸 Criando transações...');

        if (empty($this->paymentMethods)) {
            $this->command->warn('   ⚠ Transações não criadas: métodos de pagamento ausentes.');
            return;
        }

        $expenseCategories = collect($this->categories)->where('type', 'expense');
        $user = User::where('church_id', $this->church->id)->first();

        // Método de pagamento padrão (primeiro do array)
        $defaultPaymentMethod = $this->paymentMethods[0];

        $count = 0;

        // Despesas mensais dos últimos 6 meses
        for ($month = 0; $month < 6; $month++) {
            $date = now()->subMonths($month);

            // Aluguel
            $aluguel = $expenseCategories->firstWhere('slug', 'aluguel');
            if ($aluguel) {
                Transaction::create([
                    'church_id' => $this->church->id,
                    'category_id' => $aluguel->id,
                    'payment_method_id' => $defaultPaymentMethod->id,
                    'user_id' => $user->id,
                    'type' => 'expense',
                    'amount' => 2000.00,
                    'description' => 'Aluguel do templo - ' . $date->format('m/Y'),
                    'transaction_date' => $date->copy()->day(5),
                    'status' => 'completed',
                ]);
                $count++;
            }

            // Água
            $agua = $expenseCategories->firstWhere('slug', 'agua');
            if ($agua) {
                Transaction::create([
                    'church_id' => $this->church->id,
                    'category_id' => $agua->id,
                    'payment_method_id' => $defaultPaymentMethod->id,
                    'user_id' => $user->id,
                    'type' => 'expense',
                    'amount' => rand(80, 150),
                    'description' => 'Conta de água - ' . $date->format('m/Y'),
                    'transaction_date' => $date->copy()->day(10),
                    'status' => 'completed',
                ]);
                $count++;
            }

            // Energia
            $energia = $expenseCategories->firstWhere('slug', 'energia-eletrica');
            if ($energia) {
                Transaction::create([
                    'church_id' => $this->church->id,
                    'category_id' => $energia->id,
                    'payment_method_id' => $defaultPaymentMethod->id,
                    'user_id' => $user->id,
                    'type' => 'expense',
                    'amount' => rand(300, 500),
                    'description' => 'Conta de luz - ' . $date->format('m/Y'),
                    'transaction_date' => $date->copy()->day(15),
                    'status' => 'completed',
                ]);
                $count++;
            }

            // Internet
            $internet = $expenseCategories->firstWhere('slug', 'internet');
            if ($internet) {
                Transaction::create([
                    'church_id' => $this->church->id,
                    'category_id' => $internet->id,
                    'payment_method_id' => $defaultPaymentMethod->id,
                    'user_id' => $user->id,
                    'type' => 'expense',
                    'amount' => 99.90,
                    'description' => 'Internet - ' . $date->format('m/Y'),
                    'transaction_date' => $date->copy()->day(20),
                    'status' => 'completed',
                ]);
                $count++;
            }
        }

        $this->command->info("   ✓ {$count} transações criadas");
    }

    private function createEvents(): void
    {
        $this->command->info('📅 Criando eventos...');

        $count = 0;

        // Cultos semanais (domingos às 19h) - últimas 8 semanas
        for ($week = 0; $week < 8; $week++) {
            $date = now()->subWeeks($week)->startOfWeek()->addDays(6)->setTime(19, 0);

            $event = Event::create([
                'church_id' => $this->church->id,
                'title' => 'Culto de Celebração',
                'description' => 'Culto dominical de celebração e adoração',
                'type' => 'worship',
                'starts_at' => $date,
                'ends_at' => $date->copy()->addHours(2),
                'is_recurring' => true,
                'recurring_frequency' => 'weekly',
                'location' => 'Templo Central',
                'status' => $date->isPast() ? 'completed' : 'scheduled',
                'track_attendance' => true,
                'expected_attendees' => 80,
            ]);
            $count++;

            // Adicionar presenças para eventos passados
            if ($date->isPast()) {
                $attendees = array_slice($this->members, 0, rand(50, 70));
                foreach ($attendees as $member) {
                    EventAttendance::create([
                        'event_id' => $event->id,
                        'member_id' => $member->id,
                        'checked_in_at' => $date->copy()->addMinutes(rand(-10, 15)),
                        'status' => 'present',
                    ]);
                }
            }
        }

        // Células semanais (quartas às 20h) - últimas 4 semanas
        for ($week = 0; $week < 4; $week++) {
            $date = now()->subWeeks($week)->startOfWeek()->addDays(2)->setTime(20, 0);

            Event::create([
                'church_id' => $this->church->id,
                'title' => 'Célula no Lar',
                'description' => 'Reunião de célula para comunhão e estudo bíblico',
                'type' => 'cell',
                'starts_at' => $date,
                'ends_at' => $date->copy()->addHours(1.5),
                'is_recurring' => true,
                'recurring_frequency' => 'weekly',
                'location' => 'Casa do Líder',
                'status' => $date->isPast() ? 'completed' : 'scheduled',
                'track_attendance' => true,
                'expected_attendees' => 15,
            ]);
            $count++;
        }

        // Evento especial futuro
        Event::create([
            'church_id' => $this->church->id,
            'title' => 'Conferência Anual de Missões',
            'description' => 'Conferência especial com pregadores missionários',
            'type' => 'conference',
            'starts_at' => now()->addMonths(2)->setTime(19, 0),
            'ends_at' => now()->addMonths(2)->addDays(3)->setTime(22, 0),
            'is_recurring' => false,
            'location' => 'Templo Central',
            'status' => 'scheduled',
            'track_attendance' => true,
            'expected_attendees' => 200,
        ]);
        $count++;

        $this->command->info("   ✓ {$count} eventos criados");
    }
}
