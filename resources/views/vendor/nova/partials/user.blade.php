<dropdown-trigger class="h-9 flex items-center">
    @isset ($user->email)
        <img
            src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower($user->email)) }}?size=512"
            class="rounded-full w-8 h-8 mr-3"
            alt="User avatar"
        />
    @endisset

    <span class="text-90">
        {{ $user->name ?? $user->email ?? __('Nova User') }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <form id="logout-nova" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    <ul class="list-reset">
        <li>
            <a
                href="#"
                class="block no-underline text-90 hover:bg-30 p-3"
                onclick="event.preventDefault(); document.getElementById('logout-nova').submit();"
            >
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
