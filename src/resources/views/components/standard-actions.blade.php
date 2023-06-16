@can($deletePermission)
    {!! Form::open([
            'url' => $deleteUrl,
            'method' => 'DELETE',
            'class' => 'd-inline',
            'data-confirmation-text' => $deleteConfirmationText
        ])
    !!}
    <x-appshell::button variant="outline-danger" :title="$deleteButtonTitle" icon="delete" size="sm" />
    {!! Form::close() !!}
@endcan

@can($editPermission)
    <x-appshell::button href="{{ $editUrl }}" variant="outline-secondary" size="sm">{{ $editButtonText }}</x-appshell::button>
@endcan
