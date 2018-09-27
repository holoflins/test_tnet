<?php

namespace Tests\Small\API\Writer;

use App\API\Builder\FormBuilder;
use App\API\Factory\RepositoryFactory;
use App\API\Writer\EntityWriter;
use App\Entity\EntityInterface;
use App\API\Exception\BadRequestException;
use App\API\Exception\EntityNotFoundException;
use App\Repository\AddressRepository;
use App\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolationInterface;

class EntityWriterTest extends TestCase
{
    /** @var RequestStack */
    private $requestStack;

    /** @var FormBuilder */
    private $formBuilder;

    /** @var RepositoryFactory */
    private $repositoryFactory;

    /** @var Request */
    private $request;

    /** @var RepositoryInterface */
    private $repositoryInterface;

    /** @var string */
    private $entityName = 'entityName';

    /** @var string */
    private $content = '{"test": "form"}';

    protected function setUp()
    {
        $this->requestStack = $this->createMock(RequestStack::class);
        $this->formBuilder = $this->createMock(FormBuilder::class);
        $this->repositoryFactory = $this->createMock(RepositoryFactory::class);
        $this->request = $this->createMock(Request::class);
        $this->repositoryInterface = $this->createMock(RepositoryInterface::class);
    }

    /**
     * @return EntityWriter
     */
    private function init(): EntityWriter
    {
        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($this->request);

        return new EntityWriter($this->requestStack, $this->formBuilder, $this->repositoryFactory);
    }

    public function testWriteEntityNotFound()
    {
        $id = 42;

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($this->repositoryInterface);

        $this->repositoryInterface->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(false);

        $this->expectException(EntityNotFoundException::class);

        $this->init()->write($this->entityName, $id);
    }

    public function testWriteNotSubmitted()
    {
        $form = $this->createMock(FormInterface::class);
        $formError = $this->createMock(FormErrorIterator::class);
        $entity = $this->createMock(EntityInterface::class);

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($this->repositoryInterface);

        $this->formBuilder->expects($this->once())
            ->method('build')
            ->with($this->entityName)
            ->willReturn($form);

        $this->request->expects($this->once())
            ->method('getContent')
            ->willReturn($this->content);

        $form->expects($this->once())
            ->method('submit')
            ->with(json_decode($this->content, true));

        $form->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(false);

        $form->expects($this->once())
            ->method('getErrors')
            ->with(true, true)
            ->willReturn($formError);

        $formError->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $this->expectException(BadRequestException::class);

        $this->init()->write($this->entityName);
    }

    public function testWriteWithErrors()
    {
        $form = $this->createMock(FormInterface::class);
        $error = $this->createMock(FormError::class);
        $formError = new FormErrorIterator($form, [$error]);
        $cause = $this->createMock(ConstraintViolationInterface::class);

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($this->repositoryInterface);

        $this->formBuilder->expects($this->once())
            ->method('build')
            ->with($this->entityName)
            ->willReturn($form);

        $this->request->expects($this->once())
            ->method('getContent')
            ->willReturn($this->content);

        $form->expects($this->once())
            ->method('submit')
            ->with(json_decode($this->content, true));

        $form->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $form->expects($this->once())
            ->method('getErrors')
            ->with(true, true)
            ->willReturn($formError);

        $error->expects($this->once())
            ->method('getCause')
            ->willReturn($cause);

        $cause->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('propertyPath');

        $error->expects($this->once())
            ->method('getMessage')
            ->willReturn('One error');

        $this->expectException(BadRequestException::class);

        $this->init()->write($this->entityName);
    }

    public function testWriteWithIdNull()
    {
        $form = $this->createMock(FormInterface::class);
        $entity = $this->createMock(EntityInterface::class);

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with('category')
            ->willReturn($this->repositoryInterface);

        $this->repositoryInterface->expects($this->once())
            ->method('save')
            ->willReturn($entity);

        $this->formBuilder->expects($this->once())
            ->method('build')
            ->with('category')
            ->willReturn($form);

        $this->request->expects($this->once())
            ->method('getContent')
            ->willReturn($this->content);

        $form->expects($this->once())
            ->method('submit')
            ->with(json_decode($this->content, true));

        $form->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('getData')
            ->willReturn($entity);

        $this->init()->write('category');
    }

    public function testWriteWithIdNotNullNotSubmitted()
    {
        $form = $this->createMock(FormInterface::class);
        $error = $this->createMock(FormError::class);
        $formError = new FormErrorIterator($form, [$error]);
        $cause = $this->createMock(ConstraintViolationInterface::class);

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($this->repositoryInterface);

        $this->formBuilder->expects($this->once())
            ->method('build')
            ->with($this->entityName)
            ->willReturn($form);

        $this->request->expects($this->once())
            ->method('getContent')
            ->willReturn($this->content);

        $form->expects($this->once())
            ->method('submit')
            ->with(json_decode($this->content, true));

        $form->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(false);

        $form->expects($this->once())
            ->method('getErrors')
            ->with(true, true)
            ->willReturn($formError);

        $error->expects($this->once())
            ->method('getCause')
            ->willReturn($cause);

        $cause->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('propertyPath');

        $error->expects($this->once())
            ->method('getMessage')
            ->willReturn('One error');

        $this->expectException(BadRequestException::class);

        $this->init()->write($this->entityName);
    }

    public function testWriteWithIdNotNullWithErrors()
    {
        $form = $this->createMock(FormInterface::class);
        $formError = $this->createMock(FormErrorIterator::class);
        $entity = $this->createMock(EntityInterface::class);

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($this->repositoryInterface);

        $this->repositoryInterface->expects($this->once())
            ->method('find')
            ->with(42)
            ->willReturn($entity);

        $this->formBuilder->expects($this->once())
            ->method('build')
            ->with($this->entityName)
            ->willReturn($form);

        $this->request->expects($this->once())
            ->method('getContent')
            ->willReturn($this->content);

        $form->expects($this->once())
            ->method('submit')
            ->with(json_decode($this->content, true));

        $form->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $form->expects($this->once())
            ->method('getErrors')
            ->with(true, true)
            ->willReturn($formError);

        $formError->expects($this->once())
            ->method('count')
            ->willReturn(1);

        $this->expectException(BadRequestException::class);

        $this->init()->write($this->entityName, 42);
    }

    public function testWriteWithIdNotNull()
    {
        $form = $this->createMock(FormInterface::class);
        $entity = $this->createMock(EntityInterface::class);

        $this->repositoryFactory->expects($this->once())
            ->method('create')
            ->with($this->entityName)
            ->willReturn($this->repositoryInterface);

        $this->repositoryInterface->expects($this->once())
            ->method('find')
            ->with(42)
            ->willReturn($entity);

        $this->repositoryInterface->expects($this->once())
            ->method('save')
            ->with($entity);

        $this->formBuilder->expects($this->once())
            ->method('build')
            ->with($this->entityName, $entity)
            ->willReturn($form);

        $this->request->expects($this->once())
            ->method('getContent')
            ->willReturn($this->content);

        $form->expects($this->once())
            ->method('submit')
            ->with(json_decode($this->content, true));

        $form->expects($this->once())
            ->method('isSubmitted')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('getData')
            ->willReturn($entity);

        $this->init()->write($this->entityName, 42);
    }
}