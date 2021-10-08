@if($table->data->isEmpty() && $table->rendersAlternativeForEmptyDataset())
    <table class="table">
        <tbody>
            <tr>
                <td class="text-center">{{ $table->options['empty']['text'] }}</td>
            </tr>
        </tbody>
    </table>
@else
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
    @if($table->hasFooter())
        <tfoot>
        @foreach($table->columns as $column)
            @if($table->footer->hasColumn($loop->index))
            <td{!! $table->footer[$loop->index]->tdAttributes() !!}>{{ $table->footer[$loop->index]->render($table->data) }}</td>
            @endif
        @endforeach
        </tfoot>
    @endif
</table>
@endif
