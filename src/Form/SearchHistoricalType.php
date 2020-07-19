<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\SearchHistorical;
use App\Entity\SymbolsGateway;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SearchHistoricalType extends AbstractType
{
    /**
     * @var SymbolsGateway
     */
    private $symbolsGateway;

    /**
     * @var string[]
     */
    private $companyOptions;

    /**
     * SearchType constructor.
     *
     * @param SymbolsGateway $symbolsGateway
     */
    public function __construct(SymbolsGateway $symbolsGateway)
    {
        $this->symbolsGateway = $symbolsGateway;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companySymbol', ChoiceType::class, [
                'label'   => 'Company Name',
                'choices' => $this->getCompanyOptions()
            ])
            ->add('startDate', DateType::class, [
                'label'  => 'Start Date',
                'widget' => 'single_text',
                'html5'  => false,
                'attr'   => ['class' => 'js-datepicker']
            ])
            ->add('endDate', DateType::class, [
                'label' => 'End Date',
                'widget' => 'single_text',
                'html5' => false,
                'attr'  => ['class' => 'js-datepicker']
            ])
            ->add('email', TextType::class, ['label' => 'E-mail'])
            ->add('save', SubmitType::class, ['label' => 'Search'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchHistorical::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'search_item'
        ]);
    }

    /**
     * @return array|string[]|null
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getCompanyOptions(): ?array
    {
        if (!$this->companyOptions) {
            $this->companyOptions = $this->symbolsGateway->getList();
        }

        return $this->companyOptions;
    }
}