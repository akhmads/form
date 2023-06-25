<?php

namespace Akhmads\Form;

// ----------------------------------------------
// Card
// Bootstrap Card builder
// ----------------------------------------------

class Card
{
	protected static $title;
	protected static $content;
	protected static $class;
	protected static $extra = [];
	protected static $editor = null;
	private static $_instance = null;

	public function __construct() { }
	
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
		self::$title = null;
		self::$content = null;
		self::$class = [];
		self::$extra = [];
		self::$editor = null;
		
		if( $content !== null )
		{
			self::$_instance->content( $content );
		}

		return self::$_instance;
	}

	// ----------------------------------------------
	// Card Title
	// ----------------------------------------------

	public function title( $title )
	{
		self::$title = $title;
		return $this;
	}

	public function getTitle()
	{
		if( self::$title !== null )
		{
			self::$title = sprintf(
				'<div class="card-header"><h3 class="card-title">%s</h3></div>',
				self::$title
			);
		}
		return self::$title;
	}

	// ----------------------------------------------
	// Card Content
	// ----------------------------------------------

	public function content()
	{
		$args = func_get_args();
		$content = '';
		if( is_array($args) AND count($args) > 0 )
		{
			foreach( $args as $arg )
			{
				$content .= $arg;
			}
		}
		self::$content = $content;
		
		return $this;
	}

	public function getContent()
	{
		return self::$content;
	}

	// ----------------------------------------------
	// Class attribute
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
	// Extra attribute
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
		// render all attributes to HTML template
		$return = sprintf(
			'<div class="card %s" %s>%s<div class="card-body">%s</div></div>',
			self::getClass(),
			self::getExtra(),
			self::getTitle(),
			self::getContent()
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