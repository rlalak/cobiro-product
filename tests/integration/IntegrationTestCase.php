<?php


namespace IntegrationTests;


use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class IntegrationTestCase extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;
    protected static bool $migrationWasRunning = false;

    final protected function setUp() : void
    {
        static::bootKernel();

        /** @noinspection NullPointerExceptionInspection */
        $this->entityManager = $this->getContainer()->get('doctrine')->getManager();

        $this->checkSchemaConnection();

        $this->setUpTest();
        if (!static::$migrationWasRunning) {
            $this->runMigrations();
        }
        $this->setUpSchema();
    }

    protected function get($service_name, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        return $this->getContainer()->get($service_name, $invalidBehavior);
    }

    protected function setUpTest() : void
    {
    }

    protected function setUpSchema() : void
    {
    }

    private function checkSchemaConnection() : void
    {
        try {
            $this->entityManager->getConnection()->connect();
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (ConnectionException $exception) {
            $this->fail(
                'Test `' . static::class .
                '` incomplete, error during connection to schema: ' . $exception->getMessage()
            );
        }
    }

    private function getContainer() : ContainerInterface
    {
        return static::$container;
    }

    protected function runMigrations() : void
    {
        $this->runConsoleCommand('doctrine:migrations:migrate');

        static::$migrationWasRunning = true;
    }

    protected function runConsoleCommand(string $command, array $commandInput = []) : bool
    {
        $commandInput['command'] = $command;

        $input = new ArrayInput($commandInput);
        $input->setInteractive(false);

        $output = new BufferedOutput();

        /** @noinspection PhpUnhandledExceptionInspection */
        if (0 !== $this->getConsoleCommand($command)->run($input, $output)) {
            /** @noinspection PhpUndefinedClassInspection */
            throw new Exception($output->fetch());
        }

        return true;
    }

    protected function getConsoleCommand(string $command) : Command
    {
        $application = new Application(static::bootKernel());

        return $application->find($command);
    }

    protected function executeQuery(
        $query,
        array $params = [],
        array $types = [],
        QueryCacheProfile $qcp = null
    ) : ResultStatement {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->entityManager->getConnection()->executeQuery($query, $params, $types, $qcp);
    }
}
