<div class="fixed-banner fixed-banner--bottom-left" id="cookie-consent">
    <div class="fixed-banner__content">
        {!! customSection(\Modules\Section\Enums\Type::POPUP_CONTENT, 'cookie_concent') !!}
    </div>

    <div class="fixed-banner__actions" data-action-url="{{ route('user.cookieConsent') }}">
        <button class="btn btn-outline-danger btn-sm" data-cookie-accept="0">{{ ___('label.Decline') }} </button>
        <button class="btn btn-success btn-sm" data-cookie-accept="1">{{ ___('label.Accept') }} </button>
    </div>

</div>


@push('scripts')

<script src="{{asset('frontend/js/cookie-consent.js')}}"></script>

@endpush
