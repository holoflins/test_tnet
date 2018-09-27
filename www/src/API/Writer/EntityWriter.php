<?php

namespace App\API\Writer;

use App\API\Builder\FormBuilder;
use App\API\Exception\BadRequestException;
use App\API\Exception\EntityNotFoundException;
use App\API\Factory\RepositoryFactory;
use App\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class EntityWriter
{
    /** @var RequestStack */
    private $request;

    public function __construct(RequestStack $request, FormBuilder $formBuilder, RepositoryFactory $repositoryFactory)
    {
        $this->request = $request->getCurrentRequest();
        $this->formBuilder = $formBuilder;
        $this->repositoryFactory = $repositoryFactory;
    }

    /**
     * @param string $entityName
     * @param string|null $uuid
     *
     * @return EntityInterface
     *
     * @throws BadRequestException
     * @throws EntityNotFoundException
     * @throws \App\API\Exception\FormTypeNotFoundException
     * @throws \App\API\Exception\ApiKeyNotFoundException
     */
    public function write(string $entityName, int $id = null): void
    {
        $repository = $this->repositoryFactory->create($entityName);

        $entity = ($id) ? $repository->find($id) : null;

        if (!$entity && $id !== null) {
            throw new EntityNotFoundException(sprintf('Object %s::%s was not found', $entityName, $id));
        }

        $data = json_decode($this->request->getContent(), true);

        $form = $this->formBuilder->build($entityName, $entity);

        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->displayedError($form);
        }

        $object = $form->getData();

        $repository->save($object);
    }

    public function delete(string $entityName, int $id): void
    {
        $repository = $this->repositoryFactory->create($entityName);

        $entity = ($id) ? $repository->find($id) : null;

        if (!$entity && $id !== null) {
            throw new EntityNotFoundException(sprintf('Object %s::%s was not found', $entityName, $id));
        }

        $repository->delete($entity);
    }

    /**
     * @param $form
     * @throws BadRequestException
     */
    private function displayedError($form)
    {
        $errors = $form->getErrors(true, true);

        if ($errors->count()) {
            $errorsMessages = [];

            /** @var FormError $error */
            foreach ($errors as $error) {
                $errorsMessages[$error->getCause()->getPropertyPath()] = $error->getMessage();
            }

            throw new BadRequestException(json_encode($errorsMessages));
        }

        throw new BadRequestException('No fields found for this request.');
    }
}