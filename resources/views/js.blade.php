@if(config('gdpr')['enabled'])
@php
    $gdprConfig = config('gdpr');
@endphp
<script>
    window.laravelGdpr = (function() {
        let cookieValue = {!! json_encode(Gdpr::get()) !!};
        const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';
        const types = {!! json_encode(array_keys($gdprConfig['defaults'])) !!};

        function updateCookie()
        {
            setCookie('{{ $gdprConfig['cookie_name'] }}', JSON.stringify(cookieValue), {{ $gdprConfig['cookie_lifetime'] }});
		}

        function updateCategory(type, allowed)
        {
            if(types.indexOf(type) === -1) {
                throw new Error('The given gdpr type is not defined in the config');
            }
            cookieValue[type] = !!allowed;
            updateCookie();
        }

        function setCookie(name, value, expirationInDays) {
            const date = new Date();
            date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value
                + ';expires=' + date.toUTCString()
                + ';domain=' + COOKIE_DOMAIN
                + ';path=/{{ config('session.secure') ? ';secure' : null }}'
                + '{{ config('session.same_site') ? ';samesite='.config('session.same_site') : null }}';
        }
		
        function getCookieValue()
        {
            return cookieValue;
        }

        return {
            set: updateCategory,
            get: getCookieValue
        }
    })();
</script>
@endif