<div class="modal" tabindex="-1" id="appshell-search-modal" aria-labelledby="appshell-search-modal-title" aria-hidden="true">
    <form class="modal-dialog modal-lg modal-dialog-centered" action="{{ route($appshell->routes['search']) }}"
          method="{{ Route::getRoutes()->getByName($appshell->routes['search'])->methods[0] ?? 'POST' }}"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appshell-search-modal-title">{{ __('Search') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input name="q" id="appshell-search-modal-input" type="text" class="form-control form-control-lg" placeholder="{{ __('Type and hit ENTER') }}">
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Search') }}</button>
            </div>
        </div>
    </form>
</div>
@once
    @push('onload-scripts')
        $('#appshell-search-modal').on('shown.bs.modal', function () {
            $('#appshell-search-modal-input').trigger('focus');
        });

        document.addEventListener('keydown', function (event) {
            if (event.shiftKey && event.keyCode == 16) {
                var smodal = document.getElementById('appshell-search-modal');
                if (smodal.getClientRects().length === 0) { // the modal isn't visible
                    if (1 == smodal.getAttribute('data-shift-triggered')) {
                        smodal.removeAttribute('data-shift-triggered');
                        $('#appshell-search-modal').modal('show');
                    } else {
                        smodal.setAttribute('data-shift-triggered', 1);
                        setTimeout(function() {
                            document.getElementById('appshell-search-modal').removeAttribute('data-shift-triggered');
                        }, 500);
                    }
                }
            }
        });
    @endpush
@endonce
