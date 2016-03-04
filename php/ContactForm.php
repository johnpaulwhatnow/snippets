<?php 

/*
*
*Basic Contact Form used in Symfony / Silex projects
*
*
*

*/



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;

class ContactForm extends AbstractType
{
	
    public $user_name;
	public $email;
	public $message;

    public function __construct($property_id =''){

        
    }
	public function hydrate_form($data){
		foreach($data as $k=>$v){
			if(property_exists($this, $k)) {
				$this->$k = $v;
			}
			
		}
		
	}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

         $builder->add('user_name', 'text', array(
				'label'=>'Your Name',
                'constraints' => array(new Constraints\NotBlank(array('message' => 'Please include your name'))),
                
				'required'=>true,
				'attr'=>array('placeholder'=> 'YOUR NAME')
            ));
			
         $builder->add('email', 'email', array(
				'label'=>'Your Email',
                'constraints' => array(new Constraints\NotBlank(array('message' => 'Please include your email')), new Constraints\Email(array(
            'message' => '"{{ value }}" is not a valid email.',
            'checkMX' => true,
        ))),
                 
				'required'=>true,
				'attr'=>array('placeholder'=> 'YOUR EMAIL')
            ));
         $builder->add('message', 'textarea', array(
				'label'=>'Your Message',
                'constraints' => array(new Constraints\NotBlank(array('message' => 'Please include a message'))),
                
				'required'=>true,
				'attr'=>array('class'=>'form-control', 'placeholder'=> 'YOUR MESSAGE')
            ));
			
		
			
			

		return $builder;

    }

    public function getName()
    {
        return 'contact_form';
    }
	

    public function getUserName()
    {
        return $this->user_name;
    }


    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }
	
    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
	
    public function getMessage()
    {
        return $this->message;
    }


    public function setMessage($message)
    {
        $this->message = $message;
    }




}