<?php

namespace App\Exports;

use App\Models\Domain;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DomainExport implements FromView
{
    public function view(): View
    {
        return view('exports.domains', [
            'domains' => Domain::all()
        ]);
    }
}
