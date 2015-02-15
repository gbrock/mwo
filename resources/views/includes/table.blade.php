<table class="table {{ $class or '' }}">
    @if(count($headers))
    <thead>
        <tr>
            @foreach($headers as $h)
            <th>
                @if($h->sortable)
                <a href="{{ $h->sort_link }}">
                    <span>{{ $h->label }}</span>
                    {{ HTML::icon($h->sort_icon) }}
                </a>
                @endif
            </th>
            @endforeach
        </tr>
    </thead>
    @endif
    <tbody>
        @foreach($rows as $r)
        <tr>
            @foreach($r->fields as $f)
            <td{{ $f->class ? ' class="' . $f->class . '"' : '' }}>
                {{ $f->content }}
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
    @if(isset($footer) && $footer)
    <tfoot>
        <tr>
            <td colspan="{{ count($header) }}">
                {{ $footer }}
            </td>
        </tr>
    </tfoot>
    @endif
</table>
