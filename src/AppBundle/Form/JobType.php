<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of JobType
 *
 * @author Blety
 */
class JobType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('Parse', SubmitType::class);
    }
}
