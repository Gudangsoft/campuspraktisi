<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = \App\Models\Menu::with('children')->orderBy('order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all menus to show in parent dropdown with hierarchy
        $parents = \App\Models\Menu::with('allChildren')->whereNull('parent_id')->orderBy('order')->get();
        return view('admin.menus.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:menus,id',
            'order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
            'target' => 'nullable|string|in:_self,_blank',
            'menu_group' => 'required|string|in:topbar,main',
        ]);

        $data['is_active'] = $request->has('is_active');

        \App\Models\Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success','Menu created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        // Get all menus except current menu and its descendants
        $parents = \App\Models\Menu::with('allChildren')
            ->where('id', '!=', $id)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
        return view('admin.menus.edit', compact('menu', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = \App\Models\Menu::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:191',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:menus,id',
            'order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
            'target' => 'nullable|string|in:_self,_blank',
            'menu_group' => 'required|string|in:topbar,main',
        ]);

        $data['is_active'] = $request->has('is_active');

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success','Menu updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success','Menu deleted');
    }
    
    /**
     * Reorder menus via drag and drop
     */
    public function reorder(Request $request)
    {
        $menuGroup = $request->input('menu_group');
        $structure = $request->input('structure');
        
        \Log::info('Reorder request received', [
            'menu_group' => $menuGroup,
            'structure' => $structure
        ]);
        
        // Process the nested structure recursively
        $this->processStructure($structure);
        
        return response()->json(['success' => true, 'message' => 'Menu structure updated']);
    }
    
    private function processStructure($items, $parentId = null)
    {
        foreach ($items as $item) {
            $updateData = [
                'order' => $item['order'],
                'parent_id' => $item['parent_id'] // This will be null for root items
            ];
            
            \Log::info('Updating menu', [
                'id' => $item['id'],
                'data' => $updateData
            ]);
            
            \App\Models\Menu::where('id', $item['id'])->update($updateData);
            
            // Process children recursively
            if (!empty($item['children'])) {
                $this->processStructure($item['children'], $item['id']);
            }
        }
    }
}
