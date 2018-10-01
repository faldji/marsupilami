<?php

namespace CoreBundle\Form;

use CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CarnetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $datums = $options['data'];
        $builder->add('tmpFriend', EntityType::class, array(
            'class' => User::class,
            'query_builder' => function (EntityRepository $er)use ($datums) {
                return $er->createQueryBuilder('f')
                    ->Where('f.id <> :id')
                    ->setParameter('id',$datums->getId());
            },
            'choice_label' => 'username',
            'multiple' => false,
            'required' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>  User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'carnet';
    }


}
