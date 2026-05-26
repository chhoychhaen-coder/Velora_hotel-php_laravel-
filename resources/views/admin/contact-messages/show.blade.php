@extends('layouts.admin')

@section('title', 'Contact Message Detail')
@section('page_title', 'Contact Message Detail')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Contact Message #{{ $contactMessage->id }}</h1>
            <p class="mt-1 text-sm text-gray-500">Submitted {{ $contactMessage->created_at->format('Y-m-d H:i') }}</p>
        </div>

        <a href="{{ route('admin.contact-messages.index') }}"
           class="rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
            Back
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg bg-white p-6 shadow-md lg:col-span-1">
            <h2 class="mb-4 text-lg font-bold text-gray-800">Sender</h2>

            <div class="space-y-4 text-sm">
                <div>
                    <p class="mb-1 font-semibold uppercase text-gray-400">Name</p>
                    <p class="text-gray-900">{{ $contactMessage->name }}</p>
                </div>

                <div>
                    <p class="mb-1 font-semibold uppercase text-gray-400">Email</p>
                    <a href="mailto:{{ $contactMessage->email }}" class="text-blue-600 hover:text-blue-800">
                        {{ $contactMessage->email }}
                    </a>
                </div>

                <div>
                    <p class="mb-1 font-semibold uppercase text-gray-400">Status</p>
                    @if($contactMessage->is_read)
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Read</span>
                    @else
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Unread</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-md lg:col-span-2">
            <div class="mb-5">
                <p class="mb-1 text-xs font-semibold uppercase text-gray-400">Subject</p>
                <h2 class="text-2xl font-bold text-gray-900">{{ $contactMessage->subject ?: 'No subject' }}</h2>
            </div>

            <div>
                <p class="mb-2 text-xs font-semibold uppercase text-gray-400">Message</p>
                <div class="whitespace-pre-line rounded-lg border border-gray-200 bg-gray-50 p-5 text-gray-800">
                    {{ $contactMessage->message }}
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">




                <form method="POST"
                      action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                      onsubmit="return confirm('Delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
