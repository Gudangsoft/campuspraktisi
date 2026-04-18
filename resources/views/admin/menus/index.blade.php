@extends('admin.layout')

@section('title','Menus')
@section('page-title', 'Menu Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Menus</li>
@endsection

@section('styles')
<style>
    .nested-sortable {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .nested-sortable .nested-sortable {
        padding-left: 30px;
        margin-top: 5px;
    }
    
    .menu-item {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        border-radius: 5px;
        position: relative;
    }
    
    .menu-item.dragging {
        opacity: 0.4;
        background: #f0f0f0;
    }
    
    .menu-content {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        gap: 10px;
        cursor: move;
    }
    
    .menu-content:hover {
        background: #f8f9fa;
    }
    
    .drag-handle {
        color: #999;
        font-size: 16px;
        cursor: grab;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
    
    .menu-title {
        flex: 1;
        font-weight: 600;
        font-size: 14px;
    }
    
    .menu-url {
        color: #666;
        font-size: 11px;
        font-family: 'Courier New', monospace;
        margin-top: 2px;
    }
    
    .menu-actions {
        display: flex;
        gap: 5px;
    }
    
    .badge {
        font-size: 10px;
        padding: 3px 8px;
    }
    
    .sortable-ghost {
        background: #e3f2fd !important;
        border: 2px dashed #2196f3 !important;
    }
    
    .sortable-chosen {
        background: #f5f5f5;
    }
    
    .alert-drag {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
    }
    
    .nested-indicator {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: linear-gradient(to bottom, #667eea, #764ba2);
        border-radius: 2px;
    }
    
    .menu-item:has(.nested-sortable) {
        border-left: 3px solid #667eea;
    }
</style>
@endsection

@section('content')

<div class="alert alert-drag mb-4">
    <i class="fas fa-hand-pointer me-2"></i>
    <strong>Drag & Drop Nested Menu:</strong> Drag ☰ ke atas/bawah untuk urutan. Drag ke <strong>KANAN</strong> untuk buat sub-menu (Menu → Menu1 → Menu1.1). Auto-save!
</div>

<!-- Top Bar Menus -->
<div class="content-card mb-4">
    <div class="content-card-header">
        <h5><i class="fas fa-bars me-2"></i>Top Bar Menu</h5>
        <a href="{{ route('admin.menus.create') }}?group=topbar" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Menu
        </a>
    </div>

    <div class="p-3">
        <ul class="nested-sortable" id="topbar-menu">
            @php
                $topbarMenus = $menus->where('menu_group', 'topbar')->where('parent_id', null)->sortBy('order');
                
                function renderNestedMenu($menus, $allMenus) {
                    foreach($menus as $menu) {
                        echo '<li class="menu-item" data-id="' . $menu->id . '">';
                        echo '<div class="menu-content">';
                        echo '<span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>';
                        echo '<div class="menu-title">';
                        echo htmlspecialchars($menu->title);
                        echo '<div class="menu-url">' . ($menu->url ?: '#') . '</div>';
                        echo '</div>';
                        echo '<div>';
                        if($menu->is_active) {
                            echo '<span class="badge bg-success">Active</span>';
                        } else {
                            echo '<span class="badge bg-secondary">Inactive</span>';
                        }
                        echo '</div>';
                        echo '<div class="menu-actions">';
                        echo '<a href="' . route('admin.menus.edit', $menu->id) . '" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>';
                        echo '<form method="POST" action="' . route('admin.menus.destroy', $menu->id) . '" style="display:inline" onsubmit="return confirm(\'Yakin hapus?\')">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>';
                        echo '</div>';
                        echo '</div>';
                        
                        $children = $allMenus->where('parent_id', $menu->id)->sortBy('order');
                        if($children->count() > 0) {
                            echo '<ul class="nested-sortable">';
                            renderNestedMenu($children, $allMenus);
                            echo '</ul>';
                        }
                        
                        echo '</li>';
                    }
                }
            @endphp
            
            @if($topbarMenus->count() > 0)
                @php renderNestedMenu($topbarMenus, $menus); @endphp
            @else
                <li class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    Belum ada menu Top Bar
                </li>
            @endif
        </ul>
    </div>
</div>

<!-- Main Navigation Menus -->
<div class="content-card">
    <div class="content-card-header">
        <h5><i class="fas fa-bars me-2"></i>Main Navigation</h5>
        <a href="{{ route('admin.menus.create') }}?group=main" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Menu
        </a>
    </div>
    
    <div class="p-3">
        <ul class="nested-sortable" id="main-menu">
            @php
                $mainMenus = $menus->where('menu_group', 'main')->where('parent_id', null)->sortBy('order');
            @endphp
            
            @if($mainMenus->count() > 0)
                @php renderNestedMenu($mainMenus, $menus); @endphp
            @else
                <li class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    Belum ada menu Main Navigation
                </li>
            @endif
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Recursive function to initialize nested sortable
    function initNestedSortable(element, group) {
        if (!element) {
            console.log('Element not found for group:', group);
            return;
        }
        
        console.log('Initializing sortable for:', element.id, 'group:', group);
        
        var sortableInstance = new Sortable(element, {
            group: {
                name: 'nested-' + group,
                pull: true,
                put: true
            },
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'dragging',
            onEnd: function(evt) {
                console.log('=== Drag ended ===');
                console.log('From:', evt.from.id);
                console.log('To:', evt.to.id);
                console.log('Old index:', evt.oldIndex);
                console.log('New index:', evt.newIndex);
                saveNestedMenuStructure(group);
            }
        });
        
        // Initialize all nested lists within this element
        var nestedLists = element.querySelectorAll(':scope > .menu-item > .nested-sortable');
        console.log('Found ' + nestedLists.length + ' nested lists in', element.id);
        nestedLists.forEach(function(nestedList) {
            initNestedSortable(nestedList, group);
        });
    }
    
    // Initialize Topbar menus
    var topbarMenu = document.getElementById('topbar-menu');
    if (topbarMenu) {
        initNestedSortable(topbarMenu, 'topbar');
        console.log('✓ Topbar nested sortable initialized');
    }
    
    // Initialize Main menus
    var mainMenu = document.getElementById('main-menu');
    if (mainMenu) {
        initNestedSortable(mainMenu, 'main');
        console.log('✓ Main nested sortable initialized');
    }
    
    function saveNestedMenuStructure(menuGroup) {
        var listId = menuGroup === 'topbar' ? 'topbar-menu' : 'main-menu';
        var rootList = document.getElementById(listId);
        
        var structure = buildMenuStructure(rootList, null);
        
        console.log('=== Saving structure for ' + menuGroup + ' ===');
        console.log(JSON.stringify(structure, null, 2));
        
        fetch('{{ route("admin.menus.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                menu_group: menuGroup,
                structure: structure
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('✓ Structure saved successfully');
                showNotification('Menu berhasil diupdate!', 'success');
            } else {
                console.error('Save failed:', data);
                showNotification('Error: ' + (data.message || 'Unknown error'), 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error saving menu structure', 'danger');
        });
    }
    
    function buildMenuStructure(ul, parentId) {
        var items = [];
        var menuItems = ul.querySelectorAll(':scope > .menu-item');
        
        console.log('Building structure for UL with ' + menuItems.length + ' items, parent_id:', parentId);
        
        menuItems.forEach(function(item, index) {
            var menuId = parseInt(item.getAttribute('data-id'));
            var nestedList = item.querySelector(':scope > .nested-sortable');
            var children = nestedList ? buildMenuStructure(nestedList, menuId) : [];
            
            var itemData = {
                id: menuId,
                parent_id: parentId,
                order: index,
                children: children
            };
            
            console.log('Item:', itemData);
            items.push(itemData);
        });
        
        return items;
    }
    
    function showNotification(message, type) {
        var notification = document.createElement('div');
        notification.className = 'alert alert-' + type + ' position-fixed top-0 end-0 m-3 shadow';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '250px';
        notification.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + message;
        document.body.appendChild(notification);
        
        setTimeout(function() {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 2000);
    }
});
</script>
@endsection
