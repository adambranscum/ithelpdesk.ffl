<?php

namespace App\Http\Controllers;

use App\Models\Software;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SoftwareStatsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Let users pick a date range, or show everything by default
        $startDate = $request->input('start_date', Software::where('library_uid', $user->library_uid)->min('created_at'));
        $endDate = $request->input('end_date', now());

        // Make sure the dates are proper Carbon objects
        $startDate = $startDate ? Carbon::parse($startDate) : now()->subYears(10);
        $endDate = Carbon::parse($endDate);

        // Count how many software titles are in each license state (doesn't include forever licenses)
        $licensesExpired = Software::where('library_uid', $user->library_uid)->expired()->count();
        $licensesExpiringSoon = Software::where('library_uid', $user->library_uid)->expiringSoon()->count();
        $licensesActive = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(30))
            ->count();
        $noRenewalInfo = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNull('renewal_date')
            ->count();

        // Add up the total number of licenses by status (we skip unlimited and forever licenses)
        $totalLicensesExpired = Software::where('library_uid', $user->library_uid)
            ->expired()
            ->where('unlimited', '!=', 1)
            ->sum('licence_quantity');
        $totalLicensesExpiringSoon = Software::where('library_uid', $user->library_uid)
            ->expiringSoon()
            ->where('unlimited', '!=', 1)
            ->sum('licence_quantity');
        $totalLicensesActive = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->where('unlimited', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(30))
            ->sum('licence_quantity');
        $totalLicensesNoInfo = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->where('unlimited', '!=', 1)
            ->whereNull('renewal_date')
            ->sum('licence_quantity');

        // Show the top 10 software by license count so we can see what we have the most of
        $softwareByLicenses = Software::where('library_uid', $user->library_uid)
            ->select('software', 'licence_quantity', 'renewal_date')
            ->where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->orderBy('licence_quantity', 'desc')
            ->limit(10)
            ->get();
        
        // See what licenses are coming up for renewal in the next year
        $renewalsByMonth = Software::where('library_uid', $user->library_uid)
            ->select(
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

        // Look at renewal dates across all years to spot trends
        $renewalsByYear = Software::where('library_uid', $user->library_uid)
            ->select(
                DB::raw('YEAR(renewal_date) as year'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN unlimited != 1 THEN licence_quantity ELSE 0 END) as total_licenses')
            )
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // Track when we added new software to see our growth
        $softwareAddedByMonth = Software::where('library_uid', $user->library_uid)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Group software by how many licenses they have (buckets like 1-10, 11-50, etc.)
        $licenseRanges = [
            '1-10' => Software::where('library_uid', $user->library_uid)
                ->where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [1, 10])
                ->count(),
            '11-50' => Software::where('library_uid', $user->library_uid)
                ->where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [11, 50])
                ->count(),
            '51-100' => Software::where('library_uid', $user->library_uid)
                ->where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [51, 100])
                ->count(),
            '101-500' => Software::where('library_uid', $user->library_uid)
                ->where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->whereBetween('licence_quantity', [101, 500])
                ->count(),
            '500+' => Software::where('library_uid', $user->library_uid)
                ->where('unlimited', '!=', 1)
                ->whereNotNull('licence_quantity')
                ->where('licence_quantity', '>', 500)
                ->count(),
        ];

        // Calculate the average number of licenses across all software
        $avgLicensesPerSoftware = Software::where('library_uid', $user->library_uid)
            ->where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->avg('licence_quantity');

        // Find renewals coming up so we can plan ahead
        $renewalsNext30Days = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->whereDate('renewal_date', '<=', now()->addDays(30))
            ->orderBy('renewal_date', 'asc')
            ->get();

        $renewalsNext60Days = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(30))
            ->whereDate('renewal_date', '<=', now()->addDays(60))
            ->count();

        $renewalsNext90Days = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>', now()->addDays(60))
            ->whereDate('renewal_date', '<=', now()->addDays(90))
            ->count();

        // Find which software we have the most and least licenses for
        $mostLicensed = Software::where('library_uid', $user->library_uid)
            ->where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->orderBy('licence_quantity', 'desc')
            ->first();
        $leastLicensed = Software::where('library_uid', $user->library_uid)
            ->where('unlimited', '!=', 1)
            ->whereNotNull('licence_quantity')
            ->where('licence_quantity', '>', 0)
            ->orderBy('licence_quantity', 'asc')
            ->first();

        // Get detailed info on software with renewals coming up in the next 3 months
        $upcomingRenewals = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->whereDate('renewal_date', '<=', now()->addMonths(3))
            ->orderBy('renewal_date', 'asc')
            ->get();

        // Calculate some big picture numbers
        $totalSoftware = Software::where('library_uid', $user->library_uid)->count();
        $totalLicenses = Software::where('library_uid', $user->library_uid)
            ->where('unlimited', '!=', 1)
            ->sum('licence_quantity');
        $softwareWithRenewalInfo = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->count();

        // Find the oldest and newest renewal dates to see our timeline
        $oldestRenewal = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
            ->whereNotNull('renewal_date')
            ->whereDate('renewal_date', '>=', now())
            ->orderBy('renewal_date', 'asc')
            ->first();
        $newestRenewal = Software::where('library_uid', $user->library_uid)
            ->where('forever', '!=', 1)
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