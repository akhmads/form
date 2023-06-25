<?php

namespace Akhmads\Form;

// ----------------------------------------------
// Grid
// Bootstrap Grid builder
// ----------------------------------------------

class Grid
{
	protected static $col;
	protected static $class;
	protected static $extra;
	protected static $editor;
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
		self::$col = [];
		self::$class = [];
		self::$extra = [];
		self::$editor = null;

		return self::$_instance;
	}

	// ----------------------------------------------
	// Create a column
	// ----------------------------------------------

	public function col()
	{
		$args = func_get_args();
		$class = isset($args[0]) ? $args[0] : '';
		unset($args[0]);
		
		$content = '';
		if( count($args) > 0 )
		{
			foreach( $args as $arg )
			{
				$content .= $arg;
			}
		}
		self::$col[] = [ 'class' => $class, 'content' => $content ];
		return $this;
	}

	public function col_1()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-1'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_2()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-2'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_3()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-3'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_4()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-4'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_5()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-5'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}
	
	public function col_6()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-6'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_7()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-7'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_8()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-8'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_9()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-9'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_10()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-10'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_11()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-11'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
	}

	public function col_12()
	{
		$args = func_get_args();
		$args = array_merge(['col-md-12'], $args);
		call_user_func_array( [ self::$_instance, 'col' ], $args );
		return $this;
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
	// Content getter
	// ----------------------------------------------

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

	// ----------------------------------------------
	// Render an element
	// ----------------------------------------------

	public function render()
	{
		// render all attributes to HTML template
		$return = sprintf(
			'<div class="row %s" %s>%s</div>',
			self::getClass(),
			self::getExtra(),
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