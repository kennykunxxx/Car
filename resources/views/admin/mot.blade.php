@extends ('layouts.base')

@section('contents')

<table>

    <thead>
    <tr>
        <th>Make</th>
        <th>Model</th>
        <th>Registration</th>
        <th>Color</th>  
        <th>Image</th>
        <th>MOT Date</th>
        <th>MOT Request</th>

    </tr>

    </thead>

    <tbody>
    @forelse($cars as $car)
    <tr>
        <td>{{$car->make}}</td>
        <td>{{$car->model}}</td>
        <td>{{$car->registration}}</td>
        <td>{{$car->color}}</td>
        <td> @if($car->getMedia('images')->first())<img src="{{ $car->getMedia('images')->first()->getUrl('thumb')}}" alt="Image">@endif</td>
        <td>@if($car->request == 0)<a href="{{ route('car.request_date', [$car->id]) }}">Mot Request</a>
            @else <h5>MOT pending</h5> @endif</td>
        <td>{{$car->mot_time}}</td>
        <td><button type='submit' class='accept' value='{{$car->id}}' style='background-color:green;'>Accept</button>
            <button type='submit' class='decline' value='{{$car->id}}' style='background-color:red;'>Decline</button></td>
    </tr>
    @empty
    @endforelse
    </tbody>

</table>

<script>


$(".accept").click(function(){
    var id = $(this).val();
    var token = "{{ csrf_token() }}"
    $(this).css('background-color', 'grey');

    $.ajax({
        url:"{{ route('admin.set_mot') }}",
        method:'POST',
        data:{_token: token, name:'accept', id: id},
        
    });

});

$(".decline").click(function(){
    var id = $(this).val();
    var token = "{{ csrf_token() }}"
    $(this).css('background-color', 'grey');


    $.ajax({
        url:"{{ route('admin.set_mot') }}",
        method:'POST',
        data:{_token: token, name:'decline', id: id},
        
    });

});

</script>

@stop