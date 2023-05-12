<table class="table table-striped" id="table-exp">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Passenger Name</th>
            <th>Passenger Email</th>
            <th>Passenger Number</th>
            <th>Passport Number</th>
            <th>Airline</th>
            <th>Flight Origin</th>
            <th>Amount Paid</th>
            <th>Time of Arrival</th>
            {{--<th>Created By</th>--}}
            <th>Date Of Arrival</th>
            <th>Payment Type</th>
            {{--<th>Action</th>--}}
        </tr>
    </thead>
    <tbody>
        @foreach ($flights as $flight)
            <tr>
                <td>{{ 1 + $loop->index }}</td>
                <td>{{ $flight->passengerName }}</td>
                <td>{{ $flight->passengerEmail }}</td>
                <td>{{ $flight->passengerPhone }}</td>
                <td>{{ $flight->passportNumber }}</td>
                <td>{{ $flight->airline }}</td>
                <td>{{ $flight->origin }}</td>
                <td>{{ number_format($flight->amount) }}</td>
                <td>{{ $flight->time }}</td>
                {{--<td>{{ $flight->user->fullname }}</td>--}}
                <td>{{ $flight->dateOfArrival->format('F j, Y') }}</td>
                <td>{{ $flight->paymentType }}</td>
                {{--<td class="btn btn-primary">Details</td>--}}
                {{-- <td><a
                        href="/flight-details/{{ $flight->uuid }}"
                        class="btn btn-primary">Detail</a></td>
                --}}
            </tr>
        @endforeach
    </tbody>
</table>