<nav class="navbar {{ $class or 'navbar-default navbar-static-top' }}">
    <div class="container{{ !isset($fluid) || $fluid ? '-fluid' : '' }}">

        @if((isset($collapse) && $collapse) || (isset($brand) && $brand))
        <div class="navbar-header">
            @if(isset($collapse) && $collapse)
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">{{ Lang::get('site.toggle_navigation') }}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            @endif

            @if(isset($brand) && $brand)
                <a class="navbar-brand" href="{{ url() }}">{{ $brand }}</a>
            @endif
        </div>
        @endif

        {!! $content or '' !!}

        @if(isset($collapse) && $collapse)
            <div class="collapse navbar-collapse">
               {{ $collapse or '' }}
            </div>
        @endif
    </div>
</nav>
