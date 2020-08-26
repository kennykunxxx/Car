@extends ('layouts.base')

@section ('contents')


<form action="{{ route('car.update', [$car->id]) }}" method='post' enctype="multipart/form-data"> 

@method('put')
@csrf

<label for="make">Make</label>
<input type="text" name='make' value='{{ $car->make }}'>

<label for="model">Model</label>
<input type="text" name='model' value='{{ $car->model }}'>

<label for="registration">Registration</label>
<input type="text" name='registration' value='{{ $car->registration }}'>

<label for="color">color</label>
<input type="text" name='color' value='{{ $car->color }}'>

<label for="image">Image</label>
<input type="file" id='image' name='image'>
@if($car->getMedia('images')->first())
<h5> current image </h5> <img src="{{ $car->getMedia('images')->first()->getUrl('thumb')}}" alt="">
@else
<h5>No image</h5>
@endif
<input type="submit" value='submit'>

</form>

<form action="{{ route('car.photo_delete', [$car->id]) }}" method='post'>
    @csrf
    @method('DELETE')
    <input type="submit" value='delete photo'>
</form>



@stop