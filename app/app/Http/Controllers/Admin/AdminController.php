<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Formation;
use App\Models\Meditation;
use App\Models\Article;
use App\Models\Order;
use App\Models\Subscription;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Revenus par mois (année en cours)
        $monthlyRevenue = array_fill(0, 12, 0);
        $revenues = Order::where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->get();
        foreach ($revenues as $r) {
            $monthlyRevenue[$r->month - 1] = (float) $r->total;
        }

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'users'             => User::count(),
                'services'          => Service::count(),
                'formations'        => Formation::count(),
                'meditations'       => Meditation::count(),
                'articles'          => Article::count(),
                'orders'            => Order::count(),
                'orders_paid'       => Order::where('status', 'paid')->count(),
                'orders_pending'    => Order::where('status', 'pending')->count(),
                'orders_failed'     => Order::where('status', 'failed')->count(),
                'subscriptions'     => Subscription::where('status', 'active')->count(),
                'revenue'           => Order::where('status', 'paid')->sum('amount'),
            ],
            'monthlyRevenue' => $monthlyRevenue,
            'recentOrders'   => Order::with('user')->latest()->take(6)->get(),
            'recentUsers'    => User::latest()->take(5)->get(),
        ]);
    }
}
