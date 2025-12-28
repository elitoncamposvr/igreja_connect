<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔐 Criando roles e permissões do sistema...');
        $this->command->newLine();

        $roles = [
            // ==========================================
            // 1. PASTOR - Acesso Total (Super Admin)
            // ==========================================
            [
                'name' => 'Pastor',
                'slug' => 'pastor',
                'description' => 'Acesso total ao sistema. Pode gerenciar tudo.',
                'permissions' => [
                    // ===== GESTÃO DA IGREJA =====
                    'manage_church',              // Editar dados da igreja
                    'manage_church_settings',     // Configurações da igreja
                    'manage_congregations',       // Gerenciar congregações

                    // ===== USUÁRIOS E PERMISSÕES =====
                    'manage_users',               // Criar/editar usuários admin
                    'manage_roles',               // Atribuir roles
                    'view_users',                 // Ver lista de usuários

                    // ===== MEMBROS =====
                    'manage_members',             // Criar/editar/excluir membros
                    'view_members',               // Ver lista de membros
                    'view_member_details',        // Ver detalhes completos
                    'manage_families',            // Gerenciar famílias
                    'export_members',             // Exportar lista de membros

                    // ===== FINANCEIRO =====
                    'manage_finance',             // Acesso total ao financeiro
                    'manage_donations',           // Registrar/editar doações
                    'manage_transactions',        // Registrar/editar transações
                    'view_finance',               // Ver relatórios financeiros
                    'issue_receipts',             // Emitir recibos
                    'manage_categories',          // Gerenciar categorias
                    'manage_payment_methods',     // Gerenciar formas de pagamento
                    'export_finance',             // Exportar relatórios

                    // ===== EVENTOS =====
                    'manage_events',              // Criar/editar/excluir eventos
                    'view_events',                // Ver lista de eventos
                    'manage_attendance',          // Controlar presença
                    'export_attendance',          // Exportar lista de presença

                    // ===== COMUNICAÇÃO =====
                    'manage_communication',       // Gerenciar comunicação
                    'send_messages',              // Enviar mensagens (WhatsApp/Email)
                    'send_bulk_messages',         // Envio em massa
                    'manage_message_templates',   // Criar/editar templates
                    'view_message_history',       // Ver histórico de mensagens

                    // ===== RELATÓRIOS =====
                    'view_reports',               // Ver todos os relatórios
                    'view_financial_reports',     // Relatórios financeiros
                    'view_member_reports',        // Relatórios de membros
                    'view_attendance_reports',    // Relatórios de presença
                    'generate_assembly_report',   // Gerar relatório de assembleia
                    'export_reports',             // Exportar relatórios

                    // ===== CONFIGURAÇÕES =====
                    'manage_settings',            // Gerenciar configurações
                    'view_activity_log',          // Ver log de atividades
                    'manage_integrations',        // WhatsApp, PIX, etc
                ],
            ],

            // ==========================================
            // 2. TESOUREIRO - Gestão Financeira Completa
            // ==========================================
            [
                'name' => 'Tesoureiro',
                'slug' => 'tesoureiro',
                'description' => 'Gerencia finanças, emite relatórios e recibos. Pode visualizar membros mas não editar.',
                'permissions' => [
                    // ===== FINANCEIRO (COMPLETO) =====
                    'manage_finance',
                    'manage_donations',
                    'manage_transactions',
                    'view_finance',
                    'issue_receipts',
                    'manage_categories',
                    'manage_payment_methods',
                    'export_finance',

                    // ===== MEMBROS (SOMENTE LEITURA) =====
                    'view_members',               // Precisa ver membros para registrar doações
                    'view_member_details',        // Ver detalhes para associar doações

                    // ===== RELATÓRIOS =====
                    'view_reports',
                    'view_financial_reports',
                    'generate_assembly_report',   // Relatório financeiro para assembleia
                    'export_reports',
                ],
            ],

            // ==========================================
            // 3. SECRETÁRIO - Membros, Eventos e Comunicação
            // ==========================================
            [
                'name' => 'Secretário',
                'slug' => 'secretario',
                'description' => 'Gerencia membros, eventos e comunicação. Não tem acesso ao financeiro.',
                'permissions' => [
                    // ===== MEMBROS (COMPLETO) =====
                    'manage_members',
                    'view_members',
                    'view_member_details',
                    'manage_families',
                    'export_members',

                    // ===== EVENTOS (COMPLETO) =====
                    'manage_events',
                    'view_events',
                    'manage_attendance',
                    'export_attendance',

                    // ===== COMUNICAÇÃO (COMPLETO) =====
                    'manage_communication',
                    'send_messages',
                    'send_bulk_messages',
                    'manage_message_templates',
                    'view_message_history',

                    // ===== RELATÓRIOS (LIMITADO) =====
                    'view_reports',
                    'view_member_reports',
                    'view_attendance_reports',
                    'export_reports',
                ],
            ],

            // ==========================================
            // 4. LÍDER DE CÉLULA - Gestão do Grupo
            // ==========================================
            [
                'name' => 'Líder de Célula',
                'slug' => 'lider-celula',
                'description' => 'Gerencia sua célula/grupo pequeno. Pode ver membros do grupo e gerenciar eventos da célula.',
                'permissions' => [
                    // ===== MEMBROS (LIMITADO) =====
                    'view_members',               // Ver membros da sua célula
                    'view_member_details',

                    // ===== EVENTOS (LIMITADO) =====
                    'manage_events',              // Criar eventos da célula
                    'view_events',
                    'manage_attendance',          // Controlar presença na célula

                    // ===== COMUNICAÇÃO (LIMITADO) =====
                    'send_messages',              // Enviar mensagens para membros da célula
                    'view_message_history',

                    // ===== RELATÓRIOS (LIMITADO) =====
                    'view_attendance_reports',    // Ver presença da célula
                ],
            ],

            // ==========================================
            // 5. VISUALIZADOR - Somente Leitura
            // ==========================================
            [
                'name' => 'Visualizador',
                'slug' => 'visualizador',
                'description' => 'Apenas visualiza informações. Não pode criar, editar ou excluir nada. Útil para conselheiros.',
                'permissions' => [
                    // ===== SOMENTE VISUALIZAÇÃO =====
                    'view_members',
                    'view_member_details',
                    'view_events',
                    'view_reports',
                    'view_financial_reports',     // Pode ver relatórios financeiros
                    'view_member_reports',
                    'view_attendance_reports',

                    // NÃO PODE:
                    // - Criar, editar ou excluir nada
                    // - Enviar mensagens
                    // - Registrar doações/transações
                    // - Gerenciar eventos
                ],
            ],
        ];

        // Criar cada role no banco
        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'slug' => $roleData['slug'],
                'description' => $roleData['description'],
                'permissions' => $roleData['permissions'],
            ]);

            $this->command->info("✅ Role '{$role->name}' criada com " . count($roleData['permissions']) . " permissões");
        }

        $this->command->newLine();
        $this->command->info('🎉 ' . count($roles) . ' roles criadas com sucesso!');
        $this->command->newLine();

        // Mostrar resumo
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📋 RESUMO DAS ROLES:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        foreach ($roles as $role) {
            $this->command->info('');
            $this->command->info("👤 {$role['name']} ({$role['slug']})");
            $this->command->info("   {$role['description']}");
            $this->command->info("   Permissões: " . count($role['permissions']));
        }

        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
