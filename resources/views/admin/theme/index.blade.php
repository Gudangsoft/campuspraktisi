@extends('admin.layout')

@section('title', 'Theme Settings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-palette"></i> Theme Customization
        </h1>
        <div>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-info">
                <i class="fas fa-eye"></i> Preview Website
            </a>
            <form action="{{ route('admin.theme.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('Reset theme to default colors?');">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-undo"></i> Reset to Default
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Theme Presets -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-gradient-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-swatchbook"></i> Quick Theme Presets
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">Pilih salah satu tema preset atau customize sendiri di bawah:</p>
            <div class="row g-3">
                <!-- Default Blue -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="default" onclick="applyPreset('default')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #1e90ff;"></div>
                            <div class="color-strip" style="background: #6c757d;"></div>
                            <div class="color-strip" style="background: #ffffff;"></div>
                            <div class="color-strip" style="background: #003366;"></div>
                        </div>
                        <div class="theme-name">Default Blue</div>
                    </div>
                </div>

                <!-- Professional Navy -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="navy" onclick="applyPreset('navy')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #1e3a8a;"></div>
                            <div class="color-strip" style="background: #475569;"></div>
                            <div class="color-strip" style="background: #f8fafc;"></div>
                            <div class="color-strip" style="background: #0f172a;"></div>
                        </div>
                        <div class="theme-name">Professional Navy</div>
                    </div>
                </div>

                <!-- Education Green -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="green" onclick="applyPreset('green')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #059669;"></div>
                            <div class="color-strip" style="background: #6b7280;"></div>
                            <div class="color-strip" style="background: #ffffff;"></div>
                            <div class="color-strip" style="background: #064e3b;"></div>
                        </div>
                        <div class="theme-name">Education Green</div>
                    </div>
                </div>

                <!-- Modern Purple -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="purple" onclick="applyPreset('purple')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #7c3aed;"></div>
                            <div class="color-strip" style="background: #64748b;"></div>
                            <div class="color-strip" style="background: #fefefe;"></div>
                            <div class="color-strip" style="background: #4c1d95;"></div>
                        </div>
                        <div class="theme-name">Modern Purple</div>
                    </div>
                </div>

                <!-- Vibrant Orange -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="orange" onclick="applyPreset('orange')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #ea580c;"></div>
                            <div class="color-strip" style="background: #71717a;"></div>
                            <div class="color-strip" style="background: #ffffff;"></div>
                            <div class="color-strip" style="background: #7c2d12;"></div>
                        </div>
                        <div class="theme-name">Vibrant Orange</div>
                    </div>
                </div>

                <!-- Elegant Teal -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="teal" onclick="applyPreset('teal')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #0d9488;"></div>
                            <div class="color-strip" style="background: #6b7280;"></div>
                            <div class="color-strip" style="background: #f9fafb;"></div>
                            <div class="color-strip" style="background: #134e4a;"></div>
                        </div>
                        <div class="theme-name">Elegant Teal</div>
                    </div>
                </div>

                <!-- Bold Red -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="red" onclick="applyPreset('red')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #dc2626;"></div>
                            <div class="color-strip" style="background: #737373;"></div>
                            <div class="color-strip" style="background: #ffffff;"></div>
                            <div class="color-strip" style="background: #7f1d1d;"></div>
                        </div>
                        <div class="theme-name">Bold Red</div>
                    </div>
                </div>

                <!-- Dark Mode -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="dark" onclick="applyPreset('dark')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #3b82f6;"></div>
                            <div class="color-strip" style="background: #6b7280;"></div>
                            <div class="color-strip" style="background: #1f2937;"></div>
                            <div class="color-strip" style="background: #111827;"></div>
                        </div>
                        <div class="theme-name">Dark Mode</div>
                    </div>
                </div>

                <!-- OKE Theme -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="oke" onclick="applyPreset('oke')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #0073e6;"></div>
                            <div class="color-strip" style="background: #1e3a8a;"></div>
                            <div class="color-strip" style="background: #ffffff;"></div>
                            <div class="color-strip" style="background: #003d82;"></div>
                        </div>
                        <div class="theme-name">OKE</div>
                    </div>
                </div>

                <!-- OKE-2 Theme -->
                <div class="col-md-3">
                    <div class="theme-preset-card" data-preset="oke2" onclick="applyPreset('oke2')">
                        <div class="theme-preview">
                            <div class="color-strip" style="background: #0088cc;"></div>
                            <div class="color-strip" style="background: #003d7a;"></div>
                            <div class="color-strip" style="background: #ffffff;"></div>
                            <div class="color-strip" style="background: #002855;"></div>
                        </div>
                        <div class="theme-name">OKE-2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.theme.update') }}" method="POST" id="themeForm">
        @csrf
        @method('PUT')

        <!-- Hidden inputs for theme colors -->
        <input type="hidden" id="theme_primary_color" name="theme_primary_color" value="{{ $themeSettings['theme_primary_color']->value ?? '#0d6efd' }}">
        <input type="hidden" id="theme_secondary_color" name="theme_secondary_color" value="{{ $themeSettings['theme_secondary_color']->value ?? '#6c757d' }}">
        <input type="hidden" id="theme_success_color" name="theme_success_color" value="{{ $themeSettings['theme_success_color']->value ?? '#198754' }}">
        <input type="hidden" id="theme_danger_color" name="theme_danger_color" value="{{ $themeSettings['theme_danger_color']->value ?? '#dc3545' }}">
        <input type="hidden" id="theme_warning_color" name="theme_warning_color" value="{{ $themeSettings['theme_warning_color']->value ?? '#ffc107' }}">
        <input type="hidden" id="theme_info_color" name="theme_info_color" value="{{ $themeSettings['theme_info_color']->value ?? '#0dcaf0' }}">
        <input type="hidden" id="theme_topbar_bg_color" name="theme_topbar_bg_color" value="{{ $themeSettings['theme_topbar_bg_color']->value ?? '#1a1a2e' }}">
        <input type="hidden" id="theme_topbar_text_color" name="theme_topbar_text_color" value="{{ $themeSettings['theme_topbar_text_color']->value ?? '#e0e0e0' }}">
        <input type="hidden" id="theme_header_bg_color" name="theme_header_bg_color" value="{{ $themeSettings['theme_header_bg_color']->value ?? '#ffffff' }}">
        <input type="hidden" id="theme_header_text_color" name="theme_header_text_color" value="{{ $themeSettings['theme_header_text_color']->value ?? '#212529' }}">
        <input type="hidden" id="theme_footer_bg_color" name="theme_footer_bg_color" value="{{ $themeSettings['theme_footer_bg_color']->value ?? '#003366' }}">
        <input type="hidden" id="theme_footer_text_color" name="theme_footer_text_color" value="{{ $themeSettings['theme_footer_text_color']->value ?? '#ffffff' }}">
        <input type="hidden" id="theme_button_bg_color" name="theme_button_bg_color" value="{{ $themeSettings['theme_button_bg_color']->value ?? '#0d6efd' }}">
        <input type="hidden" id="theme_button_text_color" name="theme_button_text_color" value="{{ $themeSettings['theme_button_text_color']->value ?? '#ffffff' }}">
        <input type="hidden" id="theme_link_color" name="theme_link_color" value="{{ $themeSettings['theme_link_color']->value ?? '#0d6efd' }}">
        <input type="hidden" id="theme_link_hover_color" name="theme_link_hover_color" value="{{ $themeSettings['theme_link_hover_color']->value ?? '#0a58ca' }}">

        <!-- Current Theme Preview -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-eye"></i> Current Active Theme
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="color-preview-item">
                            <div class="color-box" style="background: {{ $themeSettings['theme_primary_color']->value ?? '#0d6efd' }}"></div>
                            <small class="text-muted">Primary</small>
                            <div class="color-code">{{ $themeSettings['theme_primary_color']->value ?? '#0d6efd' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-preview-item">
                            <div class="color-box" style="background: {{ $themeSettings['theme_secondary_color']->value ?? '#6c757d' }}"></div>
                            <small class="text-muted">Secondary</small>
                            <div class="color-code">{{ $themeSettings['theme_secondary_color']->value ?? '#6c757d' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-preview-item">
                            <div class="color-box" style="background: {{ $themeSettings['theme_header_bg_color']->value ?? '#ffffff' }}; border: 1px solid #ddd;"></div>
                            <small class="text-muted">Header BG</small>
                            <div class="color-code">{{ $themeSettings['theme_header_bg_color']->value ?? '#ffffff' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-preview-item">
                            <div class="color-box" style="background: {{ $themeSettings['theme_footer_bg_color']->value ?? '#003366' }}"></div>
                            <small class="text-muted">Footer BG</small>
                            <div class="color-code">{{ $themeSettings['theme_footer_bg_color']->value ?? '#003366' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow-lg mb-4">
            <div class="card-body text-center py-4">
                <button type="submit" class="btn btn-success btn-lg px-5 py-3">
                    <i class="fas fa-save"></i> Save Theme Settings
                </button>
            </div>
        </div>
    </form>
</div>

<style>
.theme-preset-card {
    border: 3px solid #e5e7eb;
    border-radius: 12px;
    padding: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.theme-preset-card:hover {
    border-color: #3b82f6;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
}

.theme-preset-card.active {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
}

.theme-preview {
    display: flex;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.color-strip {
    flex: 1;
    transition: flex 0.3s ease;
}

.theme-preset-card:hover .color-strip {
    flex: 1.2;
}

.theme-name {
    text-align: center;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.card-header.bg-gradient-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.color-preview-item {
    text-align: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.color-box {
    width: 100%;
    height: 80px;
    border-radius: 6px;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.color-code {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    font-size: 12px;
    color: #6b7280;
    margin-top: 5px;
}
</style>

@endsection

@section('scripts')
<script>
// Theme Presets Data
const themePresets = {
    default: {
        theme_primary_color: '#1e90ff',
        theme_secondary_color: '#6c757d',
        theme_success_color: '#198754',
        theme_danger_color: '#dc3545',
        theme_warning_color: '#ffc107',
        theme_info_color: '#0dcaf0',
        theme_topbar_bg_color: '#1a1a2e',
        theme_topbar_text_color: '#e0e0e0',
        theme_header_bg_color: '#ffffff',
        theme_header_text_color: '#212529',
        theme_footer_bg_color: '#003366',
        theme_footer_text_color: '#ffffff',
        theme_button_bg_color: '#1e90ff',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#1e90ff',
        theme_link_hover_color: '#0066cc'
    },
    navy: {
        theme_primary_color: '#1e3a8a',
        theme_secondary_color: '#475569',
        theme_success_color: '#059669',
        theme_danger_color: '#dc2626',
        theme_warning_color: '#f59e0b',
        theme_info_color: '#06b6d4',
        theme_topbar_bg_color: '#1e293b',
        theme_topbar_text_color: '#cbd5e1',
        theme_header_bg_color: '#f8fafc',
        theme_header_text_color: '#0f172a',
        theme_footer_bg_color: '#0f172a',
        theme_footer_text_color: '#f1f5f9',
        theme_button_bg_color: '#1e3a8a',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#1e40af',
        theme_link_hover_color: '#1e3a8a'
    },
    green: {
        theme_primary_color: '#059669',
        theme_secondary_color: '#6b7280',
        theme_success_color: '#10b981',
        theme_danger_color: '#ef4444',
        theme_warning_color: '#f59e0b',
        theme_info_color: '#3b82f6',
        theme_topbar_bg_color: '#065f46',
        theme_topbar_text_color: '#d1fae5',
        theme_header_bg_color: '#ffffff',
        theme_header_text_color: '#111827',
        theme_footer_bg_color: '#064e3b',
        theme_footer_text_color: '#ecfdf5',
        theme_button_bg_color: '#059669',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#047857',
        theme_link_hover_color: '#065f46'
    },
    purple: {
        theme_primary_color: '#7c3aed',
        theme_secondary_color: '#64748b',
        theme_success_color: '#10b981',
        theme_danger_color: '#ef4444',
        theme_warning_color: '#f59e0b',
        theme_info_color: '#06b6d4',
        theme_topbar_bg_color: '#5b21b6',
        theme_topbar_text_color: '#f3e8ff',
        theme_header_bg_color: '#fefefe',
        theme_header_text_color: '#1e293b',
        theme_footer_bg_color: '#4c1d95',
        theme_footer_text_color: '#faf5ff',
        theme_button_bg_color: '#7c3aed',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#7c3aed',
        theme_link_hover_color: '#6d28d9'
    },
    orange: {
        theme_primary_color: '#ea580c',
        theme_secondary_color: '#71717a',
        theme_success_color: '#22c55e',
        theme_danger_color: '#dc2626',
        theme_warning_color: '#eab308',
        theme_info_color: '#0ea5e9',
        theme_topbar_bg_color: '#9a3412',
        theme_topbar_text_color: '#fed7aa',
        theme_header_bg_color: '#ffffff',
        theme_header_text_color: '#18181b',
        theme_footer_bg_color: '#7c2d12',
        theme_footer_text_color: '#ffedd5',
        theme_button_bg_color: '#ea580c',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#ea580c',
        theme_link_hover_color: '#c2410c'
    },
    teal: {
        theme_primary_color: '#0d9488',
        theme_secondary_color: '#6b7280',
        theme_success_color: '#10b981',
        theme_danger_color: '#ef4444',
        theme_warning_color: '#f59e0b',
        theme_info_color: '#3b82f6',
        theme_topbar_bg_color: '#115e59',
        theme_topbar_text_color: '#ccfbf1',
        theme_header_bg_color: '#f9fafb',
        theme_header_text_color: '#111827',
        theme_footer_bg_color: '#134e4a',
        theme_footer_text_color: '#f0fdfa',
        theme_button_bg_color: '#0d9488',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#0f766e',
        theme_link_hover_color: '#115e59'
    },
    red: {
        theme_primary_color: '#dc2626',
        theme_secondary_color: '#737373',
        theme_success_color: '#16a34a',
        theme_danger_color: '#b91c1c',
        theme_warning_color: '#ea580c',
        theme_info_color: '#0284c7',
        theme_topbar_bg_color: '#991b1b',
        theme_topbar_text_color: '#fee2e2',
        theme_header_bg_color: '#ffffff',
        theme_header_text_color: '#171717',
        theme_footer_bg_color: '#7f1d1d',
        theme_footer_text_color: '#fef2f2',
        theme_button_bg_color: '#dc2626',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#dc2626',
        theme_link_hover_color: '#b91c1c'
    },
    dark: {
        theme_primary_color: '#3b82f6',
        theme_secondary_color: '#6b7280',
        theme_success_color: '#10b981',
        theme_danger_color: '#ef4444',
        theme_warning_color: '#f59e0b',
        theme_info_color: '#06b6d4',
        theme_topbar_bg_color: '#030712',
        theme_topbar_text_color: '#d1d5db',
        theme_header_bg_color: '#1f2937',
        theme_header_text_color: '#f9fafb',
        theme_footer_bg_color: '#111827',
        theme_footer_text_color: '#e5e7eb',
        theme_button_bg_color: '#3b82f6',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#60a5fa',
        theme_link_hover_color: '#3b82f6'
    },
    oke: {
        theme_primary_color: '#0073e6',
        theme_secondary_color: '#6c757d',
        theme_success_color: '#198754',
        theme_danger_color: '#dc3545',
        theme_warning_color: '#ff9800',
        theme_info_color: '#0dcaf0',
        theme_topbar_bg_color: '#1e3a8a',
        theme_topbar_text_color: '#e0e7ff',
        theme_header_bg_color: '#0073e6',
        theme_header_text_color: '#ffffff',
        theme_footer_bg_color: '#003d82',
        theme_footer_text_color: '#ffffff',
        theme_button_bg_color: '#ff9800',
        theme_button_text_color: '#ffffff',
        theme_link_color: '#0073e6',
        theme_link_hover_color: '#005bb5'
    },
    oke2: {
        theme_primary_color: '#0088cc',
        theme_secondary_color: '#6c757d',
        theme_success_color: '#198754',
        theme_danger_color: '#dc3545',
        theme_warning_color: '#ffc107',
        theme_info_color: '#17a2b8',
        theme_topbar_bg_color: '#0088cc',
        theme_topbar_text_color: '#ffffff',
        theme_header_bg_color: '#003d7a',
        theme_header_text_color: '#ffffff',
        theme_footer_bg_color: '#002855',
        theme_footer_text_color: '#ffffff',
        theme_button_bg_color: '#ffc107',
        theme_button_text_color: '#212529',
        theme_link_color: '#0088cc',
        theme_link_hover_color: '#0066aa'
    }
};

// Apply Preset Function
function applyPreset(presetName) {
    const preset = themePresets[presetName];
    if (!preset) return;

    // Remove active class from all cards
    document.querySelectorAll('.theme-preset-card').forEach(card => {
        card.classList.remove('active');
    });

    // Add active class to selected card
    document.querySelector(`[data-preset="${presetName}"]`).classList.add('active');

    // Apply colors to hidden form inputs
    Object.keys(preset).forEach(key => {
        const input = document.getElementById(key);
        if (input) {
            input.value = preset[key];
        }
    });

    // Show loading message
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-info alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-spinner fa-spin"></i> Applying "${presetName}" theme...
    `;
    document.body.appendChild(alertDiv);

    // Auto-submit form after a short delay
    setTimeout(() => {
        document.getElementById('themeForm').submit();
    }, 500);
}

document.addEventListener('DOMContentLoaded', function() {
    // Sync color picker with text input
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        const textInput = colorInput.closest('.input-group').querySelector('input[type="text"]');
        
        colorInput.addEventListener('input', function() {
            textInput.value = this.value;
        });
    });
});
</script>
@endsection
