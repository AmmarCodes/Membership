<?php

// Bootstrap Form macros

Form::macro ( 'textField', function ($name, $label = null, $value = null, $attributes = array()) {
	$element = Form::text ( $name, $value, fieldAttributes ( $name, $attributes ) );

	return fieldWrapper ( $name, $element, $label );
} );

Form::macro ( 'emailField', function ($name, $label = null, $value = null, $attributes = array()) {
	$element = Form::email ( $name, $value, fieldAttributes ( $name, $attributes ) );

	return fieldWrapper ( $name, $element, $label );
} );

Form::macro ( 'passwordField', function ($name, $label = null, $value = null, $attributes = array()) {
	$element = Form::password ( $name, fieldAttributes ( $name, $attributes ) );

	return fieldWrapper ( $name, $element, $label );
} );

Form::macro ( 'textareaField', function ($name, $label = null, $value = null, $attributes = array()) {
	if (! isset ( $attributes ['rows'] )) {
		$attributes = array_merge ( $attributes, array (
				'rows' => 3
		) );
	}
	$element = Form::textarea ( $name, $value, fieldAttributes ( $name, $attributes ) );

	return fieldWrapper ( $name, $element, $label );
} );

Form::macro ( 'selectField', function ($name, $options, $label = null, $value = null, $attributes = array()) {
    $options = array('' => 'Select')+$options;
	$element = Form::select ( $name, $options, $value, fieldAttributes ( $name, $attributes ) );
	return fieldWrapper ( $name, $element, $label );
} );

Form::macro ( 'selectMultipleField', function ($name, $options, $label = null, $value = null, $attributes = array()) {
	$attributes = array_merge ( $attributes, array (
			'multiple' => true
	) );
	$element = Form::select ( $name . '[]', $options, $value, fieldAttributes ( $name, $attributes ) );

	return fieldWrapper ( $name, $element, $label );
} );

// fieldName, text, value, checked, attribs for each entry
// checkboxGroup('enter name', array(
// array(name=>'sal_gt_20k', display=>'GT 20K', value=>'1', checked=>true)
// ));
Form::macro ( 'checkboxGroup', function ($label, $options = array()) {
	$grp = '';
	$class = '';
	$field = '';
	foreach ( $options as $option ) {
		$grp .= checkbox ( $option ['name'], $option ['display'], $option ['value'], $option ['checked'], $option ['attribs'] = array () );
		$grp .= '&nbsp;&nbsp;';
		if (fieldError ( $option ['name'] )) {
			$class = 'has-error';
			$field = $option ['name'];
		}
	}
	return '<div class="' . $class . '">' . fieldWrapper ( $field, $grp, $label ) . '</div>';
} );
// fieldName, text, value, checked, attribs for each entry
// radioGroup('enter name', array(
// array(name=>'sal_gt_20k', display=>'GT 20K', value=>'1', checked=>true)
// ));
Form::macro ( 'radioGroup', function ($label, $options = array()) {
	$grp = '';
	foreach ( $options as $option ) {
		$fieldName = $option ['name'];
		$grp .= radio ( $option ['name'], $option ['display'], $option ['value'], $option ['checked'], $option ['attribs'] = array () );
		$grp .= '&nbsp;&nbsp;';
	}
	return '<div class="' . fieldError ( $fieldName ) . '">' . fieldWrapper ( $fieldName, $grp, $label ) . '</div>';
} );
Form::macro ( 'checkboxGroupTable', function ($label, $rows, $columns, $options = array()) {
	$getData = renderTabular ( $rows, $columns, $options );
	return '<div class="' . $getData->error . '">' . fieldWrapper ( $getData->field, $getData->html, $label ) . '</div>';
} );
Form::macro ( 'radioGroupTable', function ($label, $rows, $columns, $options = array()) {
	$getData = renderTabular ( $rows, $columns, $options, 'radio' );
	return '<div class="' . fieldError ( $getData->field ) . '">' . fieldWrapper ( $getData->field, $getData->html, $label ) . '</div>';
} );
Form::macro ( 'checkboxField', function ($name, $value = 1, $checked = null, $attributes = array()) {
	return checkBox ( $name, $displayName, $value, $checked, $attributes );
} );
Form::macro ( 'radioField', function ($name, $displayName, $value = 1, $checked = null, $attributes = array()) {
	return radio ( $name, $displayName, $value, $checked, $attributes );
} );
/**
 * Helper function to handle tabulating radios and checkbox
 *
 * @param int $rows
 *        	- number of rows (horizontal) in array
 * @param int $columns
 *        	- number of columns (vertical) in array
 * @param array $options
 *        	- options array entered by the user for this set of radios/checkboxes
 * @param string $type
 *        	- checkbox or radio.. default to checkbox
 * @return \stdClass - return an stdclass object with fields error, field and html
 */
if (! function_exists ( 'renderTabular' )) {
	function renderTabular($rows, $cols, $options, $type = "checkbox") {
		$grp = '<table class="table table-condensed">';
		$offset = 0;
		$retObj = new \stdClass ();
		$retObj->error = '';
		$retObj->field = '';
		for($r = 0; $r < $rows; $r ++) {
			$grp .= "<tr>";
			for($c = 0; $c < $cols; $c ++) {
				$offset = $r * $cols + $c;
				if (isset ( $options [$offset] )) {
					$grp .= "<td>";
					if ($type == 'checkbox') {
						$grp .= checkbox ( $options [$offset] ['name'], $options [$offset] ['display'], $options [$offset] ['value'], $options [$offset] ['checked'], $options [$offset] ['attribs'] = array () );
						if (fieldError ( $options [$offset] ['name'] )) {

							$retObj->error = 'has-error';
							$retObj->field = $options [$offset] ['name'];
						}
					} else if ($type == 'radio') {
						$retObj->field = $options [$offset] ['name'];
						$grp .= radio ( $options [$offset] ['name'], $options [$offset] ['display'], $options [$offset] ['value'], $options [$offset] ['checked'], $options [$offset] ['attribs'] = array () );
					}
					$grp .= "</td>";
				} else {
					// empty cell to maintain symmetry
					$grp .= "<td>&nbsp;</td>";
				}
			}
			$grp .= '</tr>';
		}
		$grp .= '</table>';
		$retObj->html = $grp;

		return $retObj;
	}
}

/**
 * render a linear scale using radio buttons
 * the data array must contain the following keys
 * leftAnchor : text to be displayed on left
 * rightAnchor: text to be displayed on right
 * count : the number of radio buttons to be displayed
 * name : the name of the control
 * The default order is descending.. passing in 'asc' as the second parameter
 * displays radios in ascending order
 */
Form::macro ( 'radioScale', function ($data, $value = 0, $order = 'desc') {
	$leftAnchor = $data ['leftAnchor'];
	$rightAnchor = $data ['rightAnchor'];
	$count = $data ['count'];
	$name = $data ['name'];
	// generate the scale class='.fieldError($name).
	$str = '<div class="row">
        <div class="col-xs-1"><h4><span class="label label-success">' . $leftAnchor . '</span></h4></div>
        <div class="col-xs-3">';
	if ($order == 'desc') {
		for($index = $count; $index >= 1; $index --) {
			$str .= radio ( $name, $index, $index, $index == $value ? true : false );
		}
	} else if ($order = 'asc') {
		for($index = 1; $index <= $count; $index ++) {
			$str .= radio ( $name, $index, $index, $index == $value ? true : false );
		}
	}
	$str .= '</div>
    <div class="col-xs-1"><h4><span class="label label-success">' . $rightAnchor . '</span></h4></div>
    </div>' . errorMessage ( $name );
	return $str;
} );


/**
 * Return the html to render an individual radio control
 *
 * @param string $name
 *        	- name of the radio
 * @param string $displayName
 *        	- display name of the radio
 * @param string $value
 *        	- value of control if selected
 * @param string $checked
 *        	- is the radio selected?
 * @param array $attributes
 *        	- other attributes (class, id etc)
 * @return string - The html rendering of the radio control
 */
if (! function_exists ( 'radio' )) {
	function radio($name, $displayName, $value, $checked = null, $attributes = array()) {
		$out = '';
		$attributes = array_merge ( array (
				'id' => 'id-field-' . $name.'-'.$displayName
		), $attributes );
		$out .= '<label for="' . 'id-field-' . $name.'-'.$displayName . '" class="radio-inline">';
		$out .= Form::radio ( $name, $value, $checked, $attributes ) . ' ' . $displayName;
		$out .= '</label>';
		return $out;
	}
}

/**
 * Return the html to render an individual checkbox control
 *
 * @param string $name
 *        	- Name of the checkbox
 * @param string $displayName
 *        	- Display name of the checkbox
 * @param string $value
 *        	- Value if control is checked
 * @param string $checked
 *        	- Is the checkbox checked by default
 * @param array $attributes
 *        	- other attributes (class, id etc)
 * @return string - html rendering of the checkbox control. Note that
 *         it includes a hidden field. This simplifies form processing when checkbox is unchecked
 */
if (! function_exists ( 'checkBox' )) {
	function checkBox($name, $displayName, $value = 1, $checked = null, $attributes = array()) {
		$out = '';
		$attributes = array_merge ( array (
				'id' => 'id-field-' . $name
		), $attributes );
		$out .= '<label for="' . 'id-field-' . $name . '" class="checkbox-inline">';
		$out .= '<input type="hidden" name="' . $name . '" value="0" />'; // spl handling for checkbox that is not checked
		                                                                  // $out .= Form::hidden($name, 0); //note that this does NOT work well!
		$out .= Form::checkbox ( $name, $value, $checked, $attributes ) . ' ' . $displayName;
		$out .= '</label>';

		return $out;
	}
}
/**
 * Wrap an element with twitter bootstrap 3.0 specific code for proper rendering
 *
 * @param string $field
 *        	- field name
 * @param string $element
 *        	- html rendering of internal form element to be output
 * @param string $label
 *        	- label that is displayed to the left
 * @return string - formatted html with all divs etc for final display on screen
 */
if (! function_exists ( 'fieldWrapper' )) {
	function fieldWrapper($field, $element, $label = null) {
		$out = '<div class="form-group';
		$out .= fieldError ( $field ) . '">'; // set error class
		$out .= fieldLabel ( $field, $label ); // gen label
		$out .= '<div class="col-sm-9">';
		$out .= $element;
		$out .= errorMessage ( $field ); // display error message
		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}
}
/**
 * return formatted error message associated with a field
 *
 * @param string $field
 *        	- name of the field to be checked for errors
 * @return string - TBS 3.0 formatted span tag that is to be displayed alongside the field
 */
if (! function_exists ( 'errorMessage' )) {
	function errorMessage($field) {
		if ($errors = Session::get ( 'errors' )) {
			return '<span class="label label-danger">' . $errors->first ( $field ) . '</span>';
		}
	}
}
/**
 * Return string 'has-error' that can be tagged to element div to signal erroneous entry
 *
 * @param string $field
 *        	- the field name
 * @return string - 'has-error' in case the field has a validation error
 */
if (! function_exists ( 'fieldError' )) {
	function fieldError($field) {
		$error = '';
		if ($errors = Session::get ( 'errors' )) {
			$error = $errors->first ( $field ) ? ' has-error' : '';
		}
		return $error;
	}
}
/**
 * html required for displaying the field label.
 * In case an explicit label is not passed,
 * generate one
 *
 * @param unknown $name
 *        	- field name
 * @param unknown $label
 *        	- label to be used
 * @return string - html for the label (TBS 3.0 formatted)
 */
if (! function_exists ( 'fieldLabel' )) {
	function fieldLabel($name, $label) {
		$out = '<label for="' . 'id-field-' . $name . '" class="control-label col-sm-3">';
		if ($label === null) {
			// remove _id, [].. replace _ and - with space.
			$out .= ucfirst ( str_replace ( array (
					'_',
					'-'
			), ' ', str_replace ( array (
					'_id',
					'[]'
			), '', $name ) ) );
		} else {
			$out .= $label;
		}
		$out .= '</label>';
		return $out;
	}
}
/**
 * helper function to add required classes (TBS 3.0) for "text input" fields
 *
 * @param string $name
 *        	- field name
 * @param array $attributes
 *        	- control attribs passed by user
 * @return array - attributes array merged with TBS specific classes
 */
if (! function_exists ( 'fieldAttributes' )) {
	function fieldAttributes($name, $attributes = array()) {
		return array_merge ( array (
				'class' => 'form-control',
				'id' => 'id-field-' . $name
		), $attributes );
	}
}
