 # 📚 BookNest - Digital Library Platform

![BookNest Logo](https://booknest.aptech.my.id/img/logo.webp)

> **Membuka akses tak terbatas ke ribuan koleksi buku digital, jurnal akademik, dan materi pembelajaran berkualitas untuk mendukung literasi dan pendidaan masyarakat Indonesia.**

## 🌟 Overview

BookNest adalah platform perpustakaan digital modern yang memungkinkan pengguna untuk mencari, meminjam, dan mengakses ribuan koleksi buku digital secara online. Dibangun dengan teknologi web terkini untuk memberikan pengalaman literasi yang optimal.

## ✨ Fitur Utama

### 🔍 **Smart Search Engine**
- Pencarian buku berdasarkan judul, penulis, atau kata kunci
- Filter berdasarkan kategori buku
- Hasil pencarian yang cepat dan akurat

### 📖 **Peminjaman Digital**
- Sistem peminjaman buku online
- Tracking status ketersediaan buku (Tersedia/Dipinjam)
- Form peminjaman dengan validasi data

### 👥 **Komunitas Literasi**
- Platform diskusi untuk komunitas pembaca
- Berbagi rekomendasi buku
- Forum tanya jawab seputar literasi

### 🎓 **E-Learning Resources**
- Akses ke materi pembelajaran gratis
- Jurnal akademik dan paper penelitian
- Resource edukasi berkualitas

### 🔐 **Sistem Autentikasi**
- Login/Register yang aman
- Profile management
- Riwayat peminjaman personal

## 🛠 Tech Stack

### Backend
- **Laravel 10** - PHP Framework
- **MySQL** - Database Management
- **Eloquent ORM** - Database Relationships
- **Laravel Blade** - Template Engine

### Frontend
- **Tailwind CSS** - Utility-first CSS Framework
- **JavaScript (Vanilla)** - Interactive Components
- **Font Awesome** - Icon Library
- **Responsive Design** - Mobile-first Approach

### Tools & Services
- **Composer** - Dependency Management
- **NPM** - Package Manager
- **Git** - Version Control
- **Laravel Mix** - Asset Compilation

## 📦 Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL Database
- Git

### Step-by-Step Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/alii16/booknest.git
   cd booknest
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Configuration**
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=booknest
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile Assets**
   ```bash
   npm run dev
   # or for production
   npm run build
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

   Visit: `http://localhost:8000`

## 🎨 Design System

### Color Palette
- **Primary**: Blue (#3B82F6)
- **Secondary**: Indigo (#6366F1)
- **Accent**: Purple (#8B5CF6)
- **Success**: Green (#10B981)
- **Warning**: Yellow (#F59E0B)
- **Error**: Red (#EF4444)

### Typography
- **Headings**: Inter, sans-serif
- **Body**: Inter, sans-serif
- **Code**: JetBrains Mono, monospace

## 🚀 Usage

### For Users
1. **Browse Books**: Kunjungi halaman daftar buku untuk melihat koleksi
2. **Search & Filter**: Gunakan fitur pencarian dan filter kategori
3. **Login/Register**: Buat akun untuk mengakses fitur peminjaman
4. **Borrow Books**: Pilih buku dan isi form peminjaman
5. **Track Status**: Pantau status peminjaman di dashboard

### For Admins
1. **Book Management**: Tambah, edit, atau hapus buku
2. **User Management**: Kelola data pengguna
3. **Loan Management**: Monitor peminjaman aktif
4. **Category Management**: Kelola kategori buku
5. **Reports**: Generate laporan statistik

## 📱 Screenshots

### Homepage
![Homepage](https://via.placeholder.com/800x400/F8FAFC/374151?text=BookNest+Homepage)

### Book Catalog
![Book Catalog](https://via.placeholder.com/800x400/F8FAFC/374151?text=Book+Catalog+Page)

### Book Detail
![Book Detail](https://via.placeholder.com/800x400/F8FAFC/374151?text=Book+Detail+Modal)

## 🧪 Testing

```bash
# Run PHP Unit Tests
php artisan test

# Run specific test
php artisan test --filter BookTest

# Generate Coverage Report
php artisan test --coverage
```

## 📊 Database Schema

### Books Table
```sql
- id (Primary Key)
- judul (VARCHAR)
- penulis (VARCHAR)
- kategori_id (Foreign Key)
- sampul (VARCHAR, nullable)
- deskripsi (TEXT)
- dipinjam (BOOLEAN, default: false)
- created_at, updated_at
```

### Users Table
```sql
- id (Primary Key)
- name (VARCHAR)
- email (VARCHAR, unique)
- password (VARCHAR)
- role (ENUM: user, admin)
- created_at, updated_at
```

### Loans Table
```sql
- id (Primary Key)
- user_id (Foreign Key)
- book_id (Foreign Key)
- no_hp (VARCHAR)
- alamat (TEXT)
- tanggal_pinjam (DATE)
- tanggal_kembali (DATE, nullable)
- status (ENUM: active, returned)
- created_at, updated_at
```

## 🔧 Configuration

### Environment Variables
```env
APP_NAME=BookNest
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

## 🚦 Roadmap

### Version 1.0 (Current)
- [x] Basic book catalog
- [x] User authentication
- [x] Simple loan system
- [x] Search & filtering
- [x] Responsive design

### Version 1.1 (Coming Soon)
- [ ] Advanced search with filters
- [ ] Book reviews and ratings
- [ ] Email notifications
- [ ] Admin dashboard
- [ ] Book recommendations

### Version 2.0 (Future)
- [ ] Mobile app (React Native)
- [ ] API for third-party integration
- [ ] Advanced analytics
- [ ] Multi-language support
- [ ] AI-powered recommendations

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **Fork the Repository**
2. **Create Feature Branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. **Commit Changes**
   ```bash
   git commit -m 'Add amazing feature'
   ```
4. **Push to Branch**
   ```bash
   git push origin feature/amazing-feature
   ```
5. **Open Pull Request**

### Coding Standards
- Follow PSR-12 coding standards
- Write descriptive commit messages
- Add tests for new features
- Update documentation as needed

## 🐛 Bug Reports

Found a bug? Please create an issue with:
- Clear description of the problem
- Steps to reproduce
- Expected vs actual behavior
- Screenshots (if applicable)
- Environment details

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 👥 Team

### Core Contributors
- **Lead Developer**: [Ali Polanunu](https://github.com/alii16)
- **UI/UX Designer**: [Jesulin](https://github.com/jesulin2004)
- **Frontend Developer**: [Amri Angkotasan](https://github.com/oji1029)
- **Backend Developer**: [Ali Polanunu](https://github.com/alii16)
- **Data Specialist 1**: [Diva Maharachmi](https://github.com/Divaa-web)
- **Data Specialist 2**: [Ana Liana](https://github.com/anaLiana02)
- **Data Specialist 3**: [Ruth Azaria](https://github.com/azaa7757-cmd)

## 📞 Contact & Support

### Official Channels
- **Website**: [https://booknest.aptech.my.id](https://booknest.aptech.my.id)
- **Email**: hello@booknest.id
- **Phone**: +62 21-8765-4321
- **Address**: Jl. Literasi Nusantara No. 123, Ambon, Indonesia

### Social Media
- **Facebook**: [@BookNestID](https://facebook.com/BookNestID)
- **Twitter**: [@BookNest_ID](https://twitter.com/BookNest_ID)
- **Instagram**: [@booknest.id](https://instagram.com/booknest.id)
- **LinkedIn**: [BookNest Indonesia](https://linkedin.com/company/booknest-indonesia)

## 🙏 Acknowledgments

- **Laravel Community** for the amazing framework
- **Tailwind CSS Team** for the utility-first CSS framework
- **Font Awesome** for the beautiful icons
- **Unsplash** for the placeholder images
- **All Contributors** who helped make this project possible

---

<div align="center">

**Made with💡for Indonesian Literacy**

[⭐ Star this project](https://github.com/alii16/booknest) • [🐛 Report Bug](https://github.com/alii16/booknest/issues) • [💡 Request Feature](https://github.com/alii16/booknest/issues
**BookNest © 2025 - Empowering Indonesian Literacy Through Technology**
</div>

