<?php

use \Akhmads\Form\InputText;
use \Akhmads\Form\Card;

require_once 'vendor/autoload.php';

$editor = function( $element ) {
	return '<p>'.$element.'</p>';
};

include 'header.php';

Card::make()->title('Sample Form')->content(

	InputText::make('TITLE')
		->label('Title')
		->addClass('some-class')
		->editor($editor)
		->render(),
	
	InputText::make('NAME')
		->label('Name')
		->render()
		
)->out();

include 'footer.php';