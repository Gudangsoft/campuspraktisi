# Quick Start Guide - Social Media Icons

## 🎯 Panduan Cepat Mengaktifkan Icon Social Media

### Status: ✅ **READY TO USE**

Sistem social media dinamis sudah **100% siap digunakan**. Anda hanya perlu mengisi URL social media melalui admin panel.

---

## 📋 Langkah-langkah Aktivasi

### 1️⃣ Login ke Admin Panel

```
URL: http://127.0.0.1:8000/admin/login
Username: [your admin username]
Password: [your admin password]
```

### 2️⃣ Buka Menu Settings

Dari dashboard admin:
- Klik menu **"Settings"** di sidebar kiri
- Atau akses langsung: `http://127.0.0.1:8000/admin/settings`

### 3️⃣ Cari Settings Social Media

Di halaman Settings, scroll atau cari settings dengan group **"Social"**:

| No | Setting Name | Action |
|----|-------------|---------|
| 1 | `facebook_url` | Click **Edit** (icon pensil) |
| 2 | `twitter_url` | Click **Edit** |
| 3 | `instagram_url` | Click **Edit** |
| 4 | `youtube_url` | Click **Edit** ⭐ |
| 5 | `linkedin_url` | Click **Edit** ⭐ |
| 6 | `tiktok_url` | Click **Edit** ⭐ |
| 7 | `whatsapp_number` | Click **Edit** ⭐ |

⭐ = Baru ditambahkan

### 4️⃣ Isi URL Social Media

Untuk setiap platform yang ingin ditampilkan:

**Facebook:**
```
Key: facebook_url
Value: https://facebook.com/akperkbn
```

**Twitter:**
```
Key: twitter_url
Value: https://twitter.com/akperkbn
```

**Instagram:**
```
Key: instagram_url
Value: https://instagram.com/akperkbn
```

**YouTube:**
```
Key: youtube_url
Value: https://youtube.com/@akperkbn
```

**LinkedIn:**
```
Key: linkedin_url
Value: https://linkedin.com/company/akperkbn
```

**TikTok:**
```
Key: tiktok_url
Value: https://tiktok.com/@akperkbn
```

**WhatsApp:**
```
Key: whatsapp_number
Value: 628123456789

Format: 
- HARUS dimulai dengan kode negara (62 untuk Indonesia)
- TANPA tanda + di awal
- TANPA spasi, tanda kurung, atau tanda hubung
- Contoh benar: 628123456789
- Contoh salah: +62 812-345-6789
```

### 5️⃣ Simpan Perubahan

- Klik tombol **"Update"** pada setiap setting yang diubah
- Akan muncul notifikasi sukses

### 6️⃣ Lihat Hasilnya

Buka website di browser:
```
http://127.0.0.1:8000/
```

**Icon social media akan muncul di:**
1. **Top Bar** (kanan atas halaman)
2. **Footer** (bawah halaman, kolom "Kontak")

---

## 🎨 Contoh Hasil

### Top Bar (Bagian Atas)
```
┌─────────────────────────────────────────────────────┐
│ ✉ info@akperkbn.ac.id  ☎ (0293) 3149517  🔗 Portal │
│                                    f tw ig yt li tk │
└─────────────────────────────────────────────────────┘
```

### Footer (Bagian Bawah)
```
┌────────────────┐
│ Kontak         │
│ ✉ Email        │
│ ☎ Telepon      │
│                │
│ Ikuti Kami     │
│ ○ ○ ○ ○ ○ ○ ○  │ ← 7 icon social media
└────────────────┘
```

---

## ❓ FAQ (Frequently Asked Questions)

### Q1: Bagaimana jika saya tidak ingin menampilkan semua platform?
**A:** Cukup **kosongkan** field Value untuk platform yang tidak ingin ditampilkan. Icon akan otomatis hilang.

### Q2: Apakah bisa menambah platform lain seperti Telegram?
**A:** Ya, bisa. Hubungi developer untuk menambahkan platform baru ke sistem.

### Q3: Icon tidak muncul setelah saya isi URL, kenapa?
**A:** Cek:
1. Apakah Value sudah disimpan? (klik Update)
2. Apakah sudah refresh browser? (Ctrl+F5)
3. Apakah URL format nya benar? (harus dimulai dengan https://)

### Q4: Untuk WhatsApp, bagaimana format nomor yang benar?
**A:** 
- ✅ Benar: `628123456789`
- ❌ Salah: `+62 812-3456-789`
- ❌ Salah: `0812-3456-789`

### Q5: Apakah bisa mengubah urutan icon?
**A:** Ya, tapi perlu edit code. Hubungi developer jika perlu mengubah urutan.

### Q6: Icon bisa diklik?
**A:** Ya, semua icon adalah link yang bisa diklik dan akan membuka social media di tab baru.

---

## 🧪 Testing

Setelah mengisi URL, test dengan cara:

1. **Test Link:**
   - Klik setiap icon
   - Pastikan membuka halaman social media yang benar

2. **Test Hover:**
   - Arahkan mouse ke icon
   - Pastikan ada efek hover (background orange, icon naik)

3. **Test Responsive:**
   - Buka di HP/tablet
   - Pastikan icon tetap terlihat dan bisa diklik

---

## 📞 Butuh Bantuan?

Jika mengalami kesulitan:
1. Cek dokumentasi lengkap: `SOCIAL_MEDIA_DYNAMIC_FEATURE.md`
2. Hubungi IT Support
3. Buat ticket di project management system

---

## ✅ Checklist Aktivasi

Gunakan checklist ini untuk memastikan semua sudah benar:

- [ ] Login ke admin berhasil
- [ ] Buka menu Settings
- [ ] Edit `facebook_url` (jika diperlukan)
- [ ] Edit `twitter_url` (jika diperlukan)
- [ ] Edit `instagram_url` (jika diperlukan)
- [ ] Edit `youtube_url` (jika diperlukan)
- [ ] Edit `linkedin_url` (jika diperlukan)
- [ ] Edit `tiktok_url` (jika diperlukan)
- [ ] Edit `whatsapp_number` (jika diperlukan)
- [ ] Simpan semua perubahan
- [ ] Refresh homepage
- [ ] Icon muncul di top bar
- [ ] Icon muncul di footer
- [ ] Test klik semua icon
- [ ] Icon membuka halaman yang benar

---

**Last Updated:** 05 November 2025
**Status:** Production Ready ✅