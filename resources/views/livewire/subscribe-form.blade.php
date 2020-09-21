<form wire:submit.prevent="store">
    <div class="flex flex-wrap justify-center -mx-1 lg:-mx-4 mb-4">
        <div class="my-1 px-1 w-full lg:my-4 lg:px-4 lg:w-2/6">
            <input
                wire:model.defer="name"
                type="text"
                class="input"
                placeholder="Enter your name"
                required
            >
            @include('components.forms.shared.invalid-feedback', ['name' => 'name'])
        </div>
        <div class="my-1 px-1 w-full lg:my-4 lg:px-4 lg:w-2/6">
            <input
                wire:model.defer="email"
                type="email"
                class="input"
                placeholder="Enter your email"
                required
            >
            @include('components.forms.shared.invalid-feedback', ['name' => 'email'])
        </div>
        <div class="my-1 px-1 w-full lg:my-4 lg:px-4 lg:w-1/6">
            <button type="submit" class="w-full button button--primary">
                Subscribe
            </button>
        </div>
    </div>
</form>
