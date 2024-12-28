<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\FarmerLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FarmerLoanController extends Controller
{
    /**
     * Display a listing of farmer loans.
     */
    public function index()
    {
        $loans = FarmerLoan::with('farmer')->latest()->paginate(10);
        return view('farmer-loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $farmers = Farmer::all();
        return view('farmer-loans.create', compact('farmers'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'loan_amount' => 'required|numeric|min:1|max:1000000',
            'interest_rate' => 'required|numeric|min:1|max:100',
            'repayment_duration' => 'required|integer|min:1|max:60',
        ]);

        try {
            $farmerLoan = new FarmerLoan();
            $farmerLoan->farmer_id = $validated['farmer_id'];
            $farmerLoan->loan_amount = $validated['loan_amount'];
            $farmerLoan->interest_rate = $validated['interest_rate'];
            $farmerLoan->repayment_duration = $validated['repayment_duration'];
            $farmerLoan->status = 'pending';
            $farmerLoan->repaid = 0;
            $farmerLoan->save();

            return redirect()
                ->route('farmer-loans.index')
                ->with('success', 'Loan application created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create loan: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified loan.
     */
    public function edit($id)
    {
        $loan = FarmerLoan::findOrFail($id);
        $farmers = Farmer::all();
        return view('farmer-loans.edit', compact('loan', 'farmers'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'loan_amount' => 'required|numeric|min:1|max:1000000',
            'interest_rate' => 'required|numeric|min:1|max:100',
            'repayment_duration' => 'required|integer|min:1|max:60',
            // 'status' => 'required|in:pending,approved,rejected',
            // 'repaid' => 'required|boolean'
        ]);

        try {
            $loan = FarmerLoan::findOrFail($id);

            // Update loan details
            $loan->farmer_id = $request->farmer_id;
            $loan->loan_amount = $request->loan_amount;
            $loan->interest_rate = $request->interest_rate;
            $loan->repayment_duration = $request->repayment_duration;
            $loan->status = 'pending';
            $loan->repaid = 0;

            $loan->save();

            return redirect()
                ->route('farmer-loans.index')
                ->with('success', 'Loan updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update loan: ' . $e->getMessage());
        }
    }
    /**
     * Update loan status (approve/reject)
     */

     public function status(Request $request, $id)
    {
        $loan = FarmerLoan::findOrFail($id);
        $status = $request->query('status');

        if (!in_array($status, ['approved', 'rejected'])) {
            return redirect()->back()->with('error', 'Invalid status');
        }

        $loan->status = $status;
        $loan->save();

        return redirect()->back()->with('success', 'Loan status updated successfully');
    }

    /**
     * Mark loan as paid
     */

     public function paid($id)
    {
        $loan = FarmerLoan::findOrFail($id);

        if ($loan->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved loans can be marked as paid');
        }

        $loan->repaid = 1;
        $loan->save();

        return redirect()->back()->with('success', 'Loan marked as paid successfully');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy($id)
    {
        try {
            $loan = FarmerLoan::findOrFail($id);

            // Only allow deletion of pending loans
            if ($loan->status !== 'pending') {
                throw new \Exception('Can only delete pending loans');
            }

            $loan->delete();

            return redirect()->route('farmer-loans.index')->with('success', 'Farmer Loan deleted successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting loan: ' . $e->getMessage());
        }

    }
}
