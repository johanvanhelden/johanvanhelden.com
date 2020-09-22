<x-app.auth :page-title="__('page-auth.set.page_title')">
    <h3 class="text-lg | mb-2">{{ __('page-auth.set.headings.form') }}</h3>

    <hr class="mb-4">

    <x-form :action="route('password-set.post')">
        <x-forms.inputs.input type="hidden" name="token" :value="$token" />

        <x-forms.inputs.input type="email" name="email" :value="$email" :label="__('user.attributes.email')" required />

        <x-forms.inputs.input type="password" name="password" :label="__('user.attributes.password')" required autofocus autocomplete="new-password" />
        <x-forms.inputs.input type="password" name="password_confirmation" :label="__('user.attributes.password_confirmation')" required autocomplete="new-password" />

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary">
                {{ __('action.set_password') }}
            </button>

            <a href="{{ route('login') }}" class="link link--primary">
                {{ __('action.login') }}
            </a>
        </div>
    </x-form>
</x-app.auth>
