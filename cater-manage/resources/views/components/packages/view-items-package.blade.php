<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
    </tr>
    @foreach ($packageItems as $item)
    <tr>
        <td>{{ $item->package->name }}</td>
        <td>{{ $item->menuItem->description }}</td>
    </tr>
    @endforeach
</table>