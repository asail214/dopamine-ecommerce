<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use TCG\Voyager\Facades\Voyager;

class EcommerceStatsWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = new \stdClass();
        
        // Get counts for dashboard
        $count->products = Product::count();
        $count->orders = Order::count();
        $count->users = User::count();
        $count->categories = \TCG\Voyager\Models\Category::count();

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-shop',
            'title'  => 'E-commerce Stats',
            'text'   => 'Products: ' . $count->products . ' | Orders: ' . $count->orders,
            'button' => [
                'text' => 'View Products',
                'link' => route('voyager.products.index'),
            ],
            'image' => '/storage/logo.png', // We'll add your logo later
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return true;
    }
}