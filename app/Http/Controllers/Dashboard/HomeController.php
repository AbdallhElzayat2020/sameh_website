<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Expense;
use App\Models\Freelancer;
use App\Models\ProjectRequest;
use App\Models\Revenue;
use App\Models\Task;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Users Statistics
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();

        // Tasks Statistics
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        // Clients Statistics
        $totalClients = Client::count();

        // Freelancers Statistics
        $totalFreelancers = Freelancer::count();

        // Project Requests Statistics
        $totalProjectRequests = ProjectRequest::count();
        $pendingProjectRequests = ProjectRequest::where('status', 'pending')->count();

        // Contact Messages Statistics
        $totalContactMessages = ContactMessage::count();
        $recentContactMessages = ContactMessage::where('created_at', '>=', now()->subDays(7))->count();

        // Financial Statistics
        $totalRevenue = Revenue::sum('total');
        $totalExpense = Expense::sum('total');
        $netProfit = $totalRevenue - $totalExpense;

        // Recent Activity
        $recentTasks = Task::with('creator')
            ->latest()
            ->limit(5)
            ->get(['id', 'task_number', 'status', 'created_at', 'created_by']);

        $recentProjectRequests = ProjectRequest::latest()
            ->limit(5)
            ->get(['id', 'project_name', 'email', 'status', 'created_at']);

        return view('dashboard.pages.home', [
            // Users
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            // Tasks
            'totalTasks' => $totalTasks,
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
            'completedTasks' => $completedTasks,
            // Clients & Freelancers
            'totalClients' => $totalClients,
            'totalFreelancers' => $totalFreelancers,
            // Project Requests
            'totalProjectRequests' => $totalProjectRequests,
            'pendingProjectRequests' => $pendingProjectRequests,
            // Contact Messages
            'totalContactMessages' => $totalContactMessages,
            'recentContactMessages' => $recentContactMessages,
            // Financial
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit,
            // Recent Activity
            'recentTasks' => $recentTasks,
            'recentProjectRequests' => $recentProjectRequests,
        ]);
    }
}
