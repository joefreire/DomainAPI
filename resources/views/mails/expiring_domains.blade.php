<h3>Hello,</h3>
<p>This is an email alert about domains are expiring in next {{ $days }} days.</p>
<ul>
    @foreach ($domains as $domain)
        <li> {{ $domain->full_domain }} - {{ $domain->expiration_at }} </li>
    @endforeach
</ul>
