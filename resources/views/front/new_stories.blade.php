<div class="row">
    @foreach ($new_stories as $story)
        @include('front.items.story', ['story' => $story])
    @endforeach
</div>