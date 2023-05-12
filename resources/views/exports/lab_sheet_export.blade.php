<table>
    <thead>
        <tr>
            <th>Id (lab_id)</th>
            <th>Lab Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($labs as $lab)
            <tr>
                <td>{{ $lab->id }}</td>
                <td>{{ $lab->fullname }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
