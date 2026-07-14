<x-mail::message>
# New Contact Message

**From:** {{ $contactMessage->name }} ({{ $contactMessage->email }})

**Subject:** {{ $contactMessage->subject ?? 'No subject' }}

{{ $contactMessage->message }}

<x-mail::button :url="route('admin.messages.show', $contactMessage)">
View Message
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
