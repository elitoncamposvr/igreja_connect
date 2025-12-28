<?php

namespace Database\Seeders;

use App\Models\MessageTemplate;
use App\Models\Church;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Criar templates de mensagens padrão para uma igreja
     *
     * @param Church $church A igreja para qual criar os templates
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

        $this->command->info("Criando templates de mensagens para: {$church->name}");

        $templates = [
            [
                'name' => 'Boas-vindas Novo Membro',
                'slug' => 'boas-vindas',
                'type' => 'welcome',
                'content' => "Olá {{name}}! 🙏\n\nSeja muito bem-vindo(a) à {{church_name}}!\n\nEstamos muito felizes em ter você conosco na família de Deus. Que este seja o início de uma jornada maravilhosa de fé e comunhão.\n\nSe precisar de algo, estamos à disposição!\n\nQue Deus abençoe sua vida ricamente! 🙌",
                'is_active' => true,
            ],
            [
                'name' => 'Aniversário',
                'slug' => 'aniversario',
                'type' => 'birthday',
                'content' => "🎉🎂 Feliz Aniversário, {{name}}! 🎂🎉\n\nNeste dia especial, queremos celebrar com você!\n\nQue Deus abençoe sua vida com muita saúde, paz e alegria. Que este novo ciclo seja repleto de realizações e bênçãos.\n\nToda a família da {{church_name}} deseja muitas felicidades!\n\nCom carinho,\nSua igreja 💙",
                'is_active' => true,
            ],
            [
                'name' => 'Agradecimento por Doação',
                'slug' => 'agradecimento-doacao',
                'type' => 'donation_thanks',
                'content' => "Olá {{name}}! 🙏\n\nMuito obrigado pela sua doação de R$ {{amount}}!\n\nSua generosidade e fidelidade nos ajudam a continuar o trabalho de Deus e a alcançar mais vidas com o evangelho.\n\nQue o Senhor multiplique em sua vida tudo que você tem semeado no Reino!\n\n\"Cada um contribua segundo tiver proposto no coração, não com tristeza ou por necessidade; porque Deus ama a quem dá com alegria.\" (2 Coríntios 9:7)\n\nDeus abençoe! 💚",
                'is_active' => true,
            ],
            [
                'name' => 'Lembrete de Evento',
                'slug' => 'lembrete-evento',
                'type' => 'event_reminder',
                'content' => "Olá {{name}}! 📅\n\nLembramos que amanhã teremos:\n\n📍 {{event_name}}\n🕐 Horário: {{event_time}}\n📌 Local: {{event_location}}\n\nContamos com sua presença!\n\nSe tiver alguma dúvida, entre em contato conosco.\n\nQue Deus abençoe! 🙏",
                'is_active' => true,
            ],
            [
                'name' => 'Confirmação de Presença',
                'slug' => 'confirmacao-presenca',
                'type' => 'event_reminder',
                'content' => "Olá {{name}}! ✅\n\nSua presença foi confirmada para:\n\n📍 {{event_name}}\n🕐 {{event_time}}\n📌 {{event_location}}\n\nNos vemos lá!\n\nCaso não possa comparecer, por favor nos avise.\n\nDeus abençoe! 🙏",
                'is_active' => true,
            ],
            [
                'name' => 'Aviso Geral',
                'slug' => 'aviso-geral',
                'type' => 'custom',
                'content' => "Olá {{name}}! 📢\n\n{{message}}\n\nPara mais informações, entre em contato com a secretaria da igreja.\n\nDeus abençoe!\n{{church_name}}",
                'is_active' => true,
            ],
            [
                'name' => 'Convite para Culto',
                'slug' => 'convite-culto',
                'type' => 'custom',
                'content' => "Olá {{name}}! ⛪\n\nConvidamos você para nosso culto:\n\n📍 {{church_name}}\n🕐 Domingo às 19h\n📌 {{church_address}}\n\nVenha louvar e adorar ao Senhor conosco!\n\nSerá uma bênção ter você presente! 🙏",
                'is_active' => true,
            ],
            [
                'name' => 'Pedido de Oração',
                'slug' => 'pedido-oracao',
                'type' => 'custom',
                'content' => "Olá {{name}}! 🙏\n\nRecebemos seu pedido de oração e queremos que saiba que estamos intercedendo por você diante do Senhor.\n\n\"A oração feita por um justo pode muito em seus efeitos.\" (Tiago 5:16)\n\nDeus está no controle de todas as coisas!\n\nConte conosco sempre.\n{{church_name}} 💙",
                'is_active' => true,
            ],
            [
                'name' => 'Reunião de Célula',
                'slug' => 'reuniao-celula',
                'type' => 'custom',
                'content' => "Olá {{name}}! 🏠\n\nNão esqueça da nossa reunião de célula:\n\n🕐 {{date}} às {{time}}\n📌 {{address}}\n\nVamos compartilhar a Palavra, orar uns pelos outros e ter comunhão!\n\nTraga sua Bíblia e um coração aberto.\n\nTe esperamos! 🙏",
                'is_active' => true,
            ],
            [
                'name' => 'Recibo de Doação',
                'slug' => 'recibo-doacao',
                'type' => 'custom',
                'content' => "Olá {{name}}! 📄\n\nSeu recibo de doação para declaração de Imposto de Renda está disponível!\n\n📊 Ano: {{year}}\n💰 Total doado: R$ {{total}}\n\nAcesse o sistema para fazer o download:\n{{portal_link}}\n\nEm caso de dúvidas, entre em contato.\n\nDeus abençoe! 🙏",
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            MessageTemplate::create([
                'church_id' => $church->id,
                'name' => $template['name'],
                'slug' => $template['slug'],
                'type' => $template['type'],
                'content' => $template['content'],
                'is_active' => $template['is_active'],
            ]);
        }

        $this->command->info('✅ ' . count($templates) . ' templates de mensagens criados');
        $this->command->newLine();
        $this->command->info('📝 Variáveis disponíveis:');
        $this->command->info('   - {{name}} = Nome do membro');
        $this->command->info('   - {{church_name}} = Nome da igreja');
        $this->command->info('   - {{amount}} = Valor da doação');
        $this->command->info('   - {{event_name}} = Nome do evento');
        $this->command->info('   - {{event_time}} = Horário do evento');
        $this->command->info('   - {{event_location}} = Local do evento');
        $this->command->info('   - {{message}} = Mensagem customizada');
    }
}
