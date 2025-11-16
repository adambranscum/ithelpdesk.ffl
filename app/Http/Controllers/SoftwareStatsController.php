<?php

namespace App\Http\Controllers;

use App\Models\Software;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoftwareStatsController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to all time
        $startDate = $request->input('start_date', Software::min('created_at'));
        $endDate = $request->input('end_date', now());
        
        // Convert to Carbon instances if they're strings
        $startDate = $startDate ? Carbon::parse($startDate) : now()->subYears(10);
        $endDate = Carbon::parse($endDate);
        
        // License status distribution (SOFTWARE COUNT - excludes forever licenses)
        $licensesExpired = Software::expired()->count();
        $licensesExpiringSoon = Software::expiringSoon()->count();
        $licensesActive = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(30))
            ->count();
        $noRenewalInfo = Software::where('forever', '!=', 1)
            ->whereNull('renewal_date')
            ->count();
        
        // Total licenses by status (LICENSE QUANTITY - excludes unlimited and forever)
        $totalLicensesExpired = Software::expired()
            ->where('unlimited', '!=', 1)
            ->sum('licence_quantity');
        $totalLicensesExpiringSoon = Software::expiringSoon()
            ->where('unlimited', '!=', 1)
            ->sum('licence_quantity');
        $totalLicensesActive = Software::where('forever', '!=', 1)
            ->where('unlimited', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(30))
            ->sum('licence_quantity');
        $totalLicensesNoInfo = Software::where('forever', '!=', 1)
            ->where('unlimited', '!=', 1)
            ->whereNull('renewal_date')
            ->sum('licence_quantity');
        
        // Software by license quantity (top 10) - exclude unlimited
        $softwareByLicenses = Software::select('software', 'licence_quantity', 'renewal_date')
            ->where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->orderBy('licence_quantity', 'desc')
            ->limit(10)
            ->get();
        
        // Renewals by month (next 12 months) - exclude forever licenses
        $renewalsByMonth = Software::select(
                DB::raw('DATE_FORMAT(renewal_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN unlimited != 1 THEN licence_quantity ELSE 0 END) as total_licenses')
            )
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereBetween('renewal_date', [now(), now()->addMonths(12)])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // Renewals by year - exclude forever licenses
        $renewalsByYear = Software::select(
                DB::raw('YEAR(renewal_date) as year'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN unlimited != 1 THEN licence_quantity ELSE 0 END) as total_licenses')
            )
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
        // Software added by month (last 12 months)
        $softwareAddedByMonth = Software::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // License distribution ranges - exclude unlimited
        $licenseRanges = [
            '1-10' => Software::where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [1, 10])
                ->count(),
            '11-50' => Software::where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [11, 50])
                ->count(),
            '51-100' => Software::where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [51, 100])
                ->count(),
            '101-500' => Software::where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [101, 500])
                ->count(),
            '500+' => Software::where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->where('licence_quantity', '>', 500)
                ->count(),
        ];
        
        // Average licenses per software - exclude unlimited
        $avgLicensesPerSoftware = Software::where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->avg('licence_quantity');
        
        // Upcoming renewals (next 30, 60, 90 days) - exclude forever licenses
        $renewalsNext30Days = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->whereDate('renewal_date', '<=', now()->addDays(30))
            ->orderBy('renewal_date', 'asc')
            ->get();
        
        $renewalsNext60Days = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(30))
            ->whereDate('renewal_date', '<=', now()->addDays(60))
            ->count();
        
        $renewalsNext90Days = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(60))
            ->whereDate('renewal_date', '<=', now()->addDays(90))
            ->count();
        
        // Most and least licensed software - exclude unlimited
        $mostLicensed = Software::where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->orderBy('licence_quantity', 'desc')
            ->first();
        $leastLicensed = Software::where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->where('licence_quantity', '>', 0)
            ->orderBy('licence_quantity', 'asc')
            ->first();
        
        // Software with upcoming renewals (detailed) - exclude forever licenses
        $upcomingRenewals = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->whereDate('renewal_date', '<=', now()->addMonths(3))
            ->orderBy('renewal_date', 'asc')
            ->get();
        
        // Overall statistics
        $totalSoftware = Software::count();
        $totalLicenses = Software::where('unlimited', '!=', 1)
            ->sum('licence_quantity');
        $softwareWithRenewalInfo = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->count();
        
        // Oldest and newest renewal dates - exclude forever licenses
        $oldestRenewal = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->orderBy('renewal_date', 'asc')
            ->first();
        $newestRenewal = Software::where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->orderBy('renewal_date', 'desc')
            ->first();
        
        return view('software.stats', compact(
            'licensesExpired',
            'licensesExpiringSoon',
            'licensesActive',
            'noRenewalInfo',
            'totalLicensesExpired',
            'totalLicensesExpiringSoon',
            'totalLicensesActive',
            'totalLicensesNoInfo',
            'softwareByLicenses',
            'renewalsByMonth',
            'renewalsByYear',
            'softwareAddedByMonth',
            'licenseRanges',
            'avgLicensesPerSoftware',
            'renewalsNext30Days',
            'renewalsNext60Days',
            'renewalsNext90Days',
            'mostLicensed',
            'leastLicensed',
            'upcomingRenewals',
            'totalSoftware',
            'totalLicenses',
            'softwareWithRenewalInfo',
            'oldestRenewal',
            'newestRenewal',
            'startDate',
            'endDate'
        ));
    }
}