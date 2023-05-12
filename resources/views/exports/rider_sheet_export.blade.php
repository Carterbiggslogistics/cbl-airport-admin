<table>
    <thead>
        <tr>
            <th>Id (rider_id)</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Phone Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($riders as $rider)
            <tr>
                <td>{{ $rider->id }}</td>
                <td>{{ $rider->fullname }}</td>
                <td>{{ $rider->gender }}</td>
                <td>{{ $rider->phoneNumber }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
