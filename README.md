# Form builder
PHP class for HTML form builder and bootstrap elements

## Available form elements
- Input Text
- Textarea (on progress)
- Select (on progress)
- Checkbox (on progress)
- Select2 (on progress)

## Available bootstrap elements
- Grid
- Card
- Button (on progress)

## Usage

Install via composer

```
composer require akhmads/form:dev-master
```

On your php code

```php
require_once 'vendor/autoload.php';
```

Create a input Text

```php
use \Akhmads\Form\InputText;

require_once 'vendor/autoload.php';

InputText::make('FULL_NAME')->label('Full Name')->render();
```

Input text inside Card

```php
use \Akhmads\Form\Card;
use \Akhmads\Form\InputText;

Card::make()->title('Sample Form')->content(
	
	InputText::make('TITLE')->label('Title*')->render(),
	InputText::make('DATE')->label('Date*')->type('date')->render()

)->render();
```

Documentation is on progress :)