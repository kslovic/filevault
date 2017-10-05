@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchdiv">
            <label for="term">Search:<br><input id="term" onclick="resize()" onkeyup="delaysearch(this.value)" name="term" placeholder=" search asset . . ."/></label>
    </div>
    <div class="uploaddiv">
        <form id="upload" action="/upload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <label class="lupload btn btn-primary" for="file">Upload digital assets ( max 25MB ):<br><input class="upload btn btn-primary" type="file"  id="file" name="upload" /></label><br>
            <label id="lpublic" for="public">Public:<input id="public" name="public" type="checkbox"/></label>
            <button class="btn btn-primary" id="upsubmit" name="upsubmit" >Upload</button>
        </form>
    </div>
        @if (count($asset) > 0)
        <section class="assets">
            @include('assets')
        </section>
        @endif
</div>

@endsection