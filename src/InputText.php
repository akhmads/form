<?php

namespace Akhmads\Form;

// ----------------------------------------------
// InputText
// HTML form builder for text input
// ----------------------------------------------
	
class InputText
{
	protected static $theme;
	protected static $type;
	protected static $name;
	protected static $value;
	protected static $label;
	protected static $class;
	protected static $extra;
	protected static $editor;
	private static $_instance = null;

	public function __construct() { }
	
	// ----------------------------------------------
	// Default theme 
	// For bootstrap and codeigniter 3
	// ----------------------------------------------

	public function defaultTheme()
	{
		self::addClass('form-control');
		self::editor( function($element) {
			$element = sprintf(
				'<div class="form-group"><label class="label-sm mb-0">%s</label>%s</div>',
				self::getLabel(),
				$element
			);
			return $element;
		});
	}

	// ----------------------------------------------
	// Theme with closure function
	// ----------------------------------------------

	public function theme( $theme )
	{
		self::$theme = $theme;
		return $this;
	}

	public function getTheme()
	{
		return self::$theme;
	}

	// ----------------------------------------------
	// Create an element
	// ----------------------------------------------

	public static function make( $name = null )
	{		
		if (self::$_instance === null)
		{
			self::$_instance = new self;
		}

		// reset variable
		self::$type = 'text';
		self::$name = null;
		self::$value = null;
		self::$class = [];
		self::$extra = [];
		self::$editor = [];

		// set name attribute
		self::$_instance->name( $name );

		return self::$_instance;
	}

	// ----------------------------------------------
	// Type attributes
	// ----------------------------------------------

	public function type( $type )
	{
		self::$type = $type;
		return $this;
	}

	public function getType()
	{
		return self::$type;
	}

	// ----------------------------------------------
	// Name attributes
	// ----------------------------------------------

	public function name( $name )
	{
		self::$name = $name;
		return $this;
	}

	public function getName()
	{
		return self::$name;
	}

	// ----------------------------------------------
	// Value attributes
	// ----------------------------------------------

	public function value( $value )
	{
		self::$value = $value;
		return $this;
	}

	public function getValue()
	{
		return self::$value;
	}

	// ----------------------------------------------
	// Label attributes
	// ----------------------------------------------

	public function label( $label )
	{
		self::$label = $label;
		return $this;
	}

	public function getLabel()
	{
		return str_replace( '*', '<i style="color:red;">*</i>', self::$label );
	}

	// ----------------------------------------------
	// Class attributes
	// ----------------------------------------------

	public function addClass( $class )
	{
		self::$class[] = $class;
		return $this;
	}

	public function getClass()
	{
		return implode(" ",self::$class);
	}

	// ----------------------------------------------
	// Extra attributes
	// ----------------------------------------------

	public function extra( $attr, $value )
	{
		self::$extra[$attr] = $value;
		return $this;
	}

	public function getExtra()
	{
		$extra = [];
		if( count(self::$extra) > 0 )
		{
			foreach( self::$extra as $key => $val )
			{
				$extra[] = sprintf('%s="%s"', $key, $val);
			}
		}
		return implode(" ",$extra);
	}

	// ----------------------------------------------
	// Editor with closure function
	// ----------------------------------------------

	public function editor( $editor )
	{
		self::$editor[] = $editor;
		return $this;
	}

	public function getEditor()
	{
		return self::$editor;
	}

	// ----------------------------------------------
	// Render an element
	// ----------------------------------------------
	
	public function render()
	{
		if( self::$theme == '' )
		{
			self::defaultTheme();
		}
		else
		{
			$theme = self::getTheme();
			$theme( self::$_instance );
		}

		// render all attributes to HTML template
		$return = sprintf(
			'<input type="%s" name="%s" value="%s" class="%s" %s>',
			self::getType(),
			self::getName(),
			self::getValue(),
			self::getClass(),
			self::getExtra()
		);
		
		// closure function for edit content of attribute
		if( is_array(self::$editor) AND count(self::$editor) > 0 )
		{
			self::$editor = array_reverse(self::$editor);
			if(self::$name == 'TITLE'){
				print_r(self::$editor);
			}
			foreach( self::$editor as $editor )
			{
				$return = $editor( $return );
			}
		}

		return $return;
	}

	// ----------------------------------------------
	// Output an element
	// ----------------------------------------------

	public function out()
	{
		echo self::render();
	}
}