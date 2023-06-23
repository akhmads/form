# Form builder
PHP class for HTML form builder and bootstrap elements

## Available form elements
- Input Text
- Textarea
- Select

## Available bootstrap elements
- Grid
- Card
- Button

## Usage

Install via composer

```
composer require akhmads/form
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