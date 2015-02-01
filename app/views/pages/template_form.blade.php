<?php 
$template = $selected_template;

if(count($template->fillable) > 0)
{
	$new_fillable = array();
	foreach($template->fillable as $k => $v)
	{
		// if a simple string was passed
		if(is_string($v))
		{
			$v = (object) array('name' => $k, 'type' => $v);
		}

		if(!isset($v->name))
		{
			$v->name = $k;
		}

		$new_fillable[$k] = $v;
	}

	$template->fillable = (object) $new_fillable;
}

$totals = Input::old('current_totals');

foreach($selected_template->fillable as & $v)
{
	$v->show_items =
		isset($page) && 
		$page->exists() && 
		$page->contents->{$v->name}
		? 
			count($page->contents->{$v->name})
		:
			(isset($totals[$v->name]) ? $totals[$v->name] : 1);
}



?>
{{ Form::hidden('template', $selected_template->key) }}

@foreach($selected_template->fillable as $fillable)
	{{ Form::hidden('current_totals[' . $fillable->name . ']', $fillable->show_items) }}
	@include('pages.template_fillable_form', array(
		'fillable' => $fillable,
		'items' => $fillable->show_items,
	))
@endforeach
