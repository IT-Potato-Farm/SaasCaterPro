@extends('layouts.default')

@section('header')
<h2>This is the header!</h2>

@include('sidemenu')
@endsection

@section('maincontent')
<h1>Home</h1>
<a href="{{ route("testpage") }}">Go to test page!</a>
        
<form action="{{ route("formsubmitted") }}" method="post">
    @csrf
    <label for="fullname">Full name: </label>
    <input type="text" id="fullname" name="fullname" placeholder="Type your full name!" required>
    <br><br>
    <label for="email">E-mail: </label>
    <input type="text" id="email" name="email" placeholder="Type your e-mail!" required>
    <br><br>
    <button type="submit">Submit</button>
        
</form>
@endsection    

@section('footer')
<h2>This is the footer!</h2>
@endsection