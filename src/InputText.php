<?php

namespace Akhmads\Form;

// ----------------------------------------------
// InputText
// HTML form builder for text input
// ----------------------------------------------

use \Akhmads\Form\InputGroup;

class InputText
{
	protected static $theme;
	protected static $type;
	protected static $name;
	protected static $value;
	protected static $label;
	protected static $wrap;
	protected static $class;
	protected static $extra;
	protected static $editor;
	protected static $append;
	protected static $prepend;
	private static $_instance = null;

	public function __construct() { }
	
	// ----------------------------------------------
	// Default theme 
	// For bootstrap and codeigniter 3
	// ----------------------------------------------

	public function defaultTheme()
	{
		// add .form-control class
		self::addClass('form-control');
		
		// capture error message from codeigniter 3
		$form_error = '';
		if( function_exists('form_error') ) {
			$form_error = form_error(self::$name,'<p class="form-error">','</p>');
		}
		
		// create wrapping element
		self::wrap( function($element) use ($form_error) {
			$element = sprintf(
				'<div class="form-group"><label class="label-sm mb-0">%s</label>%s%s</div>',
				self::getLabel(),
				$element,
				$form_error
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
		self::$label = null;
		self::$wrap = null;
		self::$append = null;
		self::$prepend = null;
		self::$class = [];
		self::$extra = [];
		self::$editor = [];

		// set name attribute
		self::$_instance->name( $name );

		// default theme
		self::$_instance->defaultTheme();
		
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
	// Element wrapper
	// ----------------------------------------------

	public function wrap( $wrap )
	{
		self::$wrap = $wrap;
		return $this;
	}

	public function getWrap()
	{
		return self::$wrap;
	}

	// ----------------------------------------------
	// InputGroup append
	// ----------------------------------------------

	public function append( $append, $withText = TRUE )
	{
		self::$append = [ $append, $withText ];
		return $this;
	}

	public function getAppend()
	{
		return self::$append;
	}

	// ----------------------------------------------
	// InputGroup prepend
	// ----------------------------------------------

	public function prepend( $prepend, $withText = TRUE )
	{
		self::$prepend = [ $prepend, $withText ];
		return $this;
	}

	public function getPrepend()
	{
		return self::$prepend;
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
		$theme = self::getTheme();
		if( $theme AND is_callable($theme) )
		{
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
		
		$prepend = self::getPrepend();
		$append = self::getAppend();
		// apply InputGroup prepend only
		if( is_array($prepend) AND $append == null )
		{
			$pp_content = isset($prepend[0]) ? $prepend[0] : '';
			$pp_withText = isset($prepend[1]) ? $prepend[1] : '';
			$return = InputGroup::make($return)->prepend($pp_content, $pp_withText)->render();
		}
		// apply InputGroup append only
		if( is_array($append) AND $prepend == null )
		{
			$ap_content = isset($append[0]) ? $append[0] : '';
			$ap_withText = isset($append[1]) ? $append[1] : '';
			$return = InputGroup::make($return)->append($ap_content, $ap_withText)->render();
		}
		// apply InputGroup append and prepend
		if( is_array($append) AND is_array($prepend) )
		{
			$ap_content = isset($append[0]) ? $append[0] : '';
			$ap_withText = isset($append[1]) ? $append[1] : '';
			$pp_content = isset($prepend[0]) ? $prepend[0] : '';
			$pp_withText = isset($prepend[1]) ? $prepend[1] : '';
			$return = InputGroup::make($return)->append($ap_content, $ap_withText)->prepend($pp_content, $pp_withText)->render();
		}
		
		// editor with closure function for edit content of attribute
		if( is_array(self::$editor) AND count(self::$editor) > 0 )
		{
			// first declaration is first execution
			self::$editor = array_reverse(self::$editor);
			
			foreach( self::$editor as $editor )
			{
				$return = $editor( $return );
			}
		}

		// add wrapper
		$wrap = self::getWrap();
		if( $wrap AND is_callable($wrap) )
		{
			$return = $wrap( $return );
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