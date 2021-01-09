<table class="table">
    <thead>
        <tr>
        @foreach($table->columns as $column)
            <th>{!! $column->title !!}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($table->data as $line)
            <tr>
                @foreach($table->columns as $column)
                    <td>{!! $column->render($line) !!}</td>
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
