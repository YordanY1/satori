<span x-data="{ bump: false }" x-on:cart-updated.window="bump=true; setTimeout(()=>bump=false, 200);"
    :class="bump ? 'scale-110' : ''"
    class="inline-flex items-center justify-center min-w-[1.25rem] h-5
           rounded-full bg-accent text-black text-xs font-bold px-1 transition-transform">
    {{ $count }}
</span>
