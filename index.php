<?php

use \Akhmads\Form\Grid;
use \Akhmads\Form\Card;
use \Akhmads\Form\InputText;

require_once 'vendor/autoload.php';
require_once 'header.php';


Grid::make()->col_7(
	
	Card::make()->title('Sample Form')->content(
	
		InputText::make('TITLE')->label('Title*')->render(),
		InputText::make('NAME')->label('Name*')->render(),
		InputText::make('DATE')->label('Date*')->type('date')->render()

	)->render()

)->col_5(

	Card::make()->title('Another Form')->addClass('mb-4')->content('<p>Easy Pz Lemon Squeeze</p>')->render(),
	Card::make()->content('<p>Another card</p>')->render()

)->out();


require_once 'footer.php';