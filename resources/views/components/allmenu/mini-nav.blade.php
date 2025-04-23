<div class="holder">
    <div class="items flex justify-center gap-20 py-4 my-2 bg-red-100 text-sm font-normal">

        @foreach($categories as $category)
            <a href="#">{{ $category->name }}</a>
        @endforeach
    </div>
</div>