<p align="center">
  <img width="500" alt="Pasted Graphic 1" src="assets/logowhite.png" />
</p>

# Peerkada - QR-Based Attendance Management System

Peerkada is a powerful and comprehensive QR-based attendance management system developed specifically for the Student Peer Facilitator organization at MSU-IIT. This web application is designed to simplify attendance tracking, record management, and administrative processes, providing an efficient and seamless experience for both users and administrators.

With an intuitive user interface and a robust backend, Peerkada eliminates the complexities of manual attendance management. It ensures that all attendance records are securely stored, easily accessible, and efficiently handled. Administrators can track attendance fulfillment, generate detailed reports, and send automated notifications, while users can view their attendance history and manage their profiles effortlessly.

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
   - In your project root directory, create a .env file and add the following:
   ```bash
    DATABASE_HOSTNAME=<your_database_host>
    DATABASE_USERNAME=<your_database_username>
    DATABASE_PASSWORD=<your_database_password>
    DATABASE_NAME=<your_db_name>
    PORT_NUMBER=<your_port_number>
    SMTP_PASSWORD=<your_smtp_password>
   ```
   

5. **Run the application**
   - Make sure your XAMPP/LAMP server is running
   - Access the application via `http://localhost/peerkada`

## 📷 Screenshots

<p align='center'>
  <img width="500" alt="Pasted Graphic 1" src="https://github.com/user-attachments/assets/8acd28c5-b40d-4695-8a1b-d6f88d4874a4" />
  <img width="500" alt="3 Hours" src="https://github.com/user-attachments/assets/e71ecc96-0adc-4894-a62f-33ad06b71f6b" />
  <img width="500" alt="Pasted Graphic 6" src="https://github.com/user-attachments/assets/e1801384-a667-4194-ba5e-31e04df83d87" />
  <img width="500" alt="Pasted Graphic 7" src="https://github.com/user-attachments/assets/b3d44778-f89f-4fd6-968b-3ae51a2b315b" />
</p>

Developed with ❤️ for the MSU-IIT Student Peer Facilitator organization
