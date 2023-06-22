<?php

namespace Akhmads\Form;

class InputText
{
	protected static $theme = '';
	protected static $type = 'text';
	protected static $name = '';
	protected static $label = '';
	protected static $class = [];
	protected static $extra = [];
	protected static $value = '';
	protected static $editor = '';
	
	private static $_instance = null;

    public function __construct() { }
	
	public function defaultTheme()
	{
		self::addClass('form-control');
		self::editor(function($element){
			$element = sprintf(
				'<div class="form-group"><label class="label-sm mb-0">%s</label>%s</div>',
				self::getLabel(),
				$element
			);
			return $element;
		});
	}
	
	public static function make( $name = null )
    {
        if (self::$_instance === null)
		{
            self::$_instance = new self;
        }
		
		if( $name !== null )
		{
			self::$_instance->extra('name', $name);
		}

        return self::$_instance;
    }

	public function theme( $theme )
	{
		self::$theme = $theme;
		return $this;
	}

	public function label( $label )
	{
		self::$label = $label;
		return $this;
	}

	public function value( $value )
	{
		self::$value = $value;
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
	
	public function getTheme()
	{
		return self::$theme;
	}

	public function getLabel()
	{
		return self::$label;
	}

	public function getValue()
	{
		return self::$value;
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
		if( self::$theme == '' )
		{
			self::defaultTheme();
		}
		else
		{
			$theme = self::getTheme();
			$theme( self::$_instance );
		}

		$return = sprintf(
			'<input type="%s" value="%s" class="%s" %s>',
			self::$type,
			self::getValue(),
			self::getClass(),
			self::getExtra()
		);
		
		if( self::$editor !== '' )
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