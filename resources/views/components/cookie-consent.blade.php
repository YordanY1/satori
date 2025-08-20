<div x-data="cookieConsent()" x-init="init()">
    {{-- Banner --}}
    <div x-show="!consented" x-cloak class="fixed inset-x-0 bottom-0 z-[9999]">
        <div class="mx-auto max-w-5xl m-4 rounded-2xl border bg-white shadow-lg p-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="text-sm leading-6 flex-1">
                    {{ __('cookies.banner_text') }}
                    <a href="{{ route('cookies') }}" class="underline">{{ __('cookies.learn_more') }}</a>.
                </div>

                <div class="flex gap-2">
                    <button @click="declineAll()"
                        class="rounded-xl border px-4 py-2 text-sm hover:bg-neutral-50 cursor-pointer">
                        {{ __('cookies.decline') }}
                    </button>
                    <button @click="acceptAll()"
                        class="rounded-xl bg-black text-white px-4 py-2 text-sm hover:bg-black/90 cursor-pointer">
                        {{ __('cookies.accept') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cookieConsent() {
        const KEY = 'cookie_prefs_v1';

        function getCookie(name) {
            const m = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
            return m ? decodeURIComponent(m.pop()) : null;
        }

        function setCookie(name, val, days = 365) {
            const d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${encodeURIComponent(val)}; expires=${d.toUTCString()}; path=/; SameSite=Lax`;
        }

        return {
            consented: false,

            init() {
                const raw = getCookie(KEY) || localStorage.getItem(KEY);
                if (!raw) return;

                try {
                    const data = JSON.parse(raw);
                    this.consented = typeof data === 'object';
                    this.apply(data);
                } catch (_) {}
            },

            acceptAll() {
                const prefs = {
                    analytics: true,
                    marketing: true
                };
                const json = JSON.stringify(prefs);
                localStorage.setItem(KEY, json);
                setCookie(KEY, json, 365);
                this.consented = true;
                this.apply(prefs);
            },

            declineAll() {
                const prefs = {
                    analytics: false,
                    marketing: false
                };
                const json = JSON.stringify(prefs);
                localStorage.setItem(KEY, json);
                setCookie(KEY, json, 365);
                this.consented = true;
                this.apply(prefs);
            },

            apply(prefs) {
                if (prefs?.analytics && !window.__gaLoaded) {
                    window.__gaLoaded = true;
                    // ЗАМЕНИ G-XXXXXXX ако ще ползваш GA4
                    // const s1 = document.createElement('script');
                    // s1.async = true;
                    // s1.src = 'https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX';
                    // document.head.appendChild(s1);
                    // const s2 = document.createElement('script');
                    // s2.innerHTML = `
                    //   window.dataLayer = window.dataLayer || [];
                    //   function gtag(){dataLayer.push(arguments);}
                    //   gtag('js', new Date());
                    //   gtag('config', 'G-XXXXXXX', { anonymize_ip: true });
                    // `;
                    // document.head.appendChild(s2);
                }

                if (prefs?.marketing && !window.__fbqLoaded) {
                    window.__fbqLoaded = true;
                    // ЗАМЕНИ 1234567890 ако ще ползваш Pixel
                    // !(function(f,b,e,v,n,t,s){
                    //   if(f.fbq) return; n=f.fbq=function(){n.callMethod?
                    //   n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    //   if(!f._fbq) f._fbq=n; n.push=n; n.loaded=!0; n.version='2.0';
                    //   n.queue=[]; t=b.createElement(e); t.async=!0;
                    //   t.src=v; s=b.getElementsByTagName(e)[0];
                    //   s.parentNode.insertBefore(t,s)
                    // })(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
                    // fbq('init', '1234567890'); fbq('track', 'PageView');
                }
            }
        }
    }
</script>
