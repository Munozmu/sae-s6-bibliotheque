<?php

namespace App\State;

use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Livre;
use App\Entity\Emprunt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class LoanStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
        private EntityManagerInterface $entityManager,
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Emprunt
    {
        if ($operation instanceof DeleteOperationInterface) {
            return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
        }
        $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);

        /**
         * @var Emprunt $data
         */
        $reservation = $data->getCorrespondre()->getReservations();

        if (null !== $reservation) {

            // Get the EntityManager
            $entityManager = $this->entityManager;

            // Remove the reservation
            $entityManager->remove($reservation);

            // Flush the changes to persist the deletion
            $entityManager->flush();
        }


        return $result;
    }
}
