@if ($address->city){{ $address->city }}@endif
@if ($address->postalcode) ({{ $address->postalcode }})@endif
@if ($address->city || $address->postalcode),@endif

{{ $address->address }}
