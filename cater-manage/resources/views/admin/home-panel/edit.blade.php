@extends('layouts.home-panel-layout') 

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Section</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.home-panel.update', $HomePageContents->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Form Fields for Editing -->
            @if($HomePageContents->title)
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $HomePageContents->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
            @endif

            @if($HomePageContents->heading)
            <div class="mb-4">
                <label for="heading" class="block text-sm font-medium text-gray-700">Heading</label>
                <input type="text" name="heading" id="heading" value="{{ old('heading', $HomePageContents->heading) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            </div>
            @endif

            @if($HomePageContents->description)
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $HomePageContents->description) }}</textarea>
            </div>
            @endif

            @if($HomePageContents->image)
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    <div>
                        <img src="{{ asset('images/' . $HomePageContents->image) }}" alt="Image Preview"  style="width: 150px; height: auto;" class="max-w-xs h-auto rounded-md" />
                    </div>
            </div>
            @endif

            @if($HomePageContents->background_color)
            <div class="mb-4">
                <label for="background_color" class="block text-sm font-medium text-gray-700">Background Color</label>
                <input type="color" name="background_color" id="background_color" value="{{ old('background_color', $HomePageContents->background_color) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                {{-- <div style="width: 30px; height: 30px; background-color: {{ $HomePageContents->background_color }}; border: 1px solid #ddd;" title="{{ $HomePageContents->background_color }}" ></div> --}}
            </div>
            @endif


            @if($HomePageContents->text_color)
            <div class="mb-4">
                <label for="text_color" class="block text-sm font-medium text-gray-700">Text Color</label>
                <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $HomePageContents->text_color) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                {{-- <div style="width: 30px; height: 30px; background-color: {{ $HomePageContents->text_color }}; border: 1px solid #ddd;" title="{{ $HomePageContents->text_color }}"></div> --}}
            </div>
            @endif

            @if($HomePageContents->button_text_1_color)
            <div class="mb-4">
                <label for="button_text_1_color" class="block text-sm font-medium text-gray-700">Button 1 Text Color</label>
                <input type="color" name="button_text_1_color" id="button_text_1_color" value="{{ old('button_text_1_color', $HomePageContents->button_text_1_color) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                {{-- <div style="width: 30px; height: 30px; background-color: {{ $HomePageContents->button_text_1_color }}; border: 1px solid #ddd; " title="{{ $HomePageContents->button_text_1_color }}"></div> --}}
            </div>
            @endif

            
            @if($HomePageContents->button_color_1)
            <div class="mb-4">
                <label for="button_color_1" class="block text-sm font-medium text-gray-700">Button 1 Color</label>
                <input type="color" name="button_color_1" id="button_color_1" value="{{ old('button_color_1', $HomePageContents->button_color_1) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                {{-- <div style="width: 30px; height: 30px; background-color: {{ $HomePageContents->button_color_1 }}; border: 1px solid #ddd;" title="{{ $HomePageContents->button_color_1 }}"></div> --}}
            </div>
            @endif

            @if($HomePageContents->button_text_2_color)
            <div class="mb-4">
                <label for="button_text_2_color" class="block text-sm font-medium text-gray-700">Button 2 Text Color</label>
                <input type="color" name="button_text_2_color" id="button_text_2_color" value="{{ old('button_text_2_color', $HomePageContents->button_text_2_color) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                {{-- <div style="width: 30px; height: 30px; background-color: {{ $HomePageContents->button_text_2_color }}; border: 1px solid #ddd;" title="{{ $HomePageContents->button_text_2_color }}"></div> --}}
            </div>
            @endif

            @if($HomePageContents->button_color_2)
            <div class="mb-4">
                <label for="button_color_2" class="block text-sm font-medium text-gray-700">Button 2 Color</label>
                <input type="color" name="button_color_2" id="button_color_2" value="{{ old('button_color_2', $HomePageContents->button_color_2) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                {{-- <div style="width: 30px; height: 30px; background-color: {{ $HomePageContents->button_color_2 }}; border: 1px solid #ddd;" title="{{ $HomePageContents->button_color_2 }}"></div> --}}
            </div>
            @endif

            <div class="mb-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update Section</button>
            </div>
        </form>

        <a href="{{ route('admin.home-panel.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded-md">Back to Home Panel</a>
    </div>
@endsection