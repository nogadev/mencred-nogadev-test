<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

use DB;
use App\Traits\RestClientTrait;

class CustomerController extends Controller
{
    use RestClientTrait;

    public function findAll(Request $request)
    {
        $search    = $request->search;
        $customers = Customer::with(['route','seller','commercial_town','commercial_neighborhood'])
                        ->where('customers.name','like','%'. $search . '%')
                        ->orWhere('customers.doc_number','like','%'. $search . '%')
                        ->orWhere('customers.particular_tel','like','%'. $search . '%')
                        ->get();
        $this->post('customers', $customers, "Clientes.pdf");
    }

    public function sequence($routeId = null)
    {
        $customers = Customer::where('route_id', '=', $routeId)
            ->has('activeCredits')
            ->with(['route','seller','commercial_neighborhood','commercial_town','commerce', 'visitday'])
            ->orderBy('sequence_order')            
            ->get();

        $this->post('customers/sequences', $customers, "Secuencia.pdf");
    }

}