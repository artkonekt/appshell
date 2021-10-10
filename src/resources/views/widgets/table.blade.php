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
                    <td{!! $column->tdAttributes() !!}@if($column->hasInlineStyle())style="{{ $column->inlineStyle() }}"@endif>{!! $column->render($line) !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
    @if($table->hasFooter())
        <tfoot>
        @foreach($table->footer as $footerColumn)
            <td{!! $footerColumn->tdAttributes() !!}@if($footerColumn->hasInlineStyle())style="{{ $footerColumn->inlineStyle() }}"@endif>{!! $footerColumn->render($table->data) !!}</td>
        @endforeach
        </tfoot>
    @endif
</table>
@endif
