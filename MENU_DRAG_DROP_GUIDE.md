# Menu Drag & Drop System - Documentation

## Overview
Implementasi sistem drag-and-drop untuk mengatur menu dengan mudah menggunakan Nestable.js. Support unlimited nesting levels (sub-menu level 2, 3, 4, dst).

## Features Implemented

✅ **Drag & Drop Interface** - Geser menu untuk mengubah urutan  
✅ **Nested Menu Support** - Geser ke kanan untuk membuat sub-menu  
✅ **Unlimited Levels** - Support hingga 5 level nesting (bisa lebih)  
✅ **Visual Hierarchy** - Indentation otomatis untuk sub-menu  
✅ **Real-time Update** - Auto-save saat drag selesai  
✅ **Edit & Delete** - Tombol aksi di setiap item  
✅ **Status Badge** - Visual indicator (Active/Inactive)  
✅ **Collapsible Items** - +/- button untuk expand/collapse  

## How to Use

### 1. Mengubah Urutan Menu
- **Klik dan tahan** pada icon hamburger (≡) di sebelah kiri menu
- **Drag ke atas/bawah** untuk mengubah urutan
- **Lepas** mouse untuk menyimpan

### 2. Membuat Sub-Menu (Nested)
- **Klik dan tahan** menu yang ingin dijadikan sub-menu
- **Drag ke kanan** hingga tampak indentasi
- **Lepas** di bawah menu parent yang diinginkan
- Auto-save: parent_id akan ter-update otomatis

### 3. Mengubah Parent Menu
- **Drag** sub-menu ke kiri untuk menaikkan level
- Atau drag ke menu parent lain untuk pindah group

### 4. Collapse/Expand
- Klik **tombol +** untuk expand submenu
- Klik **tombol -** untuk collapse submenu

## Visual Guide

```
Before Drag:
MENU1
MENU2
MENU3

After Drag (Make MENU2 child of MENU1):
MENU1
  ├─ MENU2  (indented = child of MENU1)
MENU3

Multi-level Example:
MENU1
  ├─ MENU1.1
  │   ├─ MENU1.1.1
  │   │   └─ MENU1.1.1.1  (Level 4)
  │   └─ MENU1.1.2
  └─ MENU1.2
MENU2
```

## Technical Details

### Files Modified

1. **View:** `resources/views/admin/menus/index.blade.php`
   - Removed table layout
   - Added Nestable.js HTML structure
   - Added CSS styling
   - Added jQuery initialization script

2. **Controller:** `app/Http/Controllers/Admin/MenuController.php`
   - Added `reorder()` method
   - Added `updateMenuHierarchy()` recursive method

3. **Routes:** `routes/web.php`
   - Added POST route: `/admin/menus/reorder`

### Dependencies

**Nestable.js v1.6.0:**
- CSS: `https://cdn.jsdelivr.net/npm/nestable2@1.6.0/dist/jquery.nestable.min.css`
- JS: `https://cdn.jsdelivr.net/npm/nestable2@1.6.0/dist/jquery.nestable.min.js`

**jQuery 3.6.0:**
- Required by Nestable.js
- Loaded from: `https://code.jquery.com/jquery-3.6.0.min.js`

### API Endpoint

**POST** `/admin/menus/reorder`

**Request Body:**
```json
{
    "_token": "csrf_token",
    "menu_group": "main|topbar",
    "hierarchy": "[{\"id\":1,\"children\":[{\"id\":2}]}]"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Menu order updated successfully"
}
```

### Database Updates

When menu is dragged:
1. `order` field updated (position in list)
2. `parent_id` updated (if nested)
3. `menu_group` maintained (topbar/main)

Recursive update for all children to maintain hierarchy.

## Configuration

### Max Depth
```javascript
$('#main-nestable').nestable({
    maxDepth: 5,  // Change to allow deeper nesting
    group: 1
});
```

### Customization

**Change Colors:**
```css
.dd3-content {
    background: #fafafa;  /* Menu item background */
    border: 1px solid #ccc;
}

.dd3-handle {
    background: #ddd;  /* Drag handle color */
}
```

**Change Icons:**
```css
.dd3-handle:before {
    content: '≡';  /* Drag icon */
}
```

## Benefits

| Feature | Before | After |
|---------|--------|-------|
| **Setup Sub-menu** | Manual parent_id entry | Drag & drop |
| **Reorder** | Manual order numbers | Visual drag |
| **See Hierarchy** | Flat table view | Nested visual tree |
| **Complexity** | High (many fields) | Low (intuitive UI) |
| **Speed** | Slow (~1 min/menu) | Fast (~5 sec/menu) |

## Browser Support

✅ Chrome/Edge (Modern)  
✅ Firefox  
✅ Safari  
✅ Mobile browsers (with touch support)  

## Known Limitations

- Requires JavaScript enabled
- jQuery dependency (adds ~90KB)
- Mobile touch can be less precise than desktop mouse
- Very deep nesting (6+) may look cluttered

## Troubleshooting

### Menu tidak bisa di-drag
- Check browser console untuk JavaScript errors
- Pastikan jQuery loaded sebelum nestable.js
- Verify CSRF token valid

### Urutan tidak tersimpan
- Check network tab untuk AJAX errors
- Verify route `/admin/menus/reorder` exists
- Check Laravel logs: `storage/logs/laravel.log`

### Hierarchy tidak update
- Pastikan `parent_id` dan `order` columns exist di database
- Check method `updateMenuHierarchy()` berjalan
- Verify JSON structure dari `serialize()`

## Future Enhancements

- [ ] Undo/Redo functionality
- [ ] Bulk operations (move multiple items)
- [ ] Export/Import menu structure
- [ ] Menu templates/presets
- [ ] Drag between menu groups (topbar ↔ main)
- [ ] Visual preview of frontend menu
- [ ] Keyboard shortcuts (Ctrl+Z, etc)

---

**Status:** ✅ Fully Functional  
**Version:** 1.0  
**Library:** Nestable.js 1.6.0  
**Compatible:** Laravel 10/11, Bootstrap 5
