<?php

namespace Akhmads\Form;

class Grid
{
	protected static $col;
	protected static $class;
	protected static $extra;
	protected static $editor;
	private static $_instance = null;

	public function __construct() { }
	
	public static function make( $content = null )
	{
		if (self::$_instance === null)
		{
			self::$_instance = new self;
		}
		
		self::$col = [];
		self::$class = [];
		self::$extra = [];
		self::$editor = null;

		return self::$_instance;
	}

	public function col_6()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-6'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}
	
	public function col()
	{
		$args = func_get_args();
		$type = isset($args[0]) ? $args[0] : '';
		unset($args[0]);
		
		$col = '';
		if( count($args) > 0 )
		{
			foreach( $args as $arg )
			{
				$col .= $arg;
			}
		}
		self::$col[] = [ 'class' => $type, 'content' => $col ];
		return $this;
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

	public function getContent()
	{
		$col = [];
		if( count(self::$col) > 0 )
		{
			foreach( self::$col as $arr )
			{
				$class = isset($arr['class']) ? $arr['class'] : '';
				$content = isset($arr['content']) ? $arr['content'] : '';
				$col[] = sprintf('<div class="%s">%s</div>', $class, $content);
			}
		}
		return implode("",$col);
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
			'<div class="row %s">%s</div>',
			self::getClass(),
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