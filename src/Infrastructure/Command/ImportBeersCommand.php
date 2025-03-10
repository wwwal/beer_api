<?php

namespace App\Infrastructure\Command;

use App\Application\Action\CreateBeers;
use App\Application\Action\ParseCSVFile;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\BeerRepository;
use App\Infrastructure\Repository\BeerStyleRepository;
use App\Infrastructure\Repository\BrewerRepository;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;

#[AsCommand(
    name: 'import-beers',
    description: 'Import beers from csv file',
)]
class ImportBeersCommand extends Command
{
    private $csvPath = 'open-beer-database.csv';
    private $chunkSize = 100;

    public function __construct(
        private BeerStyleRepository $beerStyleRepository,
        private BrewerRepository $brewerRepository,
        private BeerRepository $beerRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $parseCSVFile = new ParseCSVFile();

        $csvData = $parseCSVFile($this->csvPath);
        $progressBar = new ProgressBar($output, count($csvData));
        
        $createBeers = new CreateBeers(
            $this->beerStyleRepository,
            $this->brewerRepository,
            $this->beerRepository,
            $this->beerRepository
        );

        $chunks = array_chunk($csvData, $this->chunkSize);

        foreach ($chunks as $chunk) {
            $createBeers($chunk);
            $progressBar->advance($this->chunkSize);
        }

        $progressBar->finish();
        $io->success('Beers imported');

        return Command::SUCCESS;
    }
}
