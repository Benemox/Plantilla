<?php

namespace App\Provider\FinanceAds\Application\Command;

use App\Provider\FinanceAds\Application\Service\CardProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:import-cards', description: 'Imports credit cards from the external API.')]
class ImportCardsCommand extends Command
{
    public function __construct(private CardProvider $cardProvider)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Starting credit card import...');

        try {
            $this->cardProvider->importCards();
            $io->success('Import completed successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Error importing cards: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
