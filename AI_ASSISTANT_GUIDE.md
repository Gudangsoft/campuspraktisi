# AI Writing Assistant - Documentation

## Overview
Fitur AI Writing Assistant terintegrasi dalam text editor Quill.js untuk membantu admin menulis konten berita dan halaman dengan lebih cepat dan efisien menggunakan teknologi AI.

## Features

### 1. **Quick Actions**
Tombol cepat untuk aksi umum:
- **Generate Headline** - Membuat judul yang menarik
- **Write Introduction** - Menulis paragraf pembuka
- **Expand Content** - Mengembangkan konten menjadi lebih detail
- **Summarize** - Membuat ringkasan konten
- **Write Conclusion** - Menulis paragraf penutup

### 2. **AI Actions**
- **Generate New Content** - Membuat konten baru dari scratch berdasarkan prompt
- **Continue Writing** - Melanjutkan penulisan dari konten yang sudah ada
- **Rewrite/Improve** - Menulis ulang konten dengan lebih baik
- **Expand Content** - Menambah detail dan kedalaman konten
- **Summarize** - Merangkum konten menjadi lebih ringkas

### 3. **Content Insertion Options**
Setelah AI menghasilkan konten, tersedia 3 pilihan:
- **Insert at Cursor** - Sisipkan di posisi kursor
- **Replace All** - Ganti semua konten
- **Append to End** - Tambahkan di akhir konten

## Setup Instructions

### 1. Configuration (Optional - for Real AI)

Jika ingin menggunakan OpenAI API (opsional):

1. Dapatkan API key dari: https://platform.openai.com/api-keys

2. Tambahkan ke file `.env`:
```env
OPENAI_API_KEY=sk-your-api-key-here
OPENAI_MODEL=gpt-3.5-turbo
```

3. Jalankan:
```bash
php artisan config:clear
```

### 2. Demo Mode

**Fitur AI akan tetap berfungsi tanpa API key!**

Jika `OPENAI_API_KEY` tidak dikonfigurasi, sistem akan menggunakan **mock/demo content** yang sudah diprogram. Ini berguna untuk:
- Testing dan development
- Demonstrasi fitur
- Menghindari biaya API saat development

## How to Use

### Untuk News (Berita)

1. Buka Admin Panel → News → Create atau Edit
2. Klik tombol **"Buka AI Assistant"** di atas text editor
3. Pilih Quick Action atau tulis prompt custom
4. Pilih AI Action yang sesuai
5. Klik **"Generate Content"**
6. Pilih cara memasukkan konten (Insert/Replace/Append)

### Untuk Pages (Halaman)

1. Buka Admin Panel → Pages → Create atau Edit
2. Klik tombol **"Buka AI Assistant"** di atas text editor
3. Ikuti langkah yang sama seperti News

## Example Prompts

### Berita Kampus
```
"Tulis berita tentang seminar teknologi AI yang diadakan di kampus dengan 200 peserta"
"Buat pengumuman tentang pendaftaran beasiswa untuk mahasiswa berprestasi"
"Tulis liputan kegiatan wisuda angkatan 2024"
```

### Halaman Institusi
```
"Tulis konten tentang visi dan misi universitas yang berfokus pada inovasi"
"Buat deskripsi fasilitas perpustakaan kampus"
"Tulis tentang sejarah pendirian institusi"
```

## Technical Details

### Files Modified/Created

1. **Views - News Forms:**
   - `resources/views/admin/news/create.blade.php`
   - `resources/views/admin/news/edit.blade.php`

2. **Views - Pages Forms:**
   - `resources/views/admin/pages/create.blade.php`
   - `resources/views/admin/pages/edit.blade.php`

3. **Backend Controller:**
   - `app/Http/Controllers/Admin/AIController.php`

4. **Routes:**
   - `routes/web.php` (added AI generate route)

5. **Configuration:**
   - `.env.example` (added OpenAI config)

### API Endpoint

```
POST /admin/ai/generate
```

**Request Body:**
```json
{
    "prompt": "User's instruction",
    "action": "generate|continue|rewrite|expand|summarize",
    "current_content": "Existing editor content"
}
```

**Response:**
```json
{
    "success": true,
    "content": "<p>Generated HTML content...</p>",
    "note": "Demo mode - Configure OPENAI_API_KEY..." // only in demo mode
}
```

### System Prompts

Controller menggunakan system prompt yang berbeda untuk setiap action:

- **Generate**: "Tulis konten berita yang informatif, menarik, dan profesional dalam Bahasa Indonesia..."
- **Continue**: "Lanjutkan penulisan konten yang sudah ada dengan gaya dan konteks yang konsisten..."
- **Rewrite**: "Tulis ulang konten berikut dengan lebih baik, lebih menarik, dan lebih profesional..."
- **Expand**: "Kembangkan konten berikut menjadi lebih detail dan komprehensif..."
- **Summarize**: "Buat ringkasan singkat dan padat dari konten berikut..."

## Benefits

1. **Productivity**: Mempercepat penulisan konten hingga 3-5x
2. **Quality**: AI membantu struktur dan tata bahasa yang lebih baik
3. **Consistency**: Gaya penulisan yang konsisten
4. **Ideas**: Membantu ketika mengalami writer's block
5. **Flexibility**: Dapat digunakan dengan atau tanpa API key

## Limitations (Demo Mode)

Ketika menggunakan demo mode (tanpa API key):
- Konten yang dihasilkan adalah template pre-written
- Tidak dapat menyesuaikan dengan prompt spesifik
- Cocok untuk testing UI/UX saja

## Cost Considerations (Real AI Mode)

Jika menggunakan OpenAI API:
- **GPT-3.5-turbo**: ~$0.002 per 1K tokens (sangat murah)
- **GPT-4**: ~$0.06 per 1K tokens (lebih mahal tapi lebih baik)
- Average generation: ~500 tokens = $0.001 - $0.03 per request

Estimasi biaya bulanan dengan 1000 requests:
- GPT-3.5: ~$2-5/bulan
- GPT-4: ~$30-60/bulan

## Security

- Route dilindungi dengan `auth` middleware
- CSRF token protection
- API key tidak exposed ke frontend
- Error handling untuk failed requests
- Timeout 30 detik untuk prevent hanging

## Troubleshooting

### AI Modal tidak muncul
- Pastikan Bootstrap JS sudah loaded
- Check console untuk JavaScript errors

### "Terjadi kesalahan" saat generate
- Check `.env` configuration
- Verify API key valid
- Check internet connection
- Review Laravel logs: `storage/logs/laravel.log`

### Content tidak ter-insert
- Refresh halaman dan coba lagi
- Check browser console untuk errors
- Pastikan Quill editor sudah fully initialized

## Future Enhancements

Possible improvements:
1. **Tone Selection**: Formal, casual, academic, etc.
2. **Language Selection**: EN/ID toggle
3. **Image Generation**: AI-generated images untuk artikel
4. **SEO Optimization**: Auto-generate meta descriptions
5. **Content Templates**: Pre-made templates untuk berbagai jenis berita
6. **Batch Processing**: Generate multiple articles at once
7. **History**: Save generated content history

## Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console (F12)
3. Verify environment configuration
4. Test with demo mode first before using real API

---

**Version**: 1.0  
**Last Updated**: 2024  
**Compatible with**: Laravel 10/11, Quill.js 1.3.6
