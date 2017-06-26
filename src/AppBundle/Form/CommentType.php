<?php

namespace AppBundle\Form;

use AppBundle\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Github\Client;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * @var Github/Client
     */
    private $git;

    public function __construct(Client $git)
    {
        $this->git = $git;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $repos = $this->git->api('user')->repositories($options['login']);

        $sortedRepos = [];
        foreach ($repos as $repo) {
            $name = explode('/', $repo['full_name'])[1];
            $sortedRepos[$name] = $name;
        }

        $builder
            ->add('repo', ChoiceType::class, [
               'choices' => $sortedRepos,
            ])
            ->add('content', TextareaType::class)
            ->add('submit', SubmitType::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'comment';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'login' => null,
        ]);
    }
}
