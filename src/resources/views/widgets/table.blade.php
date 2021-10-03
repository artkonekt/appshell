<table class="table @isset($table->options['striped'])table-striped @endisset">
    <thead>
        <tr>
        @foreach($table->columns as $column)
            <th @isset($column->width)style="width: {{ $column->width }};"@endisset>{!! $column->title !!}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($table->data as $line)
            <tr>
                @foreach($table->columns as $column)
                    <td @isset($column->valign)style="vertical-align: {{ $column->valign }};"@endisset>{!! $column->render($line) !!}</td>
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
