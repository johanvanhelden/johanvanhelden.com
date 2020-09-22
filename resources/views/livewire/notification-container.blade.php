<div>
    @foreach ($messages as $message)
        <livewire:notification
            :key="'notification-' . $message['uuid']"
            :uuid="$message['uuid']"
            :type="$message['type']"
            :title="$message['title']"
            :description="$message['description']"
        />
    @endforeach
</div>
