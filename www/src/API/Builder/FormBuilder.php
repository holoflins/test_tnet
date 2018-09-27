<?php

namespace App\API\Builder;

use App\API\Factory\EntityFactory;
use App\API\Factory\RepositoryFactory;
use App\API\Resolver\FormTypeResolver;
use App\Entity\EntityInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormBuilder
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var EntityFactory */
    private $entityFactory;

    /** @var FormTypeResolver */
    private $formTypeResolver;

    /**
     * @param FormFactoryInterface $formFactory
     * @param EntityFactory $entityFactory
     * @param FormTypeResolver $formTypeResolver
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityFactory $entityFactory,
        FormTypeResolver $formTypeResolver
    ) {
        $this->formFactory = $formFactory;
        $this->entityFactory = $entityFactory;
        $this->formTypeResolver = $formTypeResolver;
    }

    /**
     * @param string $entityName
     * @param EntityInterface|null $object
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \App\Exception\FormTypeNotFoundException
     */
    public function build(string $entityName, EntityInterface $object = null, array $options = []): FormInterface
    {
        if (!$object) {
            $object = $this->entityFactory->create($entityName);
        }
        $formType = $this->formTypeResolver->resolveFullNameFromName($entityName);
        $form = $this->formFactory->create($formType, $object, $options);

        return $form;
    }
}
