# 🏢 Room-Booking Management System
## ระบบจัดการการจองห้องประชุมและห้องเรียน

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
</p>

## 📋 ภาพรวมระบบ
ระบบจัดการการจองห้องประชุมและห้องเรียนเป็นแพลตฟอร์มเว็บแอปพลิเคชันที่พัฒนาด้วย Laravel Framework สำหรับจัดการการจองห้องในองค์กรหรือสถาบันการศึกษา ระบบนี้รองรับการทำงานสองบทบาทหลัก: **ผู้ใช้ทั่วไป** (นักศึกษา/อาจารย์) และ **ผู้ดูแลระบบ** (Admin)

### 🎯 วัตถุประสงค์หลัก
- จัดการการจองห้องประชุมและห้องเรียนอย่างเป็นระบบ
- ลดความซ้ำซ้อนและความขัดแย้งในการจองห้อง
- ให้ข้อมูลสถิติและการวิเคราะห์สำหรับการตัดสินใจ
- สร้างรายงาน PDF สำหรับการนำเสนอ

---

## ✨ คุณสมบัติหลัก

### 👤 สำหรับผู้ใช้ทั่วไป
- ✅ **ระบบลงทะเบียนและเข้าสู่ระบบ** - ด้วย Laravel Breeze Authentication
- ✅ **แดชบอร์ดแสดงสถานะห้อง** - แสดงห้องว่าง/ไม่ว่าง/กำลังซ่อมบำรุง
- ✅ **ระบบจองห้องออนไลน์** - เลือกวันที่และเวลาได้อย่างยืดหยุ่น
- ✅ **ปฏิทินแสดงการจอง** - มุมมองปฏิทินสำหรับดูการจองทั้งหมด
- ✅ **จัดการการจองของตัวเอง** - ยกเลิกการจองที่ยังไม่ได้รับการอนุมัติ
- ✅ **โปรไฟล์ผู้ใช้** - แก้ไขข้อมูลส่วนตัวและเปลี่ยนรหัสผ่าน

### 👨‍💼 สำหรับผู้ดูแลระบบ (Admin)
- ✅ **แดชบอร์ดแอดมิน** - ดูการจองที่รออนุมัติทั้งหมด
- ✅ **ระบบอนุมัติ/ปฏิเสธการจอง** - จัดการคำขอจองห้อง
- ✅ **จัดการข้อมูลห้อง** - CRUD สำหรับข้อมูลห้อง (เพิ่ม/แก้ไข/ลบ)
- ✅ **จัดการข้อมูลผู้ใช้** - CRUD สำหรับข้อมูลผู้ใช้
- ✅ **ระบบวิเคราะห์ข้อมูล** - แสดงสถิติการใช้งานด้วยกราฟ
- ✅ **สร้างรายงาน PDF** - ส่งออกรายงานสถิติเป็นไฟล์ PDF
- ✅ **กำหนดสถานะห้อง** - ตั้งค่าห้องเป็น "ว่าง" หรือ "ซ่อมบำรุง"

---

## 🏗️ สถาปัตยกรรมระบบ

### 🔧 เทคโนโลยีที่ใช้
| ส่วนประกอบ | เทคโนโลยี |
|------------|-----------|
| **Backend Framework** | Laravel 12.x |
| **Frontend Framework** | Blade Templates + Alpine.js |
| **CSS Framework** | Tailwind CSS 3.x |
| **Database** | MySQL / SQLite |
| **Chart Library** | Chart.js / ApexCharts |
| **PDF Generation** | mPDF |
| **Authentication** | Laravel Breeze |

### 📁 โครงสร้างโปรเจค
```
Room-Booking_Management_System/
├── app/
│   ├── Http/Controllers/     # Controller ทั้งหมด
│   ├── Models/              # Model (User, Room, Booking)
│   └── Middleware/          # Middleware (IsAdmin)
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Test data seeders
├── resources/views/
│   ├── admin/              # หน้าสำหรับ Admin
│   ├── user/               # หน้าสำหรับ User
│   ├── auth/               # หน้าล็อกอิน/ลงทะเบียน
│   └── components/         # UI Components
└── public/                 # Assets และไฟล์สาธารณะ
```

---

## 🗄️ โครงสร้างฐานข้อมูล

### 📊 ตารางหลัก
| ตาราง | คำอธิบาย | ฟิลด์สำคัญ |
|-------|----------|------------|
| **users** | ข้อมูลผู้ใช้ | id, name, email, role, password |
| **rooms** | ข้อมูลห้อง | id, name, capacity, status, image_url |
| **bookings** | ข้อมูลการจอง | id, user_id, room_id, start_time, end_time, status |

### 🔗 ความสัมพันธ์
```
User (1) ──── (n) Booking (n) ──── (1) Room
     │                              │
     └─ สามารถจองได้หลายครั้ง       └─ ถูกจองได้หลายครั้ง
```

### 📝 สถานะต่างๆ ในระบบ
- **สถานะห้อง (Room Status)**: `available`, `maintenance`
- **สถานะการจอง (Booking Status)**: `pending`, `approved`, `rejected`
- **บทบาทผู้ใช้ (User Role)**: `user`, `admin`

---

## 🚀 การติดตั้งและตั้งค่า

### ข้อกำหนดเบื้องต้น
- PHP 8.2 หรือสูงกว่า
- Composer
- Node.js 18+ และ npm
- MySQL หรือ SQLite

### ขั้นตอนการติดตั้ง
```bash
# 1. โคลนโปรเจค
git clone https://github.com/Weerapong-Hoshi/Room-Booking_Management_System.git
cd Room-Booking_Management_System

# 2. ติดตั้ง dependencies ของ PHP
composer install

# 3. ติดตั้ง dependencies ของ JavaScript
npm install

# 4. คัดลอกไฟล์ environment
cp .env.example .env

# 5. สร้าง application key
php artisan key:generate

# 6. ตั้งค่าฐานข้อมูลในไฟล์ .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=room_booking
DB_USERNAME=root
DB_PASSWORD=

# 7. รัน migrations และ seeders
php artisan migrate --seed

# 8. สร้างลิงก์ symbolic สำหรับ storage
php artisan storage:link

# 9. รัน development server
php artisan serve
npm run dev
```

### 🔧 การตั้งค่าเพิ่มเติม
```bash
# สร้างผู้ใช้ Admin ใหม่
php artisan db:seed --class=AdminSeeder

# สร้างข้อมูลทดสอบ
php artisan db:seed --class=RoomSeeder
php artisan db:seed --class=BookingSeeder
```

---

## 📱 หน้าจอและฟังก์ชันการทำงาน

### 1. หน้าล็อกอิน/ลงทะเบียน
- **URL**: `/login`, `/register`
- **ฟังก์ชัน**: ระบบ Authentication แบบเต็มรูปแบบด้วย Laravel Breeze
- **ความปลอดภัย**: Email verification, Password reset

### 2. แดชบอร์ดผู้ใช้ทั่วไป
- **URL**: `/dashboard`
- **แสดง**: รายการห้องทั้งหมดพร้อมสถานะ
- **สถานะห้อง**:
  - 🟢 **ว่าง** - สามารถจองได้ทันที
  - 🔵 **จองโดยฉัน** - การจองของตัวเอง
  - 🟡 **รออนุมัติ** - การจองที่รอ Admin อนุมัติ
  - 🔴 **ไม่ว่าง** - ถูกจองโดยคนอื่นแล้ว
  - 🛠️ **ซ่อมบำรุง** - ห้องไม่พร้อมให้บริการ

### 3. ระบบจองห้อง
- **URL**: `/bookings/create/{room_id}`
- **ฟังก์ชัน**: เลือกวันที่และเวลาในการจอง
- **การตรวจสอบ**: ตรวจสอบความขัดแย้งของการจองอัตโนมัติ

### 4. ปฏิทินการจอง
- **URL**: `/bookings`
- **แสดง**: การจองทั้งหมดในรูปแบบปฏิทิน
- **เทคโนโลยี**: FullCalendar.js integration

### 5. แดชบอร์ดแอดมิน
- **URL**: `/admin/dashboard`
- **แสดง**: รายการการจองที่รออนุมัติ
- **ฟังก์ชัน**: อนุมัติ/ปฏิเสธการจองด้วยคลิกเดียว

### 6. จัดการห้อง (Admin)
- **URL**: `/admin/rooms`
- **ฟังก์ชัน**: CRUD เต็มรูปแบบสำหรับข้อมูลห้อง
- **รองรับ**: อัพโหลดรูปภาพห้อง

### 7. จัดการผู้ใช้ (Admin)
- **URL**: `/admin/users`
- **ฟังก์ชัน**: CRUD เต็มรูปแบบสำหรับข้อมูลผู้ใช้
- **สามารถ**: เปลี่ยนบทบาทผู้ใช้ (user/admin)

### 8. ระบบวิเคราะห์ข้อมูล
- **URL**: `/admin/analytics`
- **แสดง**: สถิติการใช้งานด้วยกราฟ
- **ข้อมูล**: การจองต่อวัน, ห้องยอดนิยม, อัตราการอนุมัติ

### 9. สร้างรายงาน PDF
- **URL**: `/admin/pdf/report`
- **ฟังก์ชัน**: ส่งออกรายงานสถิติเป็นไฟล์ PDF
- **เทคโนโลยี**: ใช้ mPDF library

---

## 👥 บทบาทและสิทธิ์การใช้งาน

### ผู้ใช้ทั่วไป (User)
- จองห้องได้
- ดูสถานะห้อง
- จัดการการจองของตัวเอง
- แก้ไขโปรไฟล์ส่วนตัว

### ผู้ดูแลระบบ (Admin)
- อนุมัติ/ปฏิเสธการจอง
- จัดการข้อมูลห้อง
- จัดการข้อมูลผู้ใช้
- ดูรายงานและสถิติ
- สร้างรายงาน PDF

---

## 🔧 สำหรับนักพัฒนา

### การรันเทสต์
```bash
# รัน PHPUnit tests
php artisan test

# รันเฉพาะไฟล์เทสต์
php artisan test --filter=AuthenticationTest
```

### Code Quality
```bash
# Format code ด้วย Laravel Pint
php artisan pint

# Generate IDE helper
php artisan ide-helper:generate
```

### Development Commands
```bash
# รัน development server พร้อมๆ กัน
npm run dev

# Build for production
npm run build

# Setup project ด้วยคำสั่งเดียว
composer run setup
```

---

## 📊 ข้อมูลเทคนิคเพิ่มเติม

### Environment Variables หลัก
```env
APP_NAME="Room Booking System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=room_booking
DB_USERNAME=root
DB_PASSWORD=
```

### Dependencies หลัก
```json
{
  "laravel/framework": "^12.0",
  "mpdf/mpdf": "^8.2",          // สำหรับสร้าง PDF
  "laravel/breeze": "^2.3",     // สำหรับ Authentication
  "tailwindcss": "^3.1.0",      // CSS Framework
  "alpinejs": "^3.4.2",         // Frontend interactivity
  "apexcharts": "^5.10.1",      // สำหรับสร้างกราฟ
  "chart.js": "^4.5.1"          // สำหรับสร้างกราฟ
}
```

---

## 🚀 การปรับใช้ (Deployment)

### สำหรับ Production
1. ตั้งค่า `APP_ENV=production` และ `APP_DEBUG=false`
2. Generate application key: `php artisan key:generate --force`
3. Optimize: `php artisan optimize`
4. Build assets: `npm run build`
5. รัน migrations: `php artisan migrate --force`

### สำหรับ Shared Hosting
- อัพโหลดไฟล์ทั้งหมดยกเว้น `node_modules` และ `.git`
- ตั้งค่า document root เป็น `/public`
- ตั้งค่า permissions ที่เหมาะสม

---

## 📝 การมีส่วนร่วม

### การรายงานปัญหา
1. ตรวจสอบว่าเป็นปัญหาที่ยังไม่ถูกรายงาน
2. สร้าง issue ใหม่พร้อมรายละเอียด
3. รวมข้อมูล: Laravel version, PHP version, error logs

### การส่ง Pull Request
1. Fork repository
2. สร้าง branch ใหม่ (`git checkout -b feature/amazing-feature`)
3. Commit การเปลี่ยนแปลง (`git commit -m 'Add amazing feature'`)
4. Push ไปยัง branch (`git push origin feature/amazing-feature`)
5. เปิด Pull Request

---

## 📄 ใบอนุญาต

โปรเจคนี้ใช้ใบอนุญาต **MIT License** - ดูไฟล์ [LICENSE](LICENSE) สำหรับรายละเอียด

---

## 👨‍💻 ผู้พัฒนา

**Weerapong Hoshi**  
- GitHub: [@Weerapong-Hoshi](https://github.com/Weerapong-Hoshi)
- Project Repository: [Room-Booking_Management_System](https://github.com/Weerapong-Hoshi/Room-Booking_Management_System)

---

## 🙏 ขอบคุณ

- **Laravel Community** - สำหรับ framework ที่ยอดเยี่ยม
- **Tailwind CSS** - สำหรับ utility-first CSS framework
- **All Contributors** - สำหรับการมีส่วนร่วมในโปรเจค

---

<p align="center">
  <sub>Built with ❤️ using Laravel & Tailwind CSS</sub>
</p>

---

**หมายเหตุ**: README นี้ถูกเขียนขึ้นสำหรับใช้ในรายงานและเอกสารประกอบโครงการ ระบบนี้พร้อมสำหรับการใช้งานจริงในองค์กรหรือสถาบันการศึกษา