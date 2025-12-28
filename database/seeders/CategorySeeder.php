<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Church;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Criar categorias financeiras padrão para uma igreja
     *
     * @param Church $church A igreja para qual criar as categorias
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

        $this->command->info("Criando categorias para: {$church->name}");

        // ========== CATEGORIAS DE ENTRADA (INCOME) ==========
        $incomeCategories = [
            [
                'name' => 'Dízimos',
                'description' => 'Dízimos dos membros (10% da renda)',
                'color' => '#10B981', // Green-500
            ],
            [
                'name' => 'Ofertas',
                'description' => 'Ofertas voluntárias',
                'color' => '#3B82F6', // Blue-500
            ],
            [
                'name' => 'Doações Especiais',
                'description' => 'Doações para projetos específicos',
                'color' => '#8B5CF6', // Violet-500
            ],
            [
                'name' => 'Eventos',
                'description' => 'Arrecadação em eventos (conferências, retiros)',
                'color' => '#F59E0B', // Amber-500
            ],
            [
                'name' => 'Venda de Materiais',
                'description' => 'Venda de livros, DVDs, camisetas, etc',
                'color' => '#6366F1', // Indigo-500
            ],
            [
                'name' => 'Missões',
                'description' => 'Doações específicas para missões',
                'color' => '#14B8A6', // Teal-500
            ],
            [
                'name' => 'Construção/Reforma',
                'description' => 'Doações para obras e reformas',
                'color' => '#F97316', // Orange-500
            ],
        ];

        foreach ($incomeCategories as $category) {
            Category::create([
                'church_id' => $church->id,
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => 'income',
                'color' => $category['color'],
                'description' => $category['description'],
                'is_default' => true,
            ]);
        }

        $this->command->info('✅ ' . count($incomeCategories) . ' categorias de ENTRADA criadas');

        // ========== CATEGORIAS DE SAÍDA (EXPENSE) ==========
        $expenseCategories = [
            [
                'name' => 'Aluguel',
                'description' => 'Aluguel do templo ou salas',
                'color' => '#EF4444', // Red-500
            ],
            [
                'name' => 'Água',
                'description' => 'Conta de água',
                'color' => '#06B6D4', // Cyan-500
            ],
            [
                'name' => 'Energia Elétrica',
                'description' => 'Conta de luz',
                'color' => '#F59E0B', // Amber-500
            ],
            [
                'name' => 'Internet',
                'description' => 'Internet e telefone',
                'color' => '#8B5CF6', // Violet-500
            ],
            [
                'name' => 'Salários',
                'description' => 'Salários de pastores e funcionários',
                'color' => '#EC4899', // Pink-500
            ],
            [
                'name' => 'Encargos Sociais',
                'description' => 'INSS, FGTS e outros encargos',
                'color' => '#DC2626', // Red-600
            ],
            [
                'name' => 'Manutenção',
                'description' => 'Reparos e manutenção do templo',
                'color' => '#F97316', // Orange-500
            ],
            [
                'name' => 'Material de Limpeza',
                'description' => 'Produtos de limpeza',
                'color' => '#14B8A6', // Teal-500
            ],
            [
                'name' => 'Material de Escritório',
                'description' => 'Papel, canetas, impressões',
                'color' => '#6366F1', // Indigo-500
            ],
            [
                'name' => 'Combustível',
                'description' => 'Gasolina para veículos da igreja',
                'color' => '#F59E0B', // Amber-500
            ],
            [
                'name' => 'Missões',
                'description' => 'Suporte a missionários e projetos missionários',
                'color' => '#10B981', // Green-500
            ],
            [
                'name' => 'Obra Social',
                'description' => 'Cestas básicas, ajuda a necessitados',
                'color' => '#84CC16', // Lime-500
            ],
            [
                'name' => 'Material Didático',
                'description' => 'Materiais para escola dominical e EBD',
                'color' => '#6366F1', // Indigo-500
            ],
            [
                'name' => 'Equipamentos',
                'description' => 'Som, projetor, computadores',
                'color' => '#8B5CF6', // Violet-500
            ],
            [
                'name' => 'Eventos',
                'description' => 'Gastos com eventos e conferências',
                'color' => '#F97316', // Orange-500
            ],
            [
                'name' => 'Impostos e Taxas',
                'description' => 'IPTU, taxas bancárias, etc',
                'color' => '#DC2626', // Red-600
            ],
            [
                'name' => 'Marketing',
                'description' => 'Divulgação, redes sociais, banners',
                'color' => '#EC4899', // Pink-500
            ],
        ];

        foreach ($expenseCategories as $category) {
            Category::create([
                'church_id' => $church->id,
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => 'expense',
                'color' => $category['color'],
                'description' => $category['description'],
                'is_default' => true,
            ]);
        }

        $this->command->info('✅ ' . count($expenseCategories) . ' categorias de SAÍDA criadas');
        $this->command->info('🎉 Total: ' . (count($incomeCategories) + count($expenseCategories)) . ' categorias criadas com sucesso!');
    }
}
