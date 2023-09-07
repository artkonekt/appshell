@if($table->data->isEmpty() && $table->rendersAlternativeForEmptyDataset())
    <table class="table rounded-1">
        <tbody>
            <tr>
                <td class="text-center">{{ $table->options['empty']['text'] }}</td>
            </tr>
        </tbody>
    </table>
@else
<table @class(['table rounded-1', 'table-striped' => isset($table->options['striped']), 'table-hover' => isset($table->options['hover'])])>
    @unless($table->headerIsHidden())
    <thead>
        <tr>
        @foreach($table->columns as $column)
            @unless($column->isHidden())
            <th @isset($column->width)style="width: {{ $column->width }};"@endisset>{!! $column->title !!}</th>
            @endunless
        @endforeach
        </tr>
    </thead>
    @endunless
    <tbody>
        @foreach($table->data as $line)
            <tr>
                @foreach($table->columns as $column)
                    @unless($column->isHidden())
                    <td{!! $column->tdAttributes() !!}@if($column->hasInlineStyle()) style="{{ $column->inlineStyle() }}"@endif>{!! $column->render($line) !!}</td>
                    @endunless
                @endforeach
            </tr>
        @endforeach
    </tbody>
    @if($table->hasFooter())
        <tfoot>
        @foreach($table->footer as $footerColumn)
            <td{!! $footerColumn->tdAttributes() !!}@if($footerColumn->hasInlineStyle()) style="{{ $footerColumn->inlineStyle() }}"@endif>{!! $footerColumn->render($table->data) !!}</td>
        @endforeach
        </tfoot>
    @endif
</table>
@endif
