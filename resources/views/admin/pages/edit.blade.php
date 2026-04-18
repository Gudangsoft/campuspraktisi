@extends('admin.layout')

@section('title','Edit Page')
@section('page-title', 'Edit Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Pages</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.pages.update', $page->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    <div class="col-lg-8">
        <div class="content-card mb-3">
            <div class="content-card-header">
                <h5><i class="fas fa-edit me-2"></i>Edit: {{ $page->title }}</h5>
            </div>

            <div class="mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       required value="{{ old('title', $page->title) }}" placeholder="Masukkan judul halaman">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                       value="{{ old('slug', $page->slug) }}" placeholder="auto-generate dari title">
                <small class="text-muted">Kosongkan untuk auto-generate dari title. Contoh: tentang-kami</small>
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Excerpt (Ringkasan)</label>
                <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" 
                          rows="3" placeholder="Ringkasan singkat halaman">{{ old('excerpt', $page->excerpt) }}</textarea>
                @error('excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Content (Konten Lengkap) <span class="text-danger">*</span></label>
                
                <!-- AI Writing Assistant -->
                <div class="card bg-light mb-2">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-robot me-2 text-primary"></i>AI Writing Assistant</h6>
                                <small class="text-muted">Gunakan AI untuk membantu menulis konten</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#aiAssistantModal">
                                <i class="fas fa-magic me-1"></i>Buka AI Assistant
                            </button>
                        </div>
                    </div>
                </div>
                
                <div id="editor-content" style="height: 400px; background: white;"></div>
                <input type="hidden" name="content" id="hidden-content" value="{{ old('content', $page->content) }}" required>
                @error('content')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card mb-3">
            <h6 class="mb-3"><i class="fas fa-cog me-2"></i>Pengaturan</h6>
            
            <div class="mb-3">
                <label class="form-label">Template <span class="text-danger">*</span></label>
                <select name="template" class="form-select @error('template') is-invalid @enderror" required>
                    <option value="default" {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>Default</option>
                    <option value="landing" {{ old('template', $page->template) == 'landing' ? 'selected' : '' }}>Landing Page</option>
                    <option value="contact" {{ old('template', $page->template) == 'contact' ? 'selected' : '' }}>Contact Page</option>
                </select>
                @error('template')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Featured Image</label>
                @if($page->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$page->image) }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;" alt="{{ $page->title }}">
                        <p class="mt-2 mb-0"><small class="text-muted">Current image</small></p>
                    </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Max 2MB. Format: JPG, PNG, GIF</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Order (Urutan)</label>
                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                       value="{{ old('order', $page->order) }}" min="0">
                <small class="text-muted">Semakin kecil, semakin awal tampil</small>
                @error('order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                       value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    <strong>Active</strong> <small class="text-muted">- Halaman akan tampil di website</small>
                </label>
            </div>
        </div>

        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-link me-2"></i>Link Halaman</h6>
            <p class="small mb-2"><strong>Public URL:</strong></p>
            <p class="small"><code>{{ route('page.show', $page->slug) }}</code></p>
            <a href="{{ route('page.show', $page->slug) }}" class="btn btn-sm btn-outline-info" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i> Lihat Halaman
            </a>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> Update Halaman
    </button>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-times me-1"></i> Batal
    </a>
</div>

</form>
@endsection

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor-content', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean']
            ]
        },
        placeholder: 'Tulis konten halaman di sini...'
    });

    // Set initial content
    var initialContent = document.querySelector('#hidden-content').value;
    if (initialContent) {
        var delta = quill.clipboard.convert(initialContent);
        quill.setContents(delta);
    }

    // Update hidden field on content change
    quill.on('text-change', function() {
        var html = quill.root.innerHTML;
        document.querySelector('#hidden-content').value = html;
    });

    // Ensure content is updated before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        var html = quill.root.innerHTML;
        document.querySelector('#hidden-content').value = html;
        
        // Validate content is not empty
        var text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault();
            alert('Content tidak boleh kosong!');
            return false;
        }
    });

    // AI Writing Assistant functionality
    const aiModal = new bootstrap.Modal(document.getElementById('aiAssistantModal'));
    let aiGenerating = false;

    document.getElementById('generateAI').addEventListener('click', async function() {
        const prompt = document.getElementById('aiPrompt').value.trim();
        const action = document.getElementById('aiAction').value;
        
        if (!prompt && action !== 'continue') {
            alert('Masukkan prompt atau pilih aksi!');
            return;
        }

        if (aiGenerating) return;
        aiGenerating = true;

        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Generating...';
        btn.disabled = true;

        try {
            const currentContent = quill.getText();
            
            const response = await fetch('{{ route("admin.ai.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    prompt: prompt,
                    action: action,
                    current_content: currentContent
                })
            });

            const data = await response.json();

            if (data.success) {
                const resultDiv = document.getElementById('aiResult');
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <strong><i class="fas fa-check-circle me-2"></i>Generated Content:</strong>
                        <div class="mt-2 p-3 bg-white rounded border">${data.content}</div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-success" onclick="insertAIContent('${escapeHtml(data.content)}', 'insert')">
                            <i class="fas fa-plus-circle me-1"></i>Insert at Cursor
                        </button>
                        <button type="button" class="btn btn-primary" onclick="insertAIContent('${escapeHtml(data.content)}', 'replace')">
                            <i class="fas fa-exchange-alt me-1"></i>Replace All
                        </button>
                        <button type="button" class="btn btn-warning" onclick="insertAIContent('${escapeHtml(data.content)}', 'append')">
                            <i class="fas fa-arrow-down me-1"></i>Append to End
                        </button>
                    </div>
                `;
            } else {
                document.getElementById('aiResult').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>${data.message || 'Terjadi kesalahan'}
                    </div>
                `;
            }
        } catch (error) {
            document.getElementById('aiResult').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error: ${error.message}
                </div>
            `;
        } finally {
            aiGenerating = false;
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });

    document.querySelectorAll('.quick-ai-action').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            document.getElementById('aiAction').value = action;
            
            const prompts = {
                'headline': 'Buat judul yang menarik',
                'introduction': 'Buat paragraf pembuka',
                'conclusion': 'Buat paragraf penutup',
                'expand': 'Kembangkan konten menjadi lebih detail',
                'summarize': 'Buat ringkasan dari konten yang ada'
            };
            
            if (prompts[action]) {
                document.getElementById('aiPrompt').value = prompts[action];
            }
        });
    });

    function escapeHtml(text) {
        return text.replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/\n/g, '\\n');
    }

    window.insertAIContent = function(content, mode) {
        content = content.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\n/g, '\n');
        
        if (mode === 'replace') {
            quill.setContents([]);
            quill.clipboard.dangerouslyPasteHTML(0, content);
        } else if (mode === 'append') {
            const length = quill.getLength();
            quill.clipboard.dangerouslyPasteHTML(length, '<p><br></p>' + content);
        } else {
            const range = quill.getSelection() || { index: quill.getLength() };
            quill.clipboard.dangerouslyPasteHTML(range.index, content);
        }
        
        aiModal.hide();
        document.getElementById('aiResult').innerHTML = '';
        document.getElementById('aiPrompt').value = '';
    };
</script>

<!-- AI Assistant Modal -->
<div class="modal fade" id="aiAssistantModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-robot me-2"></i>AI Writing Assistant</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Quick Actions</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary quick-ai-action" data-action="headline">
                            <i class="fas fa-heading me-1"></i>Generate Headline
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary quick-ai-action" data-action="introduction">
                            <i class="fas fa-paragraph me-1"></i>Write Introduction
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary quick-ai-action" data-action="expand">
                            <i class="fas fa-expand me-1"></i>Expand Content
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary quick-ai-action" data-action="summarize">
                            <i class="fas fa-compress me-1"></i>Summarize
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary quick-ai-action" data-action="conclusion">
                            <i class="fas fa-flag-checkered me-1"></i>Write Conclusion
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="aiAction" class="form-label fw-bold">AI Action</label>
                    <select class="form-select" id="aiAction">
                        <option value="generate">Generate New Content</option>
                        <option value="continue">Continue Writing</option>
                        <option value="rewrite">Rewrite/Improve</option>
                        <option value="expand">Expand Content</option>
                        <option value="summarize">Summarize</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="aiPrompt" class="form-label fw-bold">Your Prompt</label>
                    <textarea class="form-control" id="aiPrompt" rows="3" 
                        placeholder="Contoh: Tulis konten tentang visi misi kampus..."></textarea>
                    <small class="text-muted">Berikan instruksi yang jelas untuk hasil terbaik</small>
                </div>

                <button type="button" class="btn btn-primary w-100" id="generateAI">
                    <i class="fas fa-magic me-2"></i>Generate Content
                </button>

                <div id="aiResult" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

@endsection
