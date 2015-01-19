@include('forms.input', array(
	'name' => 'url',
	'prefix' => HTML::icon('link'),
	'form_group_class' => 'negate-margin-bottom',
	'suffix_btn' => isset($suffix_btn) ? $suffix_btn : FALSE,
	'label' => FALSE,
	'value' => $link->exists() ? $link->url : FALSE,
))
