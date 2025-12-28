<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        $roles = [
            [
                'name' => 'Pastor',
                'slug' => 'pastor',
                'description' => 'Acesso total ao sistema',
                'permissions' => [
                    'manage_church',
                    'manage_users',
                    'manage_members',
                    'manage_finance',
                    'manage_events',
                    'manage_communication',
                    'view_reports',
                    'manage_settings',
                ],
            ],
            [
                'name' => 'Tesoureiro',
                'slug' => 'tesoureiro',
                'description' => 'Gerencia finanças e emite relatórios',
                'permissions' => [
                    'manage_finance',
                    'manage_donations',
                    'manage_transactions',
                    'issue_receipts',
                    'view_reports',
                    'view_members',
                ],
            ],
            [
                'name' => 'Secretário',
                'slug' => 'secretario',
                'description' => 'Gerencia membros e eventos',
                'permissions' => [
                    'manage_members',
                    'manage_families',
                    'manage_events',
                    'manage_attendance',
                    'send_messages',
                    'view_reports',
                ],
            ],
            [
                'name' => 'Líder de Célula',
                'slug' => 'lider-celula',
                'description' => 'Gerencia sua célula/grupo',
                'permissions' => [
                    'view_members',
                    'manage_events',
                    'manage_attendance',
                    'send_messages',
                ],
            ],
            [
                'name' => 'Visualizador',
                'slug' => 'visualizador',
                'description' => 'Apenas visualiza informações',
                'permissions' => [
                    'view_members',
                    'view_events',
                    'view_reports',
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }
    }
}
