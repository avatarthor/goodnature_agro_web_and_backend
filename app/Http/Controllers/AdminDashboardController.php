<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get current week's start and end dates
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Calculate total farmers and weekly increase
        // These are core stats that are always available
        $totalFarmers = Farmer::count();
        $weeklyNewFarmers = Farmer::whereBetween('created_at', [$weekStart, $weekEnd])->count();

        // Pass only core statistics to view
        // Module-specific stats will be added by their respective service providers
        return view('dashboard', compact(
            'user',
            'totalFarmers',
            'weeklyNewFarmers'
        ));
    }
}

// <!-- namespace App\Http\Controllers;

// use App\Models\Farmer;
// use App\Models\FarmerLoan;
// use App\Models\FarmerInput;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use Carbon\Carbon;

// class AdminDashboardController extends Controller
// {
    /**
     * Create a new controller instance.
     *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     */
//     public function index()
//     {
//         $user = Auth::user();

//         // Get current week's start and end dates
//         $weekStart = Carbon::now()->startOfWeek();
//         $weekEnd = Carbon::now()->endOfWeek();

//         // Calculate total farmers and weekly increase
//         $totalFarmers = Farmer::count();
//         $weeklyNewFarmers = Farmer::whereBetween('created_at', [$weekStart, $weekEnd])->count();

//         // Calculate loan statistics
//         $totalLoans = FarmerLoan::count();
//         $weeklyNewLoans = FarmerLoan::whereBetween('created_at', [$weekStart, $weekEnd])->count();

//         $totalLoanAmount = FarmerLoan::where('status', 'approved')->sum('loan_amount');
//         $weeklyNewLoanAmount = FarmerLoan::where('status', 'approved')
//             ->whereBetween('created_at', [$weekStart, $weekEnd])
//             ->sum('loan_amount');

//         // Calculate input distribution statistics
//         $totalInputs = FarmerInput::sum('quantity');
//         $weeklyNewInputs = FarmerInput::whereBetween('created_at', [$weekStart, $weekEnd])
//             ->sum('quantity');

//         // Get loan status statistics
//         $loanStats = FarmerLoan::select('status', DB::raw('count(*) as total'))
//             ->groupBy('status')
//             ->get()
//             ->pluck('total', 'status')
//             ->toArray();

//         // Get latest farmer inputs
//         $latestInputs = FarmerInput::with(['farmer', 'inputType'])
//             ->latest()
//             ->take(5)
//             ->get();

//         return view('dashboard', compact(
//             'user',
//             'totalFarmers',
//             'weeklyNewFarmers',
//             'totalLoans',
//             'weeklyNewLoans',
//             'totalLoanAmount',
//             'weeklyNewLoanAmount',
//             'totalInputs',
//             'weeklyNewInputs',
//             'loanStats',
//             'latestInputs'
//         ));
//     }
// }
