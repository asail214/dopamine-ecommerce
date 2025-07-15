<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class ProductsBreadSeeder extends Seeder
{
    public function run()
    {
        // Create DataType for products
        $dataType = DataType::firstOrCreate([
            'slug' => 'products'
        ], [
            'name' => 'products',
            'display_name_singular' => 'Product',
            'display_name_plural' => 'Products',
            'icon' => 'voyager-bag',
            'model_name' => 'App\\Models\\Product',
            'policy_name' => null,
            'controller' => null,
            'generate_permissions' => 1,
            'description' => 'Product management',
            'server_side' => 1,
        ]);

        // Create DataRows for products
        $dataRows = [
            [
                'field' => 'id',
                'type' => 'number',
                'display_name' => 'ID',
                'required' => 1,
                'browse' => 0,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 1,
            ],
            [
                'field' => 'name',
                'type' => 'text',
                'display_name' => 'Name',
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 2,
            ],
            [
                'field' => 'description',
                'type' => 'rich_text_box',
                'display_name' => 'Description',
                'required' => 0,
                'browse' => 0,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 3,
            ],
            [
                'field' => 'price',
                'type' => 'number',
                'display_name' => 'Price',
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 4,
            ],
            [
                'field' => 'created_at',
                'type' => 'timestamp',
                'display_name' => 'Created At',
                'required' => 0,
                'browse' => 1,
                'read' => 1,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 5,
            ],
            [
                'field' => 'updated_at',
                'type' => 'timestamp',
                'display_name' => 'Updated At',
                'required' => 0,
                'browse' => 0,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 6,
            ],
        ];

        foreach ($dataRows as $rowData) {
            DataRow::firstOrCreate([
                'data_type_id' => $dataType->id,
                'field' => $rowData['field']
            ], array_merge($rowData, [
                'data_type_id' => $dataType->id
            ]));
        }

        // Generate permissions
        Permission::generateFor('products');

        // Add menu item
        $menu = Menu::where('name', 'admin')->first();
        if ($menu) {
            MenuItem::firstOrCreate([
                'menu_id' => $menu->id,
                'title' => 'Products',
                'url' => '',
                'route' => 'voyager.products.index',
            ], [
                'target' => '_self',
                'icon_class' => 'voyager-bag',
                'color' => null,
                'parent_id' => null,
                'order' => 4,
            ]);
        }
    }
}