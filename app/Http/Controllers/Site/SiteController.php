<?php

namespace App\Http\Controllers\Site;

use App\Models\Project;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display the index view
     * @return \Illuminate\Contracts\View\View
     * */
    public function index(Request $request)
    {
        $filters = [];
        $categories = Category::get();

        if ($request->has('category')) {
            $data = json_decode($request->category, true);
            if (!empty($data['category'])) {
                $filters['category'] = $data['category'];
            }
        }

        if ($request->has('budget_min')) {
            $filters['budget_min'] = $request->budget_min;
        }

        if ($request->has('budget_max')) {
            $filters['budget_max'] = $request->budget_max;
        }

        $query = Project::query();

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['budget_min']) || isset($filters['budget_max'])) {
            $query->where(function ($q) use ($filters) {
                if (isset($filters['budget_min'])) {
                    $q->where('budget_max', '>=', $filters['budget_min']);
                }

                if (isset($filters['budget_max'])) {
                    $q->where('budget_min', '<=', $filters['budget_max']);
                }
            });
        }

        $query->whereNotIn('status', ['completed', 'closed', 'in progress']);
        $projects = $query->paginate(1)->withQueryString();

        return view('site.index', compact('projects', 'categories'));
    }

}
