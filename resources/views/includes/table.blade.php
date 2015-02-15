<table class="{{ $class or 'table' }}">
    <thead>
        <tr>
            @foreach($header as $h)
            <th>
                <span></span>
                {{ HTML::icon($h->getSortIcon()) }}
            </th>
            @endforeach
        </tr>
    </thead>
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
