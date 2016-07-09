<?php

namespace Odiseo\Bundle\AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;

class NewsFormType extends AbstractResourceType
{
	protected $securityContext;
	
	public function __construct($dataClass, $securityContext, array $validationGroups = array())
	{
		parent::__construct($dataClass, $validationGroups);
		
		$this->securityContext = $securityContext;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', 'sylius_translations', array(
        	    'form_type' => 'odiseo_news_translation',
        	    'label'    => 'Traducciones'
            ))
        ;
    }
	
    public function getName()
    {
        return 'odiseo_news';
    }
}