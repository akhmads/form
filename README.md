# Form builder
PHP class for HTML form builder and bootstrap elements

## Available form elements
- Input Text
- Textarea
- Select (on progress)
- Checkbox (on progress)
- Select2 (on progress)

## Available bootstrap elements
- Grid
- Card
- Button
- Input Group

## Usage

Install via composer

```
composer require akhmads/form:dev-master
```

On your php code

```php
require_once 'vendor/autoload.php';
```

Dont forget add bootstrap css and js

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
```

Create a input Text

```php
use \Akhmads\Form\InputText;

InputText::make('FULL_NAME')->label('Full Name')->out();
```

Input text inside Card

```php
use \Akhmads\Form\Card;
use \Akhmads\Form\InputText;

Card::make()->title('Sample Form')->content(
	
	InputText::make('TITLE')->label('Title*')->render(),
	InputText::make('DATE')->label('Date*')->type('date')->render()

)->out();
```

Documentation is on progress :)