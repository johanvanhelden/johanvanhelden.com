<x-app.auth :page-title="__('page-auth.login.page_title')">
    <h3 class="text-lg | mb-2">{{ __('page-auth.login.headings.form') }}</h3>

    <hr class="mb-4">

    <x-form :action="route('login')">
        <x-forms.inputs.input type="email" name="email" :label="__('user.attributes.email')" autofocus />
        <x-forms.inputs.input type="password" name="password" :label="__('user.attributes.password')" />
        <x-forms.inputs.checkbox name="remember" :label="__('page-auth.login.remember')" />

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary" dusk="login-button">
                {{ __('action.login') }}
            </button>

            <a href="{{ route('password.request') }}" class="link link--primary">
                {{ __('action.forgot_password') }}
            </a>
        </div>
    </x-form>
</x-app.auth>
