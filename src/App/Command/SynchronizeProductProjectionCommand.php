<?php


namespace App\Command;


use Doctrine\DBAL\Connection;
use Interview\Product\Domain\ProductProjectionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeProductProjectionCommand extends Command
{
    /**
     * @var ProductProjectionInterface
     */
    private ProductProjectionInterface $productProjection;
    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(ProductProjectionInterface $productProjection, Connection $connection)
    {
        $this->productProjection = $productProjection;
        $this->connection = $connection;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this
            ->setName('product:synchronize-projection')
            ->setDescription('Synchronize product projection with write model');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $output->write('Reseting projection... ');
        $this->productProjection->reset();
        $output->writeln('done');

        $output->write('Loading products data... ');
        $productsData = $this->connection->fetchAllAssociative('SELECT * FROM products');
        $output->writeln('loaded `' . count($productsData) . '` products');

        $output->write('Updating projection...');
        foreach ($productsData as $productData) {
            $this->productProjection->updateProduct(
                $productData['id'],
                $productData['name'],
                $productData['price_amount'],
                $productData['price_currency'],
            );
        }
        $output->writeln(' done');

        return static::SUCCESS;
    }
}
