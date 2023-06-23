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
		
		return self::render();
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

	public function extra( $attr, $value )
	{
		self::$extra[$attr] = $value;
		return $this;
	}

	public function editor( $editor )
	{
		self::$editor = $editor;
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

	public function getEditor()
	{
		return self::$editor;
	}
	
	public function render()
	{
		$return = sprintf(
			'<div class="card %s">%s<div class="card-body">%s</div></div>',
			self::getClass(),
			self::getTitle(),
			self::getContent()
		);
		
		if( self::$editor !== null )
		{
			$editor = self::getEditor();
			$return = $editor( $return );
		}
		
		return $return;
	}

	public function out()
	{
		echo self::render();
	}
}