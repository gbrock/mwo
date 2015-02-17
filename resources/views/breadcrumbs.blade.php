<?php
$breadcrumbs = !isset($breadcrumbs) ? 'dashboard' : $breadcrumbs;
$breadcrumb_args = !isset($breadcrumb_args) ? array() : $breadcrumb_args;
if(!is_array($breadcrumbs))
{
    $breadcrumbs = array_merge(array($breadcrumbs), $breadcrumb_args);
}
?>

{!! forward_static_call_array(array('Breadcrumbs', 'render'), $breadcrumbs); !!}
