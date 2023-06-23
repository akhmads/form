<?php

use \Akhmads\Form\Row;
use \Akhmads\Form\Card;
use \Akhmads\Form\InputText;

require_once 'vendor/autoload.php';
require_once 'header.php';

$tes = function( $element )
{
	return $element; //str_replace('Easy','Ez',$element);
};

Row::make()->col('col-md-4',
	
	Card::make()->title('Sample Form')->content(
		InputText::make('TITLE')->label('Title')->render(),
		InputText::make('NAME')->label('Name')->render()
	)

)->col('col-md-4',

	Card::make()->title('Another Form')->editor($tes)->content('<p>Easy Pz Lemon Squeeze</p>')

)->out();

require_once 'footer.php';