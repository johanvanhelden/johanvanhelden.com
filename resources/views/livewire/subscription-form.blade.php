<div>
    <h2 class="text-4xl text-center font-bold mb-6">{{ $subscriber->name }}</h2>

    <p class="content text-center mb-6">
        Here you can either edit your subscription information or unsubscribe.
    </p>

    <form wire:submit.prevent="update">
        <div class="mb-4">
            <label for="name" class="input-label">{{ __('subscriber.attributes.name') }}</label>
            <input
                wire:model.defer="subscriber.name"
                id="name"
                name="name"
                type="text"
                class="input"
                placeholder="Enter your name"
                required
            >
            @include('components.forms.shared.invalid-feedback', ['name' => 'subscriber.name'])
        </div>
        <div class="mb-4">
            <label for="email" class="input-label">{{ __('subscriber.attributes.email') }}</label>
            <input
                wire:model.defer="subscriber.email"
                id="email"
                name="email"
                type="email"
                class="input"
                placeholder="Enter your email"
            >
            @include('components.forms.shared.invalid-feedback', ['name' => 'subscriber.email'])
        </div>
        <div class="mb-4">
            <button type="submit" class="w-full button button--primary">
                Save
            </button>
        </div>
    </form>

    <hr class="mb-4">

    <div class="mb-4">
        <button type="button" class="button text-xs" wire:click="unsubscribe">
            Unsubscribe
        </button>
    </div>
</div>
