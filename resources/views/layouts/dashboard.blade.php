@extends('layouts.app')

@section('body')
    <div class="page-wrap">
        @include('includes.navbar', array(
            'class' => 'navbar-default navbar-static-top navbar-dashboard',
            'brand' => Lang::get('site.name'),
        ))
        <div class="container-fluid">
            <div class="row">
                <nav class="dashboard-sidebar">
                    
                </nav>
                <div class="content">
                    {!! Breadcrumbs::render(isset($breadcrumbs) ? $breadcrumbs : 'dashboard') !!}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @section('footer')
    <footer class="site-footer">
        @include('includes.navbar', array(
            'class' => 'navbar-inverse navbar-fixed-bottom',
            'content' => '<span class="navbar-left"><span class="navbar-text">MWO Blog created by gBrock</span></span>',
        ))
    </footer>
    @show

@overwrite

