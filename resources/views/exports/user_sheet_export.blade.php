<table>
    <thead>
        <tr>
            <th>Id (user_id)</th>
            <th>User Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->fullname }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
