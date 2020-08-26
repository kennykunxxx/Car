@extends('layouts.base')

@section('contents')



<table class="table table-bordered" id="car" width="100%" cellspacing="0">

    <thead>
    <tr>
        <th>Make</th>
        <th>Model</th>
        <th>Registration</th>
        <th>Color</th>  
        <th>Image</th>
        <th>Submit</th>
        <th>Delete Image</th>
        <th>Delete Car</th>

    </tr>

    </thead>

    <tbody>
    @forelse($cars as $car)
    <tr>
        <form action="{{ route('admin.car_update', [$car->id]) }}" method='post' enctype="multipart/form-data">
            @csrf
            @method('put')
        <td>
            <input type="text" name='make' value='{{ $car->make }}'>
        </td>
        <td>
            <input type="text" name='model' value='{{ $car->model }}'></td>
        <td>
            <input type="text" name='registration' value='{{ $car->registration }}'></td>
        <td>
            <input type="text" name='color' value='{{ $car->color }}'></td>
        <td>  @if($car->getMedia('images')->first())<img src="{{ $car->getMedia('images')->first()->getUrl('thumb')}}" alt="">
            @endif
            <p>
                <input type="file" id='image' name='image'>
            </p>            
        </td>
        <td><input type="submit"></td>
        </form>
        <td>
        <form action="{{ route('admin.car_photo_delete', [$car->id]) }}" method='post'>
            @csrf  
            @method('DELETE')
            <input type="submit" value='delete photo'>  
        </form>
        </td>
        <td><form action="{{ route('admin.car_delete', [$car->id]) }}" method='post'>
            @csrf
            @method('DELETE')
            <input type="submit" value='delete car'>        
        </form>
        </td>

    </tr>
    @empty
    @endforelse
    </tbody>

</table>

<script>

$(document).ready( function () {
    $('#car').DataTable();
} );

</script>


@stop