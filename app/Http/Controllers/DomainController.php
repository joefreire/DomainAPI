<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Actions\UpdateDomain;
use App\Http\Requests\StoreDomainRequest;
use App\Exports\DomainExport;
use Maatwebsite\Excel\Facades\Excel;


class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->buildResponse('success', Domain::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDomainRequest  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreDomainRequest $request)
    {
        $data = $request->parse();
        $domain = Domain::create($data);
        return $this->buildResponse('success', $domain);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Domain $domain)
    {
        return $this->buildResponse('success', $domain);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreDomainRequest  $request
     * @param  \App\Models\Domain  $domain
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(StoreDomainRequest $request, Domain $domain, UpdateDomain $action)
    {
        $data = $request->parse();
        $domain = $action->handle($domain, $data);
        return $this->buildResponse('success', $domain);
    }

    /**
     * Remove the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();
        return $this->buildResponse('success');
    }
    /**
     * Export domains.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function export()
    {
        return Excel::download(new DomainExport, 'domain.csv');
    }
}
