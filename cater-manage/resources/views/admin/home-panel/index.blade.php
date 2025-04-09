@extends('layouts.home-panel-layout') 

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Home Panel</h1>

        @foreach ($HomePageContents as $content)
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Section: {{ $content->section_name }}</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Section Title -->
                    @if($content->title)
                        <div>
                            <strong class="text-gray-700">Title:</strong>
                            <p>{{ $content->title }}</p>
                        </div>
                    @endif

                    <!-- Section Heading -->
                    @if($content->heading)
                        <div>
                            <strong class="text-gray-700">Heading:</strong>
                            <p>{{ $content->heading }}</p>
                        </div>
                    @endif

                    <!-- Section Description -->
                    @if($content->description)
                        <div class="col-span-2">
                            <strong class="text-gray-700">Description:</strong>
                            <p>{{ $content->description }}</p>
                        </div>
                    @endif

                    <!-- Section Image -->
                    @if($content->image)
                        <div>
                            <strong class="text-gray-700">Background/Logo Image:</strong>
                            <img src="{{ asset('images/' . $content->image) }}" alt="Section Image" style="width: 150px; height: auto;" class="w-full h-auto rounded-md">
                        </div>
                    @endif

                    <!-- Section Background Color -->
                    @if($content->background_color)
                        <div>
                            <strong class="text-gray-700">Background Color:</strong>
                            <p>{{ $content->background_color }}</p>
                            <div style="width: 30px; height: 30px; background-color: {{ $content->background_color }}; border: 1px solid #ddd;" 
                                    title="{{ $content->background_color }}"></div>
                        </div>
                    @endif

                    <!-- Section Text Color -->
                    @if($content->text_color)
                        <div>
                            <strong class="text-gray-700">Text Color:</strong>
                            <p>{{ $content->text_color }}</p>
                            <div style="width: 30px; height: 30px; background-color: {{ $content->text_color }}; border: 1px solid #ddd;" 
                                    title="{{ $content->text_color }}"></div>
                        </div>
                    @endif

                    <!-- Button Text Color and Button Color 1 -->
                    @if($content->button_text_1_color || $content->button_color_1)
                        <div>
                            <strong class="text-gray-700">Button 1:</strong>
                            @if($content->button_text_1_color)
                                <p>Text Color: {{ $content->button_text_1_color }}</p>
                                <div style="width: 30px; height: 30px; background-color: {{ $content->button_text_1_color }}; border: 1px solid #ddd;" 
                                    title="{{ $content->button_text_1_color }}"></div>
                            @endif
                            @if($content->button_color_1)
                                <p>Button Color: {{ $content->button_color_1 }}</p>
                                <div style="width: 30px; height: 30px; background-color: {{ $content->button_color_1 }}; border: 1px solid #ddd;" 
                                    title="{{ $content->button_color_1 }}"></div>
                            @endif
                        </div>
                    @endif

                    <!-- Button Text Color and Button Color 2 -->
                    @if($content->button_text_2_color || $content->button_color_2)
                        <div>
                            <strong class="text-gray-700">Button 2:</strong>
                            @if($content->button_text_2_color)
                                <p>Text Color: {{ $content->button_text_2_color }}</p>
                                <div style="width: 30px; height: 30px; background-color: {{ $content->button_text_2_color }}; border: 1px solid #ddd;" 
                                    title="{{ $content->button_text_2_color }}"></div>
                            @endif
                            @if($content->button_color_2)
                                <p>Button Color: {{ $content->button_color_2 }}</p>
                                <div style="width: 30px; height: 30px; background-color: {{ $content->button_color_2 }}; border: 1px solid #ddd;" 
                                    title="{{ $content->button_color_2 }}"></div>
                            @endif
                        </div>
                    @endif

                    <!-- Edit Section Button -->
                    <div class="col-span-2 text-right">
                        <a href="{{ route('admin.home-panel.edit', $content->id) }}" class="text-blue-500 hover:text-blue-700">
                            Edit Section
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        
        {{ $HomePageContents->links() }}
    </div>
@endsection