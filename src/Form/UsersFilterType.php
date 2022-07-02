<?php

namespace App\Form;

use App\Repository\UsersRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UsersFilterType extends AbstractType
{
    private $entityManager;   
    private $usersRepo;

    public function __construct(EntityManagerInterface $entityManager, UsersRepository $usersRepository){
        $this->entityManager = $entityManager;
        $this->usersRepo = $usersRepository;

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('options', ChoiceType::class, [
                'choices' => $this->usersRepo->getUserOptions(),
                'choice_label' => function ($value) {
                        return $value;
                    }
            ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
