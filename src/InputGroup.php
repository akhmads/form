<?php

namespace Akhmads\Form;

// ----------------------------------------------
// Button
// HTML form builder for Input Group
// ----------------------------------------------
	
class InputGroup
{
	protected static $theme;
	protected static $content;
	protected static $append;
	protected static $prepend;
	protected static $appendWithText;
	protected static $prependWithText;
	protected static $class;
	protected static $extra;
	protected static $editor;
	private static $_instance = null;

	public function __construct() { }
	
	// ----------------------------------------------
	// Default theme 
	// For bootstrap
	// ----------------------------------------------

	public function defaultTheme()
	{
		// add .form-control class
		self::addClass('input-group');
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

	public static function make( $content = null )
	{		
		if (self::$_instance === null)
		{
			self::$_instance = new self;
		}

		// reset variable
		self::$content = null;
		self::$append = null;
		self::$prepend = null;
		self::$appendWithText = null;
		self::$prependWithText = null;
		self::$class = [];
		self::$extra = [];
		self::$editor = [];

		// set name attribute
		self::$_instance->content( $content );

		// default theme
		self::$_instance->defaultTheme();
		
		return self::$_instance;
	}

	// ----------------------------------------------
	// Content Elements
	// ----------------------------------------------

	public function content( $content )
	{
		self::$content = $content;
		return $this;
	}

	public function getContent()
	{
		return self::$content;
	}

	// ----------------------------------------------
	// Append Elements
	// ----------------------------------------------

	public function append( $append, $withText = TRUE )
	{
		self::$append = $append;
		self::$appendWithText = $withText;
		return $this;
	}

	public function getAppend()
	{
		if( self::$append !== null )
		{
			if( self::$appendWithText )
			{
				$template = '<span class="input-group-append"><span class="input-group-text">%s</span></span>';
			}
			else
			{
				$template = '<span class="input-group-append">%s</span>';
			}
			self::$append = sprintf(
				$template,
				self::$append
			);
		}
		return self::$append;
	}

	// ----------------------------------------------
	// Prepend Elements
	// ----------------------------------------------

	public function prepend( $prepend, $withText = TRUE )
	{
		self::$prepend = $prepend;
		self::$prependWithText = $withText;
		return $this;
	}

	public function getPrepend()
	{
		if( self::$prepend !== null )
		{
			if( self::$prependWithText )
			{
				$template = '<span class="input-group-prepend"><span class="input-group-text">%s</span></span>';
			}
			else
			{
				$template = '<span class="input-group-prepend">%s</span>';
			}
			self::$prepend = sprintf(
				$template,
				self::$prepend
			);
		}
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
			'<div class="%s" %s>%s%s%s</div>',
			self::getClass(),
			self::getExtra(),
			self::getPrepend(),
			self::getContent(),
			self::getAppend()
		);
		
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