<?php

namespace Akhmads\Form;

class Card
{
	protected static $title = null;
	protected static $content = null;
	protected static $class = [];
	protected static $extra = [];
	protected static $editor = null;
	private static $_instance = null;

	public function __construct() { }
	
	public static function make( $content = null )
	{
		if (self::$_instance === null)
		{
			self::$_instance = new self;
		}
		
		if( $content !== null )
		{
			self::$_instance->content( $content );
		}

		return self::$_instance;
	}

	public function title( $title )
	{
		self::$title = $title;
		return $this;
	}

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
	
	public function addClass( $class )
	{
		self::$class[] = $class;
		return $this;
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

	public function getContent()
	{
		return self::$content;
	}

	public function getClass()
	{
		return implode(" ",self::$class);
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