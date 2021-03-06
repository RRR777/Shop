<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CustomerController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->customerRepository->pushCriteria(new RequestCriteria($request));
        $customers = Customer::sortable()->paginate(15);

        $countries = Customer::distinct()->get(['country'])->pluck('country');

        if ($request) {
            $customers = Customer::filter($request)->sortable()->paginate(15);
        }

        return view('customers.index', compact('customers', 'countries'));
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create', compact('item'));
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $input = $request->all();

        $customer = $this->customerRepository->create($input);

        Flash::success('Thank you for your order.');

        return redirect(route('items.show', $request->item_id));
    }

    /**
     * Display the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  int              $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $customer = $this->customerRepository->update($request->all(), $id);

        Flash::success('Customer updated successfully.');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $this->customerRepository->delete($id);

        Flash::success('Customer deleted successfully.');

        return redirect(route('customers.index'));
    }

    public function search(Request $request)
    {
        $q = $request->q;
        if (filled($q)) {
            $customers = Customer::where('id', 'LIKE', '%' . $q . '%')
                ->orWhere('firstName', 'LIKE', '%' . $q . '%')
                ->orWhere('lastName', 'LIKE', '%' . $q . '%')
                ->orWhere('email', 'LIKE', '%' . $q . '%')
                ->orWhere('country', 'LIKE', '%' . $q . '%')
                ->orWhere('totalRevenue', 'LIKE', '%' . $q . '%')
                ->sortable()->paginate(10);
            Flash::success('Search results  "' . $q . '"');
        } else {
            $customers = Customer::sortable()->paginate(10);
        }
        $countries = Customer::distinct()->get(['country'])->pluck('country');

        return view('customers.index', compact('customers', 'q', 'countries'));
    }

    public function filter(Request $request)
    {
        $this->customerRepository->pushCriteria(new RequestCriteria($request));
        $customers = Customer::sortable()->paginate(15);

        $countries = Customer::distinct()->get(['country'])->pluck('country');

        if ($request) {
            $customers = Customer::filter($request)->sortable()->paginate(15);
        }
        return view('customers.index', compact('customers', 'countries'));
    }
}
