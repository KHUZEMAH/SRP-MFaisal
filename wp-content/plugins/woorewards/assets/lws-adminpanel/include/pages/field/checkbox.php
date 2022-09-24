<?php
namespace LWS\Adminpanel\Pages\Field;
if( !defined( 'ABSPATH' ) ) exit();

class Checkbox extends \LWS\Adminpanel\Pages\Field
{
	public function input()
	{
		$name = $this->m_Id;
		$value = '';
		$option = false;

		if( isset($this->extra['value']) )
		{
			$option = boolval($this->extra['value']);
		}
		else if( isset($this->extra['checked']) )
		{
			$option = boolval($this->extra['checked']);
		}
		else
		{
			$option = get_option($this->m_Id, false);
			if( $option === false && $this->hasExtra('default') )
				$option = boolval($this->extra['default']);
		}
		if( $option )
			$value = "checked='checked'";

		$class = $this->getExtraCss('class', 'class', false, $this->style);
		$data = $this->getExtraAttr('data', 'data-');

		$disabled = '';
		if( $this->getExtraValue('disabled', false) )
			$disabled = "  disabled onclick='return false;'";

		$id = $this->getExtraAttr('id', 'id');
		echo "<input type='checkbox' name='$name' $value$class$data$disabled$id />";
	}
}
