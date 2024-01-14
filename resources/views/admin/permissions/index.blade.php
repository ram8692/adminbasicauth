<!-- resources/views/admin/role_permission/index.blade.php -->

<form action="{{ route('permission.store') }}" method="POST">
    @csrf

    <table>
        <thead>
            <tr>
                <th>Action</th>
                @foreach ($roles as $role)
                    <th>{{ $role->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($actions as $action)
                <tr>
                    <td>{{ $action->name }}</td>
                    @foreach ($roles as $role)
                        <td>
                            <input type="checkbox" name="actions[{{ $role->id }}][]" value="{{ $action->id }}"
                                @if($role->actions->contains($action->id)) checked @endif>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit">Save actions</button>
</form>
