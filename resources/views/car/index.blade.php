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
        <th>MOT Request</th>
        <th>Edit</th>
        <th>Delete</th>

    </tr>

    </thead>

    <tbody>
    @forelse($cars as $car)
    <tr>
        <td>{{$car->make}}</td>
        <td>{{$car->model}}</td>
        <td>{{$car->registration}}</td>
        <td>{{$car->color}}</td>
        <td> @if($car->getMedia('images')->first()) <img src="{{ $car->getMedia('images')->first()->getUrl('thumb')}}" alt="">@endif</td>
        <td>@if($car->request == 0)<a href="{{ route('car.request_date', [$car->id]) }}">Mot Request</a>
            @else <h5>MOT pending</h5> @endif</td>
        <td><a href="{{ route('car.edit', [$car->id]) }}">Edit</a></td>
        <td><form action="{{ route('car.destroy', [$car->id]) }}" method='post'>
            @method('DELETE')
            @csrf
            <input type="submit" value='delete car'>
            </form>
        </td>
    </tr>
    @empty
    @endforelse
    </tbody>

</table>


<h2>Click <a href="{{ route('car.create') }}">here</a> add a car</h2>

<script>

$(document).ready( function () {
    $('#car').DataTable();
} );

</script>



@endsection
