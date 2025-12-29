-- Seed Data untuk SMK Web
-- File ini berisi data dummy untuk testing

USE smkweb;

-- Update Settings
UPDATE settings SET `value` = 'SMK Negeri 1 Jakarta' WHERE `key` = 'site_name';
UPDATE settings SET `value` = 'Membangun Generasi Unggul Berkarakter, Berkompetensi, dan Berwawasan Global' WHERE `key` = 'site_description';
UPDATE settings SET `value` = 'info@smkn1jakarta.sch.id' WHERE `key` = 'site_email';
UPDATE settings SET `value` = '+62 21 1234 5678' WHERE `key` = 'site_phone';
UPDATE settings SET `value` = 'Jl. Pendidikan No. 1, Jakarta Pusat 10110' WHERE `key` = 'site_address';
UPDATE settings SET `value` = 'https://facebook.com/smkn1jakarta' WHERE `key` = 'facebook_url';
UPDATE settings SET `value` = 'https://twitter.com/smkn1jakarta' WHERE `key` = 'twitter_url';
UPDATE settings SET `value` = 'https://instagram.com/smkn1jakarta' WHERE `key` = 'instagram_url';
UPDATE settings SET `value` = 'https://youtube.com/@smkn1jakarta' WHERE `key` = 'youtube_url';

-- Delete existing sample posts and insert new dummy posts
DELETE FROM posts WHERE id > 0;

INSERT INTO posts (title, slug, content, excerpt, category, author_id, status, foto, created_at) VALUES
('Selamat Datang di Website Resmi SMK Negeri 1 Jakarta', 'selamat-datang-di-website-resmi-smk-negeri-1-jakarta', 
'<p>Kami dengan bangga mempersembahkan website resmi SMK Negeri 1 Jakarta yang baru. Website ini dirancang untuk memberikan informasi terkini tentang kegiatan, prestasi, dan program-program unggulan sekolah kami.</p>

<p>SMK Negeri 1 Jakarta merupakan sekolah menengah kejuruan yang telah berdiri sejak tahun 1985 dan memiliki komitmen tinggi dalam mencetak lulusan yang siap kerja, berkarakter, dan memiliki kompetensi di bidangnya masing-masing.</p>

<h3>Visi Kami</h3>
<p>Menjadi sekolah kejuruan unggulan yang menghasilkan lulusan berkarakter, berkompetensi, dan siap menghadapi tantangan global.</p>

<h3>Misi Kami</h3>
<ul>
    <li>Menyelenggarakan pendidikan yang berkualitas dengan kurikulum yang relevan dengan kebutuhan industri</li>
    <li>Mengembangkan karakter siswa melalui pembinaan akhlak mulia dan nilai-nilai luhur</li>
    <li>Meningkatkan kompetensi siswa melalui pembelajaran berbasis praktik dan kerja sama dengan industri</li>
    <li>Mengembangkan sarana dan prasarana yang mendukung proses pembelajaran</li>
</ul>

<p>Mari bergabung bersama kami dalam mewujudkan cita-cita bersama untuk membangun generasi emas Indonesia!</p>', 
'Selamat datang di website resmi SMK Negeri 1 Jakarta. Website ini menyediakan informasi lengkap tentang sekolah, kegiatan, dan program unggulan.',
'Berita', 1, 'published', 'berita-1.jpg', NOW()),

('Pendaftaran Peserta Didik Baru Tahun Ajaran 2024/2025 Dibuka', 'pendaftaran-peserta-didik-baru-tahun-ajaran-2024-2025',
'<p>Bagi calon siswa yang ingin melanjutkan pendidikan di SMK Negeri 1 Jakarta, kami informasikan bahwa <strong>Pendaftaran Peserta Didik Baru (PPDB) Tahun Ajaran 2024/2025</strong> telah dibuka.</p>

<h3>Jadwal Pendaftaran:</h3>
<ul>
    <li><strong>Gelombang 1:</strong> 1 - 15 Februari 2024</li>
    <li><strong>Gelombang 2:</strong> 16 - 28 Februari 2024</li>
    <li><strong>Gelombang 3:</strong> 1 - 15 Maret 2024</li>
</ul>

<h3>Jurusan yang Tersedia:</h3>
<ol>
    <li><strong>Teknik Komputer dan Jaringan (TKJ)</strong></li>
    <li><strong>Rekayasa Perangkat Lunak (RPL)</strong></li>
    <li><strong>Teknik Kendaraan Ringan (TKR)</strong></li>
    <li><strong>Teknik Audio Video (TAV)</strong></li>
    <li><strong>Akuntansi</strong></li>
    <li><strong>Pemasaran</strong></li>
    <li><strong>Multimedia</strong></li>
</ol>

<h3>Persyaratan:</h3>
<ul>
    <li>Foto copy ijazah SMP/MTs yang telah dilegalisir</li>
    <li>Foto copy SKHUN/SKHUS yang telah dilegalisir</li>
    <li>Foto copy akta kelahiran</li>
    <li>Foto copy kartu keluarga</li>
    <li>Pas foto berwarna 3x4 (3 lembar)</li>
    <li>Surat keterangan sehat dari dokter</li>
</ul>

<h3>Cara Pendaftaran:</h3>
<p>Calon siswa dapat melakukan pendaftaran melalui:</p>
<ol>
    <li>Website resmi: www.smkn1jakarta.sch.id/ppdb</li>
    <li>Datang langsung ke sekolah dengan membawa semua persyaratan</li>
    <li>Melalui aplikasi PPDB Online Dinas Pendidikan</li>
</ol>

<p>Untuk informasi lebih lanjut, silakan hubungi bagian Tata Usaha di (021) 1234-5678 atau email ke info@smkn1jakarta.sch.id</p>

<p><strong>Segera daftarkan diri Anda! Kuota terbatas.</strong></p>',
'Pendaftaran PPDB Tahun Ajaran 2024/2025 telah dibuka. Segera daftarkan diri Anda untuk menjadi bagian dari keluarga besar SMK Negeri 1 Jakarta.',
'Pengumuman', 1, 'published', 'berita-2.jpg', DATE_SUB(NOW(), INTERVAL 2 DAY)),

('Tim Futsal SMK Negeri 1 Jakarta Juara 1 Kompetisi Futsal Antar SMK Se-Jabodetabek', 'tim-futsal-smk-negeri-1-jakarta-juara-1',
'<p>Kabar gembira! Tim Futsal SMK Negeri 1 Jakarta berhasil meraih <strong>juara pertama</strong> dalam Kompetisi Futsal Antar SMK Se-Jabodetabek yang diselenggarakan di Gelora Bung Karno pada tanggal 15-20 Januari 2024.</p>

<h3>Perjalanan Menuju Juara</h3>
<p>Tim futsal kami menunjukkan performa luar biasa sepanjang kompetisi. Dalam babak penyisihan, mereka berhasil mengalahkan semua lawan tanpa kekalahan. Di babak semifinal, tim kami mengalahkan SMK Negeri 5 Jakarta dengan skor 4-2, dan di final berhasil mengalahkan SMK Negeri 3 Depok dengan skor 3-1.</p>

<h3>Pemain Terbaik</h3>
<ul>
    <li><strong>Pemain Terbaik:</strong> Muhammad Rizki (Kelas XII TKJ)</li>
    <li><strong>Top Skorer:</strong> Ahmad Fauzi (Kelas XI RPL) - 12 gol</li>
    <li><strong>Best Goalkeeper:</strong> Budi Santoso (Kelas XII TKR)</li>
</ul>

<h3>Jadwal Pelatihan</h3>
<p>Tim futsal kami berlatih rutin setiap Selasa dan Kamis sore di lapangan sekolah. Selain itu, mereka juga mengikuti latihan bersama setiap Sabtu di kompleks olahraga sekolah.</p>

<h3>Prestasi Lainnya</h3>
<p>Selain futsal, sekolah kami juga memiliki tim basket, voli, dan badminton yang aktif mengikuti berbagai kompetisi. Prestasi ini menunjukkan bahwa SMK Negeri 1 Jakarta tidak hanya fokus pada akademik, tetapi juga mengembangkan bakat non-akademik siswa.</p>

<p>Selamat kepada tim futsal SMK Negeri 1 Jakarta! Semoga prestasi ini dapat menjadi motivasi untuk meraih prestasi yang lebih tinggi lagi.</p>',
'Tim Futsal SMK Negeri 1 Jakarta meraih juara pertama Kompetisi Futsal Antar SMK Se-Jabodetabek. Prestasi gemilang ini menunjukkan kualitas atlet sekolah kami.',
'Prestasi', 1, 'published', 'berita-3.jpg', DATE_SUB(NOW(), INTERVAL 5 DAY)),

('Workshop Pemrograman Web dengan PHP dan Laravel untuk Siswa Kelas XII', 'workshop-pemrograman-web-php-laravel',
'<p>Dalam rangka meningkatkan kompetensi siswa di bidang teknologi informasi, SMK Negeri 1 Jakarta mengadakan <strong>Workshop Pemrograman Web dengan PHP dan Laravel</strong> untuk siswa kelas XII jurusan RPL dan TKJ.</p>

<h3>Kegiatan Workshop</h3>
<p>Workshop yang dilaksanakan pada tanggal 22-24 Januari 2024 ini diikuti oleh 60 siswa yang dibagi menjadi 3 kelompok. Workshop dipandu oleh instruktur berpengalaman dari industri teknologi informasi.</p>

<h3>Materi yang Disampaikan:</h3>
<ol>
    <li>Pengenalan Framework Laravel</li>
    <li>Setup Development Environment</li>
    <li>MVC Pattern dalam Laravel</li>
    <li>Database Migration dan Eloquent ORM</li>
    <li>Membuat RESTful API</li>
    <li>Frontend Integration dengan Vue.js</li>
    <li>Deployment Application</li>
</ol>

<h3>Output Workshop</h3>
<p>Di akhir workshop, setiap peserta diharapkan dapat membuat aplikasi web sederhana menggunakan Laravel. Beberapa proyek terbaik akan dipamerkan dalam pameran teknologi yang akan diadakan bulan depan.</p>

<h3>Testimoni Peserta</h3>
<blockquote>
    "Workshop ini sangat membantu saya memahami framework Laravel. Materinya jelas dan praktis, langsung bisa diterapkan untuk membuat aplikasi web profesional." - Sinta, Siswi Kelas XII RPL
</blockquote>

<blockquote>
    "Instrukturnya sangat berpengalaman dan sabar dalam menjelaskan. Sekarang saya lebih percaya diri untuk terjun ke dunia kerja sebagai web developer." - Andi, Siswa Kelas XII TKJ
</blockquote>

<h3>Kerjasama Industri</h3>
<p>Workshop ini merupakan bagian dari program kerjasama sekolah dengan beberapa perusahaan teknologi di Jakarta. Program ini bertujuan untuk mempersiapkan siswa agar siap kerja setelah lulus dari SMK.</p>

<p>Kegiatan seperti ini akan terus dilaksanakan secara rutin untuk meningkatkan kompetensi siswa sesuai dengan tuntutan industri 4.0.</p>',
'Workshop pemrograman web menggunakan PHP dan Laravel berhasil dilaksanakan. Siswa mendapatkan pengalaman langsung dalam mengembangkan aplikasi web modern.',
'Kegiatan', 1, 'published', 'berita-4.jpg', DATE_SUB(NOW(), INTERVAL 7 DAY)),

('Siswa SMK Negeri 1 Jakarta Lulus Seleksi Magang di Perusahaan Teknologi Terkemuka', 'siswa-lulus-seleksi-magang-perusahaan-teknologi',
'<p>Kabar membanggakan! Sebanyak <strong>25 siswa SMK Negeri 1 Jakarta</strong> berhasil lulus seleksi magang di berbagai perusahaan teknologi terkemuka di Indonesia.</p>

<h3>Perusahaan Tujuan Magang:</h3>
<ul>
    <li><strong>PT. Gojek Indonesia</strong> - 8 siswa (Jurusan RPL & TKJ)</li>
    <li><strong>PT. Tokopedia</strong> - 6 siswa (Jurusan RPL)</li>
    <li><strong>PT. Telkom Indonesia</strong> - 5 siswa (Jurusan TKJ)</li>
    <li><strong>PT. Bank Mandiri</strong> - 4 siswa (Jurusan Akuntansi)</li>
    <li><strong>PT. Indosat Ooredoo</strong> - 2 siswa (Jurusan TKJ)</li>
</ul>

<h3>Program Magang</h3>
<p>Program magang ini akan dilaksanakan selama 6 bulan mulai bulan Februari 2024. Selama magang, siswa akan mendapatkan:</p>
<ul>
    <li>Pengalaman kerja langsung di industri</li>
    <li>Mentoring dari profesional berpengalaman</li>
    <li>Sertifikat magang yang diakui industri</li>
    <li>Kesempatan untuk dipekerjakan setelah lulus</li>
</ul>

<h3>Persiapan Seleksi</h3>
<p>Proses seleksi meliputi:</p>
<ol>
    <li>Seleksi administrasi (pengecekan dokumen dan nilai)</li>
    <li>Test kemampuan teknis sesuai jurusan</li>
    <li>Interview dengan HRD dan technical team</li>
    <li>Test soft skills dan teamwork</li>
</ol>

<h3>Dukungan Sekolah</h3>
<p>Sekolah memberikan dukungan penuh kepada siswa yang akan magang, antara lain:</p>
<ul>
    <li>Pembekalan soft skills sebelum magang</li>
    <li>Pembimbing khusus untuk monitoring selama magang</li>
    <li>Koordinasi rutin dengan perusahaan tempat magang</li>
    <li>Pendampingan dalam penyusunan laporan magang</li>
</ul>

<h3>Harapan ke Depan</h3>
<p>Dengan program magang ini, diharapkan siswa dapat:</p>
<ul>
    <li>Mengasah kompetensi sesuai kebutuhan industri</li>
    <li>Membangun network profesional</li>
    <li>Meningkatkan peluang kerja setelah lulus</li>
    <li>Mengimplementasikan ilmu yang didapat di sekolah</li>
</ul>

<p>Selamat kepada semua siswa yang lulus seleksi! Semoga magang kalian berjalan lancar dan memberikan pengalaman berharga.</p>',
'Sebanyak 25 siswa SMK Negeri 1 Jakarta lulus seleksi magang di perusahaan teknologi terkemuka. Prestasi ini membuktikan kualitas lulusan sekolah kami.',
'Pengumuman', 1, 'published', 'berita-5.jpg', DATE_SUB(NOW(), INTERVAL 10 DAY)),

('Kunjungan Industri ke PT. Astra Daihatsu Motor untuk Siswa Jurusan TKR', 'kunjungan-industri-pt-astra-daihatsu-motor',
'<p>Sebanyak <strong>45 siswa kelas XI dan XII jurusan Teknik Kendaraan Ringan (TKR)</strong> melakukan kunjungan industri ke PT. Astra Daihatsu Motor di Karawang, Jawa Barat pada tanggal 18 Januari 2024.</p>

<h3>Tujuan Kunjungan</h3>
<p>Kunjungan industri ini bertujuan untuk:</p>
<ul>
    <li>Memberikan wawasan langsung tentang proses produksi kendaraan bermotor</li>
    <li>Memahami teknologi terbaru dalam industri otomotif</li>
    <li>Mengamati sistem quality control dan safety di industri</li>
    <li>Membangun networking dengan industri</li>
</ul>

<h3>Agenda Kunjungan</h3>
<ol>
    <li><strong>08.00 - 09.00:</strong> Registrasi dan briefing keamanan</li>
    <li><strong>09.00 - 10.30:</strong> Kunjungan ke area produksi mesin</li>
    <li><strong>10.30 - 11.00:</strong> Coffee break</li>
    <li><strong>11.00 - 12.30:</strong> Kunjungan ke area perakitan kendaraan</li>
    <li><strong>12.30 - 13.30:</strong> Istirahat dan makan siang</li>
    <li><strong>13.30 - 15.00:</strong> Kunjungan ke quality control dan testing area</li>
    <li><strong>15.00 - 16.00:</strong> Diskusi dan tanya jawab</li>
</ol>

<h3>Hal yang Dipelajari</h3>
<p>Selama kunjungan, siswa mendapatkan banyak ilmu baru tentang:</p>
<ul>
    <li>Proses manufacturing modern dengan teknologi robotik</li>
    <li>Sistem Just-In-Time (JIT) dalam produksi</li>
    <li>Teknologi engine terbaru dengan efisiensi tinggi</li>
    <li>Sistem quality assurance yang ketat</li>
    <li>Keselamatan kerja di industri otomotif</li>
</ul>

<h3>Kesimpulan</h3>
<p>Kunjungan industri ini sangat bermanfaat bagi siswa untuk memahami dunia kerja nyata. Mereka dapat melihat langsung bagaimana teori yang dipelajari di sekolah diterapkan dalam industri. Kegiatan seperti ini akan terus dilakukan secara rutin untuk berbagai jurusan.</p>

<p>Terima kasih kepada PT. Astra Daihatsu Motor yang telah memberikan kesempatan kepada siswa kami untuk belajar langsung di industri.</p>',
'Siswa jurusan TKR melakukan kunjungan industri ke PT. Astra Daihatsu Motor untuk memahami proses produksi kendaraan bermotor secara langsung.',
'Kegiatan', 1, 'published', 'berita-6.jpg', DATE_SUB(NOW(), INTERVAL 12 DAY));

-- Update Pages
UPDATE pages SET content = '<div class="page-content">
<h2>Tentang SMK Negeri 1 Jakarta</h2>

<p>SMK Negeri 1 Jakarta merupakan salah satu Sekolah Menengah Kejuruan (SMK) terkemuka di Jakarta yang telah berdiri sejak tahun 1985. Sekolah ini memiliki komitmen kuat dalam menyelenggarakan pendidikan kejuruan yang berkualitas untuk mencetak lulusan yang siap kerja dan berkarakter.</p>

<h3>Visi</h3>
<p>Menjadi sekolah kejuruan unggulan yang menghasilkan lulusan berkarakter, berkompetensi, dan siap menghadapi tantangan global di era Industri 4.0.</p>

<h3>Misi</h3>
<ul>
    <li>Menyelenggarakan pendidikan kejuruan yang berkualitas dengan kurikulum yang relevan dengan kebutuhan industri</li>
    <li>Mengembangkan karakter siswa melalui pembinaan akhlak mulia, disiplin, dan nilai-nilai luhur bangsa</li>
    <li>Meningkatkan kompetensi siswa melalui pembelajaran berbasis praktik dan kerja sama dengan dunia industri</li>
    <li>Mengembangkan sarana dan prasarana yang modern dan memadai untuk mendukung proses pembelajaran</li>
    <li>Membangun jaringan kerjasama yang luas dengan dunia industri dan perguruan tinggi</li>
    <li>Mengembangkan budaya mutu sekolah yang berkelanjutan</li>
</ul>

<h3>Jurusan yang Tersedia</h3>
<div class="row">
    <div class="col-md-6">
        <h4>Teknik Komputer dan Jaringan (TKJ)</h4>
        <p>Jurusan yang fokus pada pengelolaan jaringan komputer, perakitan komputer, dan troubleshooting perangkat IT.</p>
    </div>
    <div class="col-md-6">
        <h4>Rekayasa Perangkat Lunak (RPL)</h4>
        <p>Jurusan yang mempelajari pengembangan aplikasi desktop, web, dan mobile dengan berbagai bahasa pemrograman.</p>
    </div>
    <div class="col-md-6">
        <h4>Teknik Kendaraan Ringan (TKR)</h4>
        <p>Jurusan yang mengajarkan perawatan, perbaikan, dan modifikasi kendaraan roda empat dan sepeda motor.</p>
    </div>
    <div class="col-md-6">
        <h4>Teknik Audio Video (TAV)</h4>
        <p>Jurusan yang mempelajari perakitan, perawatan, dan perbaikan peralatan audio video dan elektronika.</p>
    </div>
    <div class="col-md-6">
        <h4>Akuntansi</h4>
        <p>Jurusan yang mengajarkan pengelolaan keuangan, pembukuan, dan administrasi bisnis.</p>
    </div>
    <div class="col-md-6">
        <h4>Pemasaran</h4>
        <p>Jurusan yang fokus pada strategi pemasaran, penjualan, dan manajemen ritel.</p>
    </div>
</div>

<h3>Fasilitas Sekolah</h3>
<ul>
    <li>Laboratorium komputer dengan spesifikasi tinggi</li>
    <li>Bengkel otomotif yang lengkap</li>
    <li>Laboratorium multimedia dan broadcasting</li>
    <li>Perpustakaan digital dengan koleksi lengkap</li>
    <li>Lapangan olahraga (basket, voli, futsal)</li>
    <li>Masjid sekolah</li>
    <li>Kantin sehat</li>
    <li>Ruang multimedia</li>
    <li>WiFi sekolah berkecepatan tinggi</li>
</ul>

<h3>Prestasi</h3>
<p>SMK Negeri 1 Jakarta telah meraih berbagai prestasi di tingkat lokal, regional, dan nasional, antara lain:</p>
<ul>
    <li>Juara 1 Lomba Kompetensi Siswa (LKS) Tingkat Provinsi</li>
    <li>Juara 1 Kompetisi Futsal Antar SMK Se-Jabodetabek</li>
    <li>Sekolah Adiwiyata Tingkat Provinsi</li>
    <li>Sertifikasi ISO 9001:2015</li>
</ul>
</div>' WHERE slug = 'tentang-kami';

UPDATE pages SET content = '<div class="page-content">
<h2>Hubungi Kami</h2>
<p>Kami siap membantu menjawab pertanyaan Anda tentang SMK Negeri 1 Jakarta. Silakan hubungi kami melalui informasi kontak di bawah ini:</p>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="contact-info">
            <h4><i class="bi bi-geo-alt-fill"></i> Alamat</h4>
            <p>Jl. Pendidikan No. 1<br>
            Jakarta Pusat 10110<br>
            DKI Jakarta, Indonesia</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="contact-info">
            <h4><i class="bi bi-telephone-fill"></i> Telepon</h4>
            <p>Telp: (021) 1234-5678<br>
            Fax: (021) 1234-5679<br>
            WhatsApp: +62 812-3456-7890</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="contact-info">
            <h4><i class="bi bi-envelope-fill"></i> Email</h4>
            <p>Email: info@smkn1jakarta.sch.id<br>
            Website: www.smkn1jakarta.sch.id</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="contact-info">
            <h4><i class="bi bi-clock-fill"></i> Jam Pelayanan</h4>
            <p>Senin - Jumat: 07.00 - 16.00 WIB<br>
            Sabtu: 07.00 - 12.00 WIB<br>
            Minggu & Hari Libur: Tutup</p>
        </div>
    </div>
</div>

<h3 class="mt-5">Lokasi Sekolah</h3>
<div class="map-container mt-3" style="height: 400px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
    <p class="text-muted">Peta lokasi akan muncul di sini</p>
</div>

<h3 class="mt-5">Media Sosial</h3>
<div class="social-links-contact mt-3">
    <a href="#" class="btn btn-primary me-2"><i class="bi bi-facebook"></i> Facebook</a>
    <a href="#" class="btn btn-danger me-2"><i class="bi bi-instagram"></i> Instagram</a>
    <a href="#" class="btn btn-info me-2"><i class="bi bi-twitter"></i> Twitter</a>
    <a href="#" class="btn btn-danger"><i class="bi bi-youtube"></i> YouTube</a>
</div>
</div>' WHERE slug = 'kontak';

-- Insert Gallery Items (without images first, images will be downloaded via script)
DELETE FROM gallery WHERE id > 0;

-- Insert Carousel Items
INSERT INTO carousel (title, description, image, link, link_text, order_position, status, created_at) VALUES
('Selamat Datang di SMK Negeri 1 Jakarta', 'Membangun Generasi Unggul Berkarakter, Berkompetensi, dan Berwawasan Global', 'carousel-1.jpg', '/posts', 'Lihat Berita', 1, 'active', NOW()),
('Pendaftaran Peserta Didik Baru 2024/2025', 'Segera daftarkan diri Anda untuk menjadi bagian dari keluarga besar SMK Negeri 1 Jakarta', 'carousel-2.jpg', '/page/tentang-kami', 'Tentang Kami', 2, 'active', NOW()),
('Prestasi Gemilang di Berbagai Kompetisi', 'Tim sekolah kami terus meraih prestasi di tingkat regional dan nasional', 'carousel-3.jpg', '/gallery', 'Lihat Galeri', 3, 'active', NOW());

INSERT INTO gallery (title, description, image, category, status, created_at) VALUES
('Upacara Bendera Hari Senin', 'Upacara bendera rutin setiap hari Senin sebagai bentuk pembinaan karakter dan nasionalisme siswa', 'dummy-1.jpg', 'Kegiatan Sekolah', 'active', DATE_SUB(NOW(), INTERVAL 5 DAY)),
('Pelatihan Praktik Siswa TKJ', 'Siswa jurusan TKJ sedang melakukan praktik instalasi jaringan komputer', 'dummy-2.jpg', 'Pembelajaran', 'active', DATE_SUB(NOW(), INTERVAL 4 DAY)),
('Lomba P5 (Projek Penguatan Profil Pelajar Pancasila)', 'Siswa memamerkan hasil projek P5 yang mengangkat tema kearifan lokal', 'dummy-3.jpg', 'Kegiatan Sekolah', 'active', DATE_SUB(NOW(), INTERVAL 3 DAY)),
('Kunjungan Industri ke PT Astra', 'Siswa jurusan TKR melakukan kunjungan industri ke pabrik otomotif', 'dummy-4.jpg', 'Kegiatan Luar', 'active', DATE_SUB(NOW(), INTERVAL 10 DAY)),
('Workshop Pemrograman Web', 'Workshop pemrograman web dengan framework Laravel untuk siswa RPL', 'dummy-5.jpg', 'Pembelajaran', 'active', DATE_SUB(NOW(), INTERVAL 7 DAY)),
('Penghargaan Siswa Berprestasi', 'Penyerahan penghargaan kepada siswa berprestasi di berbagai bidang', 'dummy-6.jpg', 'Prestasi', 'active', DATE_SUB(NOW(), INTERVAL 2 DAY)),
('Ekstrakurikuler Futsal', 'Kegiatan ekstrakurikuler futsal untuk mengembangkan bakat olahraga siswa', 'dummy-7.jpg', 'Ekstrakurikuler', 'active', DATE_SUB(NOW(), INTERVAL 1 DAY)),
('Praktik Siswa Akuntansi', 'Siswa jurusan Akuntansi sedang melakukan praktik pembukuan', 'dummy-8.jpg', 'Pembelajaran', 'active', DATE_SUB(NOW(), INTERVAL 6 DAY)),
('Bazar Sekolah', 'Bazar sekolah dalam rangka penggalangan dana untuk kegiatan sosial', 'dummy-9.jpg', 'Kegiatan Sekolah', 'active', DATE_SUB(NOW(), INTERVAL 8 DAY)),
('Tim Basket Putra', 'Tim basket putra SMK Negeri 1 Jakarta setelah meraih juara harapan', 'dummy-10.jpg', 'Prestasi', 'active', DATE_SUB(NOW(), INTERVAL 9 DAY)),
('Praktik Siswa Multimedia', 'Siswa jurusan Multimedia sedang mengerjakan projek video editing', 'dummy-11.jpg', 'Pembelajaran', 'active', DATE_SUB(NOW(), INTERVAL 11 DAY)),
('Kegiatan Pramuka', 'Kegiatan kepramukaan untuk membentuk karakter dan kedisiplinan siswa', 'dummy-12.jpg', 'Ekstrakurikuler', 'active', DATE_SUB(NOW(), INTERVAL 13 DAY));

