<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Farmer Management System

A modular Laravel-based system for managing farmers, loans, and farming inputs. This system features a dynamic modular architecture that allows for scalable feature expansion while maintaining a robust core functionality.

## Detailed Setup Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7 or higher
- Git

### Step-by-Step Installation

1. **Clone the Repository or Donwload Zip**
```bash
git clone https://github.com/avatarthor/goodnature_agro_web_and_backend
cd goodnature_agro_web_and_backend
```

2. **Install Dependencies In Project Root**
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install


3. **Environment Setup**
```bash
# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Configuration**
```bash
# In your .env file, configure your database settings:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=goodnatureagro
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrations**
```bash
# Create database tables
php artisan migrate

# Seed the database with an admin user
php artisan db:seed
```

6. **Storage Setup**
```bash
# Create storage link
php artisan storage:link


7. **Start the Application**
```bash
# Use this type of cammand so the app can access the endpoints of the backend
# url to place in app http://your_ip_address:8000/api/
php artisan serve --host=0.0.0.0 --port=8000
```

## Module System

### Module Management Interface

The system includes a dedicated "Module Management" interface accessible through:
- Navigation: System > Module Management

#### Interface Features
- **Upload New Module**: Button to upload and install new modules
- **Module List Table** showing:
  - Module Name
  - Description
  - Version
  - Status (Active/Inactive)
  - Actions (Deactivate/Delete)
- Success/error notifications for module operations

### Currently Available Modules
1. **FarmerInputs (v1.0.0)**
   - Purpose: Manage farmer input distributions
   - Features: Input type management, distribution tracking
   - Status options: Active/Inactive
   - Actions: Deactivate, Delete

2. **FarmerLoans (v1.0.0)**
   - Purpose: Manage farmer loans including loan creation, approval, and tracking
   - Features: Loan application, approval workflow, repayment tracking
   - Status options: Active/Inactive
   - Actions: Deactivate, Delete

### Module Architecture

The system implements a modular architecture where each module is self-contained and follows a specific structure:

```
modules/
├── ModuleName/
│   ├── Config/
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeders/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   ├── Resources/
│   │   ├── views/
│   │   └── assets/
│   ├── Routes/
│   │   ├── web.php
│   │   └── api.php
│   ├── module.json
```

### Module Management

#### Installing Modules
1. **Manual Installation**
- Find the modules on the root of the repository as zip files
- Extract ModuleFeature to Module directory in root of project

2. **Via Upload**
- Navigate to Admin > Modules
- Click "Upload Module"
- Select the module zip file
- System will automatically install the module

#### Module States and Actions

#### States
- **Active**: Module is fully functional and accessible
  - Indicated by green "Active" status in module list
  - All module features are available
  - Routes and controllers are loaded

- **Inactive**: Module exists but is temporarily disabled
  - Occurs after using the "Deactivate" action
  - Module remains installed but features are inaccessible
  - Can be reactivated without data loss

- **Uninstalled**: Module is completely removed
  - Triggered by using the "Delete" action
  - Removes module files and optionally database tables
  - Requires fresh installation to restore

#### Available Actions
- **Upload New Module**
  - Click "Upload New Module" button
  - Select module zip file
  - System validates and installs automatically
  - Success notification appears if successful

- **Deactivate**
  - Temporarily disables module functionality
  - Preserves all module data
  - Can be reversed by reactivating
  - Shown as orange "Deactivate" button

- **Delete**
  - Permanently removes module
  - Optional database cleanup
  - Cannot be undone
  - Shown as red "Delete" button


## Comprehensive Usage Guide

### Farmer Management

#### Adding New Farmers
1. Navigate to Farmers > Create Farmer
2. Fill in required information:
   - Full Name
   - Phone Number
   - Location
3. Click "Save" to create the farmer profile

#### Managing Farmer Records
- View all farmers: Farmers > All Farmers
- Edit farmer details: Click the edit icon next to farmer
- Delete farmer: Click delete icon (only available if no active loans)
- View farmer history: Click on farmer name to see complete history

### Loan Management

#### Creating Loans
1. Navigate to Farmer Loans > Disburse Loan
2. Select farmer from dropdown
3. Enter loan details:
   - Loan Amount
   - Interest Rate
   - Repayment Duration
4. Submit loan application

#### Loan Processing
1. View pending loans in Farmer Loans > All Loans
2. Review loan details
3. Actions available:
   - Approve: Sets loan status to approved
   - Reject: Sets loan status to rejected
   - Edit: Modify loan details if needed
   - Delete: Remove pending loans only

#### Loan Tracking
- Monitor loan status from dashboard
- View comprehensive loan reports
### Input Management

#### Setting Up Input Types
1. Navigate to Farmer Inputs > Create Input Types
2. Define input categories:
   - Name (e.g., "Fertilizer", "Seeds")
   - Description
   - Other relevant details

#### Distributing Inputs
1. Go to Farmer Inputs > Distribute Inputs
2. Select:
   - Farmer
   - Input Type
   - Quantity
   - Distribution Date
3. Save distribution record

#### Tracking Inputs
- View all distributions: Farmer Inputs > All Distributed Inputs
- Monitor input allocation per farmer

### Reporting System

#### Available Reports
- Total loans disbursed
- Loan status distribution
- Input distribution summary
- Farmer activity reports

## Security and Best Practices

### Access Control
- Admin authentication required

### ADMIN USER CREDENTIALS
- Email: admin@goodnatureagro.com
- Paasword: hd83b9@(*DBD@

## Android Connection
- Place this api key in the .env file for the app to authenticate the api's
- "FfmJnByjVVcVPwZyYliRiGaym6k1OEvK"
```bash
# env field name
API_KEY=
```

## Troubleshooting

### Common Issues
1. **Database Connection Issues**
   - Verify .env configuration
   - Check MySQL service
   - Confirm credentials
