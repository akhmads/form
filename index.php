<?php

use \Akhmads\Form\Grid;
use \Akhmads\Form\Card;
use \Akhmads\Form\InputText;

require_once 'vendor/autoload.php';
require_once 'header.php';

Grid::make()->col_6(
	
	Card::make()->title('Sample Form')->content(
	
		InputText::make('TITLE')->label('Title*')->render(),
		InputText::make('NAME')->label('Name*')->render(),
		InputText::make('DATE')->label('Date*')->type('date')->render()
	)

)->col_6(

	Card::make()->title('Another Form')->content('<p>Easy Pz Lemon Squeeze</p>')

)->out();

require_once 'footer.php';