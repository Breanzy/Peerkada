<p align="center">
  <img width="500" alt="Pasted Graphic 1" src="assets/logowhite.png" />
</p>
Peerkada is a comprehensive QR-based attendance management system designed specifically for the Student Peer Facilitator organization at MSU-IIT. This web application streamlines attendance tracking, record management, and administrative tasks through an intuitive interface and powerful backend functionality.

## ✨ Features

### 👥 User Management
- Complete CRUD system (Admin restricted)
- User profile pages with attendance history
- Role-based access control

### 📱 Attendance Tracking
- QR code generation for each user
- Real-time QR scanning capabilities
- Detailed attendance logs and history

### 🔍 Admin Dashboard
- Monitor unfulfilled attendance logs
- Automated email notifications for users below monthly requirements
- Comprehensive reporting system

### 🔒 Authentication
- Secure login system
- Profile management
- Password reset functionality

## 🛠️ Tech Stack

- **Backend**: PHP, MySQL
- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Libraries**:
  - SB Admin 2 (UI Framework)
  - HTML5QR (QR Scanning)
  - Endroid QR-Code (QR Generation)
  - PHPMailer (Email Functionality)
  - DataTables (Interactive Table Management)
  - SweetAlert (User-friendly Alerts)

## 🚀 Live Demo

Check out the live version of Peerkada [here](https://peerkada.ct.ws)!

## 📋 Installation

### Prerequisites
- XAMPP or LAMP stack installed
- Composer for PHP dependency management
- Web browser with camera access (for QR functionality)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/peerkada.git
   cd peerkada
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database setup**
   - Import the database file located in `assets/Peerkada.sql` to your MySQL server
   - You can use phpMyAdmin (included with XAMPP) for this process

4. **Configuration**
   - Update database connection details in `config/database.php`
   - Configure email settings in `config/mail.php` for notification functionality

5. **Run the application**
   - Make sure your XAMPP/LAMP server is running
   - Access the application via `http://localhost/peerkada`

## 📷 Screenshots

<div>
  <img width="450" alt="Pasted Graphic 1" src="https://github.com/user-attachments/assets/8acd28c5-b40d-4695-8a1b-d6f88d4874a4" />
  <img width="450" alt="3 Hours" src="https://github.com/user-attachments/assets/e71ecc96-0adc-4894-a62f-33ad06b71f6b" />
  <img width="450" alt="Pasted Graphic 6" src="https://github.com/user-attachments/assets/e1801384-a667-4194-ba5e-31e04df83d87" />
  <img width="450" alt="Pasted Graphic 7" src="https://github.com/user-attachments/assets/b3d44778-f89f-4fd6-968b-3ae51a2b315b" />
</div>

Developed with ❤️ for the MSU-IIT Student Peer Facilitator organization
