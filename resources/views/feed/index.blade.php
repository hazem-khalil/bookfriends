<x-layouts.app>
    <x-slot name="header">
        Feed
    </x-slot>

    <div class="mt-8 space-y-6">
        @foreach ($books as $book)
            <div class="space-y-2">
                <div>{{ $book->user->name }} {{ $book->book_user->action }} {{ $book->title }}</div>
                <x-book :book="$book" />
            </div>
        @endforeach
    </div>
</x-layouts.app>
