<?php

namespace Tests\Small\API\Builder;

use App\API\Builder\FormBuilder;
use App\API\Factory\EntityFactory;
use App\API\Resolver\FormTypeResolver;
use App\Entity\EntityInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

class FormBuilderTest extends TestCase
{
    /** @var FormFactory */
    private $formFactory;

    /** @var EntityFactory */
    private $entityFactory;

    /** @var FormTypeResolver */
    private $formTypeResolver;

    private $entityName = 'entityName';

    protected function setUp()
    {
        $this->formFactory = $this->createMock(FormFactory::class);
        $this->entityFactory = $this->createMock(EntityFactory::class);
        $this->formTypeResolver = $this->createMock(FormTypeResolver::class);
    }

    /**
     * @return FormBuilder
     */
    private function init(): FormBuilder
    {
        return new FormBuilder($this->formFactory, $this->entityFactory, $this->formTypeResolver);
    }

    public function testBuildWithObject()
    {
        $object = $this->createMock(EntityInterface::class);
        $formType = FormTypeInterface::class;
        $form = $this->createMock(FormInterface::class);
        $options = [];

        $this->formTypeResolver->expects($this->once())
            ->method('resolveFullNameFromName')
            ->with($this->entityName)
            ->willReturn($formType);

        $this->formFactory->expects($this->once())
            ->method('create')
            ->with($formType, $object, $options)
            ->willReturn($form);

        $this->assertSame($form, $this->init()->build($this->entityName, $object, $options));
    }

    public function testBuildWithoutObject()
    {
        $object = $this->createMock(EntityInterface::class);
        $formType = FormTypeInterface::class;
        $form = $this->createMock(FormInterface::class);
        $options = [];

        $this->entityFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($object);

        $this->formTypeResolver->expects($this->once())
            ->method('resolveFullNameFromName')
            ->with($this->entityName)
            ->willReturn($formType);

        $this->formFactory->expects($this->once())
            ->method('create')
            ->with($formType, $object, $options)
            ->willReturn($form);

        $this->assertSame($form, $this->init()->build($this->entityName, null, $options));
    }
}