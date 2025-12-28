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
        // 1. Criar igreja
        $this->createChurch();

        // 2. Criar configurações
        $this->createChurchSettings();

        // 3. Criar categorias financeiras
        $this->createCategories();

        // 4. Criar métodos de pagamento
        $this->createPaymentMethods();

        // 5. Criar usuários administrativos
        $this->createUsers();

        // 6. Criar membros
        $this->createMembers();

        // 7. Criar famílias
        $this->createFamilies();

        // 8. Criar doações
        $this->createDonations();

        // 9. Criar transações
        $this->createTransactions();

        // 10. Criar eventos
        $this->createEvents();

        // 11. Criar templates de mensagens
        $this->createMessageTemplates();
    }

    private function createChurch(): void
    {
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
    }

    private function createChurchSettings(): void
    {
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
    }

    private function createCategories(): void
    {
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
    }

    private function createPaymentMethods(): void
    {
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
    }

    private function createUsers(): void
    {
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
    }

    private function createMembers(): void
    {
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
                'number' => rand(100, 999),
                'neighborhood' => ['Centro', 'Catolé', 'Bodocongó', 'Prata'][rand(0, 3)],
                'city' => 'Campina Grande',
                'state' => 'PB',
                'zip_code' => '58400-' . str_pad($index * 10, 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
            ]);
        }
    }

    private function createFamilies(): void
    {
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
    }

    private function createDonations(): void
    {
        $titheCategory = Category::where('church_id', $this->church->id)
            ->where('slug', 'dizimos')
            ->first();

        $offeringCategory = Category::where('church_id', $this->church->id)
            ->where('slug', 'ofertas')
            ->first();

        // Criar doações dos últimos 6 meses
        for ($month = 0; $month < 6; $month++) {
            $date = now()->subMonths($month);

            // Cada membro doa 1-2 vezes por mês
            foreach (array_slice($this->members, 0, 6) as $member) {
                // Dízimo
                Donation::create([
                    'church_id' => $this->church->id,
                    'member_id' => $member->id,
                    'payment_method_id' => $this->paymentMethods[rand(0, 3)]->id,
                    'type' => 'tithe',
                    'amount' => rand(100, 500),
                    'donated_at' => $date->copy()->addDays(rand(1, 15)),
                    'payment_status' => 'confirmed',
                    'receipt_issued' => rand(0, 1) === 1,
                ]);

                // Oferta (50% de chance)
                if (rand(0, 1) === 1) {
                    Donation::create([
                        'church_id' => $this->church->id,
                        'member_id' => $member->id,
                        'payment_method_id' => $this->paymentMethods[rand(0, 3)]->id,
                        'type' => 'offering',
                        'amount' => rand(20, 100),
                        'donated_at' => $date->copy()->addDays(rand(16, 28)),
                        'payment_status' => 'confirmed',
                        'receipt_issued' => false,
                    ]);
                }
            }
        }
    }

    private function createTransactions(): void
    {
        $expenseCategories = Category::where('church_id', $this->church->id)
            ->where('type', 'expense')
            ->get();

        $user = User::where('church_id', $this->church->id)->first();

        // Despesas mensais dos últimos 6 meses
        for ($month = 0; $month < 6; $month++) {
            $date = now()->subMonths($month);

            // Aluguel
            Transaction::create([
                'church_id' => $this->church->id,
                'category_id' => $expenseCategories->where('slug', 'aluguel')->first()->id,
                'payment_method_id' => $this->paymentMethods[4]->id, // Transferência
                'user_id' => $user->id,
                'type' => 'expense',
                'amount' => 2000.00,
                'description' => 'Aluguel do templo - ' . $date->format('m/Y'),
                'transaction_date' => $date->copy()->day(5),
                'status' => 'completed',
            ]);

            // Água
            Transaction::create([
                'church_id' => $this->church->id,
                'category_id' => $expenseCategories->where('slug', 'agua')->first()->id,
                'payment_method_id' => $this->paymentMethods[4]->id,
                'user_id' => $user->id,
                'type' => 'expense',
                'amount' => rand(80, 150),
                'description' => 'Conta de água - ' . $date->format('m/Y'),
                'transaction_date' => $date->copy()->day(10),
                'status' => 'completed',
            ]);

            // Energia
            Transaction::create([
                'church_id' => $this->church->id,
                'category_id' => $expenseCategories->where('slug', 'energia-eletrica')->first()->id,
                'payment_method_id' => $this->paymentMethods[4]->id,
                'user_id' => $user->id,
                'type' => 'expense',
                'amount' => rand(300, 500),
                'description' => 'Conta de luz - ' . $date->format('m/Y'),
                'transaction_date' => $date->copy()->day(15),
                'status' => 'completed',
            ]);

            // Internet
            Transaction::create([
                'church_id' => $this->church->id,
                'category_id' => $expenseCategories->where('slug', 'internet')->first()->id,
                'payment_method_id' => $this->paymentMethods[4]->id,
                'user_id' => $user->id,
                'type' => 'expense',
                'amount' => 99.90,
                'description' => 'Internet - ' . $date->format('m/Y'),
                'transaction_date' => $date->copy()->day(20),
                'status' => 'completed',
            ]);
        }
    }

    private function createEvents(): void
    {
        $user = User::where('church_id', $this->church->id)->first();

        // Cultos semanais (domingos às 19h)
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

            // Adicionar presenças para eventos passados
            if ($date->isPast()) {
                $attendees = array_slice($this->members, 0, rand(50, 70));
                foreach ($attendees as $member) {
                    $event->attendances()->create([
                        'member_id' => $member->id,
                        'checked_in_at' => $date->copy()->addMinutes(rand(-10, 15)),
                        'status' => 'present',
                    ]);
                }
            }
        }

        // Células semanais (quartas às 20h)
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
    }

    private function createMessageTemplates(): void
    {
        $templates = [
            [
                'name' => 'Boas-vindas Novo Membro',
                'slug' => 'boas-vindas',
                'type' => 'welcome',
                'content' => 'Olá {{name}}! 🙏 Seja muito bem-vindo(a) à {{church_name}}! Estamos muito felizes em ter você conosco. Qualquer dúvida, estamos à disposição!',
            ],
            [
                'name' => 'Aniversário',
                'slug' => 'aniversario',
                'type' => 'birthday',
                'content' => 'Feliz aniversário, {{name}}! 🎉🎂 Que Deus abençoe sua vida ricamente neste novo ano! Toda a {{church_name}} celebra com você!',
            ],
            [
                'name' => 'Agradecimento Doação',
                'slug' => 'agradecimento-doacao',
                'type' => 'donation_thanks',
                'content' => 'Olá {{name}}, obrigado pela sua doação de R$ {{amount}}! Sua generosidade nos ajuda a continuar o trabalho de Deus. Que Ele multiplique em sua vida! 🙏',
            ],
            [
                'name' => 'Lembrete de Evento',
                'slug' => 'lembrete-evento',
                'type' => 'event_reminder',
                'content' => 'Olá {{name}}! Lembramos que temos {{event_name}} amanhã às {{event_time}}. Contamos com sua presença! Local: {{event_location}}',
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
    }
}
