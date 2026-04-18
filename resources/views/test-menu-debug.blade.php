<!DOCTYPE html>
<html>
<head>
    <title>Menu Debug</title>
    <style>
        body { font-family: monospace; padding: 20px; }
        .menu-tree { margin-left: 20px; }
        .active { color: green; }
        .inactive { color: red; }
    </style>
</head>
<body>
    <h1>Menu Structure Debug</h1>
    
    <h2>Main Navigation Menus</h2>
    @php
        $mainMenus = \App\Models\Menu::where('menu_group', 'main')
            ->orderBy('order')
            ->get();
        
        function displayMenuTree($menus, $parentId = null, $indent = 0) {
            $children = $menus->where('parent_id', $parentId);
            foreach ($children as $menu) {
                $prefix = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $indent);
                $status = $menu->is_active ? '<span class="active">✓</span>' : '<span class="inactive">✗</span>';
                echo "<div>{$prefix}{$status} ID:{$menu->id} - <strong>{$menu->title}</strong> (parent_id: " . ($menu->parent_id ?? 'NULL') . ", order: {$menu->order})</div>";
                displayMenuTree($menus, $menu->id, $indent + 1);
            }
        }
        
        displayMenuTree($mainMenus);
    @endphp
    
    <hr>
    
    <h2>Testing Eager Loading</h2>
    @php
        function eagerLoadActiveChildren() {
            return function ($query) {
                $query->where('is_active', true)
                      ->orderBy('order')
                      ->with(['activeChildren' => eagerLoadActiveChildren()]);
            };
        }
        
        $testMenus = \App\Models\Menu::where('is_active', true)
            ->where('menu_group', 'main')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->with(['activeChildren' => eagerLoadActiveChildren()])
            ->get();
            
        function displayEagerLoaded($menus, $level = 0) {
            foreach ($menus as $menu) {
                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                $hasChildren = $menu->relationLoaded('activeChildren') && $menu->activeChildren->count() > 0;
                $childCount = $hasChildren ? $menu->activeChildren->count() : 0;
                echo "<div>{$indent}📁 <strong>{$menu->title}</strong> - {$childCount} children loaded</div>";
                if ($hasChildren) {
                    displayEagerLoaded($menu->activeChildren, $level + 1);
                }
            }
        }
        
        displayEagerLoaded($testMenus);
    @endphp
    
    <hr>
    
    <h2>Search for MENU1</h2>
    @php
        $searchMenu1 = \App\Models\Menu::where('title', 'LIKE', '%MENU%')->get();
        if ($searchMenu1->count() > 0) {
            echo "<p>Found " . $searchMenu1->count() . " menu(s) with 'MENU' in title:</p>";
            foreach ($searchMenu1 as $m) {
                echo "<div>- ID:{$m->id} <strong>{$m->title}</strong> (parent_id: " . ($m->parent_id ?? 'NULL') . ")</div>";
            }
        } else {
            echo "<p style='color:red;'>No menu with 'MENU' found. Please create MENU, MENU1, MENU1.1, MENU1.2 first!</p>";
        }
    @endphp
</body>
</html>
