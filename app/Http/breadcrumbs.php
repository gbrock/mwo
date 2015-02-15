<?php


// Dashboard
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->push(Lang::get('site.dashboard'), action('DashboardController@getIndex'));
});

// Manage Blog
Breadcrumbs::register('blog', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('site.blog'), action('Blog\PostController@getIndex'));
});

// Manage Users
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Lang::get('site.users'), action('Auth\UserController@getIndex'));
});
