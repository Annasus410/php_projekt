<?php
/**
 * UserData Type.
 */

namespace App\Form;


use App\Entity\UserData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Class UserData Type.
 */
class UserDataType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->add(
            'Name',
            TextType::class,
            [
                'label' => 'Imię',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );

        $builder->add(
            'Lastname',
            TextType::class,
            [
                'label' => 'Nazwisko',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );

        $builder->add(
            'Mail',
            EmailType::class,
            [
                'label' => 'Nazwisko',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );

        $builder->add(
            'PhoneNumber',
            NumberType::class,
            [
                'label' => 'Numer telefonu',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );
        $builder->add(
            'PhoneNumber',
            NumberType::class,
            [
                'label' => 'Numer telefonu',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );

        $builder->add(
            'City',
            TextType::class,
            [
                'label' => 'Miasto',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );



    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => UserData::class, 'id'=>0]);
        $resolver->addAllowedTypes('id',['int']);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'userdata';
    }
}

