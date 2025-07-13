<h2>
    {{ $title }}
</h2>

<p>
    Congrats! Your book is now live on our website.
</p>

{{-- todo: Add correct URL when front-end is implemented. --}}
<p>
    <a href="{{ url("/books/{$id}") }}">View Your Book Listing</a>
</p>
