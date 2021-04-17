@if($invitation->isExpired())
    <div class="alert alert-warning">
        {{ __('This invitation has expired and no longer can be used.') }}
    </div>
@elseif($invitation->hasBeenUtilizedAlready())
    <div class="alert alert-info">
        {{ __('This invitation has been utilized already') }}
    </div>
@else
    <div class="alert alert-danger">
        {{ __('This invitation is invalid') }}
    </div>
@endif
