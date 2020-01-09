@foreach (session('flash_notification', collect())->toArray() as $index => $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <article class="message is-{{ $message['level'] }} | js-delete-message-{{ $index }}">
            @if ($message['important'])
                <div class="message-header">
                    <p></p>
                    <button class="delete | js-delete" data-target="js-delete-message-{{ $index }}" aria-label="delete"></button>
                </div>
            @endif
            <div class="message-body">
                {!! $message['message'] !!}
            </div>
        </article>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
