# DrHome

Platform Digital untuk Memudahkan Perencanaan dan Pembangunan Rumah. Temukan designer, contractor untuk membangun rumah Anda.

# Installation Steps

```bash
git clone https://github.com/aryayudh06/DrHome
cd DrHome
composer install
npm install
cp .env.example .env

php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link

npm run dev
php artisan serve
```

# Struktur Proyek / Folder

```bash
 🏠 DrHome
 ├── 📂 app
 │   ├── 📂 Http
 │   │   ├── 📂 Controllers
 │   │   │   ├── 📂 Api
 │   │   │   │   ├── 📄 ContractorController.php
 │   │   │   │   ├── 📄 DesignController.php
 │   │   │   │   ├── 📄 DesignerController.php
 │   │   │   │   └── 📄 MailsAdminController.php
 │   │   │   ├── 📂 Auth
 │   │   │   │   ├── 📄 AuthenticatedSessionController.php
 │   │   │   │   ├── 📄 ConfirmablePasswordController.php
 │   │   │   │   ├── 📄 EmailVerificationNotificationController.php
 │   │   │   │   ├── 📄 EmailVerificationPromptController.php
 │   │   │   │   ├── 📄 NewPasswordController.php
 │   │   │   │   ├── 📄 PasswordResetLinkController.php
 │   │   │   │   ├── 📄 RegisteredUserController.php
 │   │   │   │   └── 📄 VerifyEmailController.php
 │   │   │   ├── 📂 Settings
 │   │   │   │   ├── 📄 PasswordController.php
 │   │   │   │   └── 📄 ProfileController.php
 │   │   │   ├── 📄 AvatarController.php
 │   │   │   ├── 📄 ChatController.php
 │   │   │   ├── 📄 Controller.php
 │   │   │   ├── 📄 MyRequestController.php
 │   │   │   ├── 📄 PurchasedDesignController.php
 │   │   │   ├── 📄 RequestContractorController.php
 │   │   │   ├── 📄 RequestController.php
 │   │   │   ├── 📄 RequestDesignerController.php
 │   │   │   └── 📄 UserController.php
 │   │   ├── 📂 Middleware
 │   │   │   ├── 📄 ChatAccess.php
 │   │   │   ├── 📄 EnsureIsAdmin.php
 │   │   │   ├── 📄 EnsureIsDesignerOrContractor.php
 │   │   │   ├── 📄 HandleAppearance.php
 │   │   │   └── 📄 HandleInertiaRequests.php
 │   │   ├── 📂 Requests
 │   │   │   ├── 📂 Auth
 │   │   │   │   └── 📄 LoginRequest.php
 │   │   │   └── 📂 Settings
 │   │   │       └── 📄 ProfileUpdateRequest.php
 │   ├── 📂 Mail
 │   │   └── 📄 CustomEmail.php
 │   ├── 📂 Models
 │   │   ├── 📄 Chat.php
 │   │   ├── 📄 Contractor.php
 │   │   ├── 📄 Design.php
 │   │   ├── 📄 Designer.php
 │   │   ├── 📄 EmailHistory.php
 │   │   ├── 📄 MailsAdmin.php
 │   │   ├── 📄 PurchasedDesign.php
 │   │   ├── 📄 RequestContractor.php
 │   │   ├── 📄 RequestDesigner.php
 │   │   └── 📄 User.php
 │   ├── 📂 Providers
 │   │   └── 📄 AppServiceProvider.php
 ├── 📂 bootstrap
 │   ├── 📂 cache
 │   │   ├── 📄 .gitignore
 │   │   ├── 📄 packages.php
 │   │   └── 📄 services.php
 │   ├── 📄 app.php
 │   └── 📄 providers.php
 ├── 📂 config
 │   ├── 📄 app.php
 │   ├── 📄 auth.php
 │   ├── 📄 cache.php
 │   ├── 📄 database.php
 │   ├── 📄 filesystems.php
 │   ├── 📄 logging.php
 │   ├── 📄 mail.php
 │   ├── 📄 queue.php
 │   ├── 📄 services.php
 │   └── 📄 session.php
 ├── 📂 database

```

## Landing Page Preview as Guest User

![Landing Page Preview](https://github.com/aryayudh06/DrHome/blob/main/public/images/previewlanding.png?raw=true)