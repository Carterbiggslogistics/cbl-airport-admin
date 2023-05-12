<table>
    <thead>
    <tr>
        <th>Id (warehouse_id)</th>
        <th>Location</th>
        <th>Adress</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($warehouses as $warehouse)
        <tr>
            <td>{{$warehouse->id}}</td>
            <td>{{$warehouse->location}}</td>
            <td>{{$warehouse->address}}</td>
        </tr>
        @endforeach
    </tbody>
</table>