<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu HTML Debug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; font-family: monospace; }
        .code-block { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        pre { margin: 0; }
        
        /* Copy CSS dari layout.blade.php */
        .navbar-nav .dropend {
            position: relative;
        }
        
        .navbar-nav .dropdown-menu .dropend > .dropdown-menu {
            position: absolute !important;
            top: 0 !important;
            left: 100% !important;
            right: auto !important;
            margin-left: 0.125rem !important;
            margin-top: 0 !important;
            transform: none !important;
        }
        
        .navbar-nav .dropend > .dropdown-toggle::after {
            border-left: 0.3em solid;
            border-right: 0;
            border-top: 0.3em solid transparent;
            border-bottom: 0.3em solid transparent;
            margin-left: auto;
            float: right;
            margin-top: 0.5em;
        }
        
        .navbar-nav .dropdown:hover > .dropdown-menu {
            display: block !important;
        }
        
        .navbar-nav .dropend:hover > .dropdown-menu {
            display: block !important;
        }
    </style>
</head>
<body>
    <h1>Menu HTML Structure Debug</h1>
    
    <h2>1. Generated HTML Code</h2>
    <div class="code-block">
        <pre><?php
            ob_start();
            
            function eagerLoadActiveChildren() {
                return function ($query) {
                    $query->where('is_active', true)
                          ->orderBy('order')
                          ->with(['activeChildren' => eagerLoadActiveChildren()]);
                };
            }
            
            $mainMenus = \App\Models\Menu::where('is_active', true)
                ->where('menu_group', 'main')
                ->whereNull('parent_id')
                ->orderBy('order')
                ->with(['activeChildren' => eagerLoadActiveChildren()])
                ->get();
            
            function renderMenuItem($menu, $level = 0) {
                $hasChildren = $menu->relationLoaded('activeChildren') && $menu->activeChildren->count() > 0;
                
                if ($hasChildren) {
                    if ($level === 0) {
                        echo '<li class="nav-item dropdown">' . "\n";
                        echo '  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">' . htmlspecialchars($menu->title) . '</a>' . "\n";
                    } else {
                        echo '<li class="dropend">' . "\n";
                        echo '  <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">' . htmlspecialchars($menu->title) . '</a>' . "\n";
                    }
                    
                    echo '  <ul class="dropdown-menu">' . "\n";
                    foreach ($menu->activeChildren as $child) {
                        renderMenuItem($child, $level + 1);
                    }
                    echo '  </ul>' . "\n";
                    echo '</li>' . "\n";
                } else {
                    if ($level > 0) {
                        echo '<li>' . "\n";
                        echo '  <a class="dropdown-item" href="' . htmlspecialchars($menu->url ?: '#') . '">' . htmlspecialchars($menu->title) . '</a>' . "\n";
                        echo '</li>' . "\n";
                    } else {
                        echo '<li class="nav-item">' . "\n";
                        echo '  <a class="nav-link" href="' . htmlspecialchars($menu->url ?: '#') . '">' . htmlspecialchars($menu->title) . '</a>' . "\n";
                        echo '</li>' . "\n";
                    }
                }
            }
            
            echo '<ul class="navbar-nav">' . "\n";
            foreach($mainMenus as $menu) {
                renderMenuItem($menu);
            }
            echo '</ul>' . "\n";
            
            $htmlOutput = ob_get_clean();
            echo htmlspecialchars($htmlOutput);
        ?></pre>
    </div>
    
    <h2>2. Live Rendered Menu (Hover to Test)</h2>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <?php echo $htmlOutput; ?>
        </div>
    </nav>
    
    <h2>3. Expected Structure for MENU → MENU1 → MENU1.1</h2>
    <div class="code-block">
        <pre><?php echo htmlspecialchars('
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle">MENU</a>
  <ul class="dropdown-menu">
    
    <li class="dropend">                    <!-- MENU1 with dropend class -->
      <a class="dropdown-item dropdown-toggle">MENU1</a>
      <ul class="dropdown-menu">            <!-- This should appear on the RIGHT -->
        <li>
          <a class="dropdown-item">MENU1.1</a>
        </li>
        <li>
          <a class="dropdown-item">MENU1.2</a>
        </li>
      </ul>
    </li>
    
    <li class="dropend">
      <a class="dropdown-item dropdown-toggle">MENU2</a>
      <ul class="dropdown-menu">
      </ul>
    </li>
    
  </ul>
</li>
'); ?></pre>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
