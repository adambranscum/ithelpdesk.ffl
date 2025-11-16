<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeviceStatsController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to all time
        $startDate = $request->input('start_date', Device::min('purchased'));
        $endDate = $request->input('end_date', now());
        
        // Convert to Carbon instances if they're strings
        $startDate = $startDate ? Carbon::parse($startDate) : now()->subYears(10);
        $endDate = Carbon::parse($endDate);
        
        // Get devices by branch
        $devicesByBranch = Device::select('branch', DB::raw('COUNT(*) as count'))
            ->whereNotNull('branch')
            ->where('branch', '!=', '')
            ->groupBy('branch')
            ->orderBy('count', 'desc')
            ->get();
        
        // Get devices by make
        $devicesByMake = Device::select('make', DB::raw('COUNT(*) as count'))
            ->whereNotNull('make')
            ->where('make', '!=', '')
            ->groupBy('make')
            ->orderBy('count', 'desc')
            ->get();
        
        // Get devices by model (top 10)
        $devicesByModel = Device::select('model', 'make', DB::raw('COUNT(*) as count'))
            ->whereNotNull('model')
            ->where('model', '!=', '')
            ->groupBy('model', 'make')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        // Warranty status distribution
        $warrantyExpired = Device::warrantyExpired()->count();
        $warrantyExpiringSoon = Device::warrantyExpiringSoon()->count();
        $warrantyActive = Device::whereDate('warranty_end', '>', now()->addMonths(3))->count();
        $noWarrantyInfo = Device::whereNull('warranty_end')->count();
        
        // Devices purchased by year
        $devicesByYear = Device::select(
                DB::raw('YEAR(purchased) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('purchased')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        
        // Devices purchased by month (last 12 months)
        $devicesByMonth = Device::select(
                DB::raw('DATE_FORMAT(purchased, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('purchased')
            ->where('purchased', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // Warranty expiring by month (next 12 months)
        $warrantyExpiringByMonth = Device::select(
                DB::raw('DATE_FORMAT(warranty_end, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('warranty_end')
            ->whereBetween('warranty_end', [now(), now()->addMonths(12)])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // Average device age by make
        $avgAgeByMake = Device::select(
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
        $devicesByWarranty = Device::select('warranty', DB::raw('COUNT(*) as count'))
            ->whereNotNull('warranty')
            ->where('warranty', '!=', '')
            ->groupBy('warranty')
            ->orderBy('count', 'desc')
            ->get();
        
        // Branch breakdown with warranty info
        $branchWarrantyBreakdown = Device::select(
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
        
        // Overall statistics
        $totalDevices = Device::count();
        $devicesWithWarranty = Device::whereNotNull('warranty_end')->count();
        $avgDeviceAge = Device::whereNotNull('purchased')
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, purchased, NOW())) as avg')
            ->value('avg');
        
        // Oldest and newest devices
        $oldestDevice = Device::whereNotNull('purchased')->orderBy('purchased', 'asc')->first();
        $newestDevice = Device::whereNotNull('purchased')->orderBy('purchased', 'desc')->first();
        
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