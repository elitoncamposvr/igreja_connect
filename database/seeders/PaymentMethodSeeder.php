<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Church;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Criar métodos de pagamento padrão para uma igreja
     *
     * @param Church $church A igreja para qual criar os métodos
     */
    public function run(Church $church = null): void
    {
        // Se não passar igreja, pegar a primeira disponível
        if (!$church) {
            $church = Church::first();

            if (!$church) {
                $this->command->error('Nenhuma igreja encontrada! Execute DemoChurchSeeder primeiro.');
                return;
            }
        }

        $this->command->info("Criando métodos de pagamento para: {$church->name}");

        $paymentMethods = [
            [
                'name' => 'Dinheiro',
                'type' => 'cash',
                'is_active' => true,
            ],
            [
                'name' => 'PIX',
                'type' => 'pix',
                'is_active' => true,
            ],
            [
                'name' => 'Cartão de Crédito',
                'type' => 'credit_card',
                'is_active' => true,
            ],
            [
                'name' => 'Cartão de Débito',
                'type' => 'debit_card',
                'is_active' => true,
            ],
            [
                'name' => 'Transferência Bancária',
                'type' => 'bank_transfer',
                'is_active' => true,
            ],
            [
                'name' => 'Cheque',
                'type' => 'check',
                'is_active' => false, // Desativado por padrão (menos comum hoje)
            ],
            [
                'name' => 'Boleto',
                'type' => 'other',
                'is_active' => true,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create([
                'church_id' => $church->id,
                'name' => $method['name'],
                'slug' => Str::slug($method['name']),
                'type' => $method['type'],
                'is_active' => $method['is_active'],
            ]);
        }

        $this->command->info('✅ ' . count($paymentMethods) . ' métodos de pagamento criados');
        $this->command->info('💳 Métodos ativos: ' . collect($paymentMethods)->where('is_active', true)->count());
    }
}
