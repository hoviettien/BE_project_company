<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

#  Laravel + (React + TypeScript)

Dự án này được xây dựng bằng **Laravel (Backend API)** và **ReactJS + TS (Frontend)**.  
Mục tiêu là tạo ra một hệ thống web tích hợp chatbot để truy xuất thông tin các trang web khởi nghiệp, tách biệt frontend/backend, dễ mở rộng và bảo trì.  
---
##  Công nghệ sử dụng
- [Laravel](https://laravel.com/) – Backend RESTful API  
- [React](https://reactjs.org/) – Frontend SPA  
- [MySQL](https://www.mysql.com/) – Cơ sở dữ liệu  
- [Axios](https://axios-http.com/) – Kết nối API  
- [Tailwind CSS](https://tailwindcss.com/) – UI Styling  
- [Cloudinary](https://cloudinary.com/) – Quản lý & lưu trữ hình ảnh  
---
## ⚙️ Cài đặt
<!-- Clone project -->
```bash
git clone https://github.com/hoviettien/BE_project_company.git
cd BE_project_company

# BE
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
API chạy tại: http://127.0.0.1:8000
# API endpoints
# các sự kiện & hoạt động 
http://127.0.0.1:8000/api/articles
# các speakers, mentor, diễn giả
http://127.0.0.1:8000/api/speakers
# các nahf tài trợ
http://127.0.0.1:8000/api/partners
# các startup tiêu biểu
http://127.0.0.1:8000/api/startups

# 🤖 Hướng dẫn triển khai Chatbot với n8n + Weaviate + Gemini

Dự án này giúp bạn xây dựng một **chatbot thông minh** dựa trên:
- **n8n**: công cụ automation no-code/low-code.
- **Weaviate**: vector database để lưu trữ embedding & dữ liệu hội thoại.
- **Google Gemini**: mô hình AI để tạo embedding & xử lý ngôn ngữ.

Kết hợp 3 thành phần này, bạn có thể dễ dàng import dữ liệu (mentor, partner, startup, articles...) vào vector DB, sau đó dùng workflow trong n8n để tạo chatbot trả lời tự động theo ngữ cảnh.

Bước 1: Tạo tài khoản & lấy API key
**1. Weaviate
- Truy cập Weaviate Cloud Console:
 https://auth.wcs.api.weaviate.io/auth/realms/SeMI/protocol/openid-connect/auth?client_id=wcs-frontend&scope=openid%20email%20profile&response_type=code&redirect_uri=https%3A%2F%2Fconsole.weaviate.cloud%2Fapi%2Fauth%2Fcallback%2Fkeycloak&state=y6AbOvD6o4SnnhN-xhqDSszX_5sGkTEqtbwt2VifTAE&code_challenge=U0GDyVJZTR_AjjC_6HALp-IqeiUMlfGZ0QMJFGSVrw4&code_challenge_method=S256

- Tạo 1 cluster mới (chọn Free Tier nếu chỉ test).
- Lấy WEAVIATE_URL và WEAVIATE_API_KEY.
**2. Google Gemini
- Vào Google AI Studio: https://aistudio.google.com/
- Tạo API Key.
Copy và lưu lại GEMINI_API_KEY.
**3. n8n
- Vào n8n.cloud hoặc tự host bằng Docker.
- Đăng ký tài khoản, tạo workspace mới.
- Sau khi login, mở n8n Editor để import workflow chatbot.

Bước 2: Đẩy dữ liệu vào Weaviate
1. Tạo môi trường Python
python -m venv venv
# macOS/Linux
source venv/bin/activate
# Windows
venv\Scripts\activate

2. Cài dependencies
pip install weaviate-client google-generativeai python-dotenv

3. Điền các thông tin cần thiết trong file import_documents.py
WEAVIATE_URL = "https://..."
WEAVIATE_API_KEY = "..."
GEMINI_API_KEY = "..."

4. Chạy file để import dữ liệu
python import.py

Bước 3: Tạo workflow trong n8n
- Tạo các node như sơ đồ (ảnh minh họa).
![Workflow](./config/data-weaviate/workflow.png)
- Trong node Vector Store (Weaviate):
- Liên kết với tài khoản Weaviate đã tạo ở bước 1.
- Trong phần Embedding Model, chọn: models/embedding-001

# Database
1. Cài đặt MySQL
# Cài đặt
- Option 1: Install [MySQL Community Server](https://dev.mysql.com/downloads/).  
- Option 2: Use Docker:
  ```bash
  docker run --name mysql-db     -e MYSQL_ROOT_PASSWORD=123456     -e MYSQL_DATABASE=project_db     -p 3306:3306     -d mysql:8.0
  ```

<!-- cấu hình kết nối-->
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=123456
DB_NAME=project_db

<!-- Khởi tạo CSDL (Chạy migration hoặc script SQL:) -->
mysql -u root -p project_db < db/migrations/init.sql


2. Cài đặt Weaviate
version: '3.4'
services:
  weaviate:
    image: semitechnologies/weaviate:latest
    ports:
      - "8080:8080"
    environment:
      QUERY_DEFAULTS_LIMIT: 25
      AUTHENTICATION_ANONYMOUS_ACCESS_ENABLED: 'true'
      PERSISTENCE_DATA_PATH: './data'

<!-- Khởi động Weaviate: -->
docker-compose up -d

<!-- Kiểm tra Weaviate -->

Mở http://localhost:8080/v1/graphql
 trong trình duyệt.
Thử một truy vấn GraphQL:

{
  Get {
    Article {
      title
      url
    }
  }
}

<!-- Cấu hình kết nối (Thêm vào file .env:) -->
WEAVIATE_HOST=http://localhost:8080

3. Ghi chú sử dụng

Dùng MySQL cho dữ liệu có cấu trúc/quan hệ.

Dùng Weaviate cho tìm kiếm ngữ nghĩa và dữ liệu vector.

Khi thêm dữ liệu mới (ví dụ: một bài viết), hãy lưu vào MySQL và đồng thời index vector trong Weaviate.