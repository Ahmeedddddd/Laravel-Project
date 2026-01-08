@php
    /** @var \App\Models\ContactMessage $message */
@endphp

<p>Hallo {{ $message->name }},</p>

<p>We hebben een antwoord op je contactbericht.</p>

<p><strong>Onderwerp:</strong> {{ $message->subject }}</p>

<hr>
<p><strong>Jouw bericht:</strong></p>
<p style="white-space: pre-wrap;">{{ $message->message }}</p>

<hr>
<p><strong>Antwoord van admin:</strong></p>
<p style="white-space: pre-wrap;">{{ $message->admin_reply }}</p>

<p style="margin-top: 24px;">
    Je kan dit ook bekijken in je account: {{ url('/account/messages') }}
</p>

