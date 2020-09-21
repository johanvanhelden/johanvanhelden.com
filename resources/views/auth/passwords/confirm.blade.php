<x-app.auth :page-title="__('page-auth.password_confirm.page_title')">
    <h3 class="text-lg | mb-2">{{ __('page-auth.password_confirm.headings.form') }}</h3>

    <hr class="mb-4">

    <x-form :action="route('password.confirm')">
        <x-forms.inputs.input type="password" name="password" :label="__('user.attributes.password')" required autofocus />

        <div class="flex items-center justify-between">
            <button type="submit" class="button button--primary" form="confirm">
                {{ __('action.confirm') }}
            </button>
        </div>
    </x-form>
</x-app.auth>
