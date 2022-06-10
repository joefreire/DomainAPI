<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Domain</th>
        <th>Owner</th>
        <th>Nameservers</th>
        <th>Registrar</th>
        <th>Created At</th>
        <th>Expired At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($domains as $domain)
        <tr>
            <td>{{ $domain->id }}</td>
            <td>{{ $domain->full_domain }}</td>
            <td>{{ $domain->owner }}</td>
            <td>{{ implode('|', $domain->nameservers->pluck('nameserver')->toArray() )}}</td>
            <td>{{ $domain->registrar->name ?? '' }}</td>
            <td>{{ $domain->created_at }}</td>
            <td>{{ $domain->expiration_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>