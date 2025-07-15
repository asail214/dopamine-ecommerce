<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        // Safely get products (check if columns exist)
        $featuredProducts = collect();
        if (Schema::hasColumns('products', ['featured', 'status'])) {
            $featuredProducts = Product::where('featured', true)
                ->where('status', 'active')
                ->limit(8)
                ->get();
        } else {
            // Fallback: get any products if columns don't exist yet
            $featuredProducts = Product::limit(8)->get();
        }

        // Safely get categories
        $categories = collect();
        if (Schema::hasColumn('categories', 'is_active')) {
            $orderColumn = Schema::hasColumn('categories', 'sort_order') ? 'sort_order' : 'order';
            
            $categories = Category::where('is_active', true)
                ->whereNull('parent_id')
                ->orderBy($orderColumn)
                ->limit(6)
                ->get();
        } else {
            // Fallback: get any categories
            $categories = Category::limit(6)->get();
        }

        return view('frontend.home', compact('featuredProducts', 'categories'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}