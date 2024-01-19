<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Communication\TaskCommunicationFactory getFactory()
 */
class TaskDeleteConfirmationForm extends AbstractType
{
    /**
     * @var string
     */
    protected const DELETE_TASK_URL = '/task/edit/delete';

    /**
     * @var string
     */
    protected const DELETE_METHOD = 'DELETE';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'delete_confirm_form';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setAction(static::DELETE_TASK_URL);
        $builder->setMethod(static::DELETE_METHOD);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-inline',
            ],
        ]);
    }
}
