<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DeviceStatsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get the date range from the request, or use all available data
        $startDate = $request->input('start_date', Device::where('library_uid', $user->library_uid)->min('purchased'));
        $endDate = $request->input('end_date', now());

        // Make sure we have valid Carbon date objects
        $startDate = $startDate ? Carbon::parse($startDate) : now()->subYears(10);
        $endDate = Carbon::parse($endDate);

        // Group devices by their branch/location
        $devicesByBranch = Device::where('library_uid', $user->library_uid)
            ->select('branch', DB::raw('COUNT(*) as count'))
            ->whereNotNull('branch')
            ->where('branch', '!=', '')
            ->groupBy('branch')
            ->orderBy('count', 'desc')
            ->get();

        // Count devices by manufacturer
        $devicesByMake = Device::where('library_uid', $user->library_uid)
            ->select('make', DB::raw('COUNT(*) as count'))
            ->whereNotNull('make')
            ->where('make', '!=', '')
            ->groupBy('make')
            ->orderBy('count', 'desc')
            ->get();

        // Get the top 10 device models to see what we have the most of
        $devicesByModel = Device::where('library_uid', $user->library_uid)
            ->select('model', 'make', DB::raw('COUNT(*) as count'))
            ->whereNotNull('model')
            ->where('model', '!=', '')
            ->groupBy('model', 'make')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // Warranty status
        $warrantyExpired = Device::where('library_uid', $user->library_uid)->warrantyExpired()->count();
        $warrantyExpiringSoon = Device::where('library_uid', $user->library_uid)->warrantyExpiringSoon()->count();
        $warrantyActive = Device::where('library_uid', $user->library_uid)->whereDate('warranty_end', '>', now()->addMonths(3))->count();
        $noWarrantyInfo = Device::where('library_uid', $user->library_uid)->whereNull('warranty_end')->count();
        
        // See how many devices we bought each year
        $devicesByYear = Device::where('library_uid', $user->library_uid)
            ->select(
                DB::raw('YEAR(purchased) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('purchased')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // Devices purchased by month
        $devicesByMonth = Device::where('library_uid', $user->library_uid)
            ->select(
                DB::raw('DATE_FORMAT(purchased, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('purchased')
            ->where('purchased', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Warranty expiring
        $warrantyExpiringByMonth = Device::where('library_uid', $user->library_uid)
            ->select(
                DB::raw('DATE_FORMAT(warranty_end, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('warranty_end')
            ->whereBetween('warranty_end', [now(), now()->addMonths(12)])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Average device age by make
        $avgAgeByMake = Device::where('library_uid', $user->library_uid)
            ->select(
                'make',
                DB::raw('AVG(TIMESTAMPDIFF(YEAR, purchased, NOW())) as avg_age'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('purchased')
            ->whereNotNull('make')
            ->where('make', '!=', '')
            ->groupBy('make')
            ->orderBy('avg_age', 'desc')
            ->get();

        // Devices by warranty type
        $devicesByWarranty = Device::where('library_uid', $user->library_uid)
            ->select('warranty', DB::raw('COUNT(*) as count'))
            ->whereNotNull('warranty')
            ->where('warranty', '!=', '')
            ->groupBy('warranty')
            ->orderBy('count', 'desc')
            ->get();

        // Branch breakdown with warranty info
        $branchWarrantyBreakdown = Device::where('library_uid', $user->library_uid)
            ->select(
                'branch',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN warranty_end < NOW() THEN 1 ELSE 0 END) as expired'),
                DB::raw('SUM(CASE WHEN warranty_end BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 3 MONTH) THEN 1 ELSE 0 END) as expiring_soon'),
                DB::raw('SUM(CASE WHEN warranty_end > DATE_ADD(NOW(), INTERVAL 3 MONTH) THEN 1 ELSE 0 END) as active')
            )
            ->whereNotNull('branch')
            ->where('branch', '!=', '')
            ->groupBy('branch')
            ->orderBy('total', 'desc')
            ->get();

        // Get some overall stats about the device collection
        $totalDevices = Device::where('library_uid', $user->library_uid)->count();
        $devicesWithWarranty = Device::where('library_uid', $user->library_uid)->whereNotNull('warranty_end')->count();
        $avgDeviceAge = Device::where('library_uid', $user->library_uid)
            ->whereNotNull('purchased')
            ->AVG(TIMESTAMPDIFF(DAY, purchased, NOW()) / 365.25) as avg
            ->value('avg');

        // Oldest and newest devices
        $oldestDevice = Device::where('library_uid', $user->library_uid)->whereNotNull('purchased')->orderBy('purchased', 'asc')->first();
        $newestDevice = Device::where('library_uid', $user->library_uid)->whereNotNull('purchased')->orderBy('purchased', 'desc')->first();
        
        return view('devices.stats', compact(
            'devicesByBranch',
            'devicesByMake',
            'devicesByModel',
            'warrantyExpired',
            'warrantyExpiringSoon',
            'warrantyActive',
            'noWarrantyInfo',
            'devicesByYear',
            'devicesByMonth',
            'warrantyExpiringByMonth',
            'avgAgeByMake',
            'devicesByWarranty',
            'branchWarrantyBreakdown',
            'totalDevices',
            'devicesWithWarranty',
            'avgDeviceAge',
            'oldestDevice',
            'newestDevice',
            'startDate',
            'endDate'
        ));
    }
}