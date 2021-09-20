@php
  $filterFormId = 'filterForm' . mt_rand();
@endphp
<form action="{{ route($route) }}" class="form-inline" id="{{ $filterFormId }}">

    @foreach($widgets as $widget)
        {!! $widget->render() !!}</span>
    @endforeach
    &nbsp;
    <button class="btn btn-sm btn-primary" type="submit">{{ __('Filter') }}</button>
</form>
@once
    @push('onload-scripts')
        /* Removes unused fields from query string */
        function submitAppShellFilter(event) {
            event.preventDefault();
            const form = event.target;
            let url = new URL(form.action);
            Array.from(form.elements).forEach((field) => {
                if ('' != field.name && '' != field.value) {
                    if ("selectedOptions" in field && field.selectedOptions.length > 1) {
                        Array.from(field.selectedOptions).forEach((option) => {
                            url.searchParams.append(field.name, option.value);
                        });
                    } else {
                        url.searchParams.append(field.name, field.value);
                    }
                }
            });

            window.location = url.toString();
        }
    @endpush
@endonce
@push('onload-scripts')
  document.getElementById("{{ $filterFormId }}").addEventListener("submit", submitAppShellFilter);
@endpush
