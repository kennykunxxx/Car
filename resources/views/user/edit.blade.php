@extends ('layouts.base')

@section ('contents')

<form action="{{ route('user.update', [$user->id]) }}" method='post' enctype="multipart/form-data"> 

@method('put')
@csrf

<label for="name">Name</label>
<input type="text" name='name' id='name' value="{{ $user->name }}">

<label for="email">Email</label>
<input type="text" name='email' id='email'value="{{ $user->email }}">

<label for="age">age</label>
<input type="number" name='age' id='age' value="{{ $user->age }}">

<label for="image">Image</label>
<input type="file" name='image' id='image'>

<input type="submit" value='Update'>

</form>

<h3>Current Image</h3>

<img src="{{ $user->getFirstMediaUrl('user', 'thumb') }} " alt="">
@stop
