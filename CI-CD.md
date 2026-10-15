# CI/CD Pipeline Documentation

This repository includes an automated GitHub Actions CI/CD workflow defined in [`.github/workflows/ci-cd.yml`](.github/workflows/ci-cd.yml).

---

## 🚀 Workflow Overview

Every time code is pushed or a Pull Request is opened against the `main` branch, the pipeline automatically executes three phases:

```mermaid
flowchart LR
    A[Push / PR to main] --> B[1. Lint & Validate]
    B --> C[2. Package Theme .zip]
    C --> D[3. Deploy to Hosting]
```

---

### 1. CI: Lint & Validate (`lint-and-validate`)
- **PHP Syntax Verification**: Automatically lints every `.php` file across the theme using PHP 8.2 CLI (`php -l`) to catch syntax errors or broken code before deployment.
- **Theme Integrity Check**: Verifies that essential WordPress theme files (`style.css`, `index.php`, `functions.php`) exist and are valid.

---

### 2. Build & Package Release (`package-theme`)
- Creates a clean, distribution-ready WordPress theme archive: `ci360-hello-child.zip`.
- Automatically excludes development files (`.git`, `.github`, `build`, etc.).
- Uploads the `.zip` as a GitHub Actions Artifact (stored for 30 days), allowing 1-click download of the installable theme archive directly from any workflow run.

---

### 3. CD: Automated Hosting Deployment (`deploy-hosting`)
When pushing to `main`, the workflow can automatically upload and sync modified theme files directly to your live WordPress server via FTPS/FTP.

#### How to Enable Auto-Deployment to Your Host (e.g. Hostinger, cPanel, VPS):
1. In your GitHub repository, navigate to **Settings** > **Secrets and variables** > **Actions**.
2. Click **New repository secret** and add the following:

| Secret Name | Description | Example Value |
|---|---|---|
| `FTP_SERVER` | Your FTP/FTPS host or server IP | `ftp.yourdomain.com` or `185.xxx.xxx.xxx` |
| `FTP_USERNAME` | Your FTP user account | `u123456789` |
| `FTP_PASSWORD` | Your FTP password | `••••••••••••` |
| `FTP_SERVER_DIR` *(Optional)* | Remote theme directory path | `public_html/wp-content/themes/ci360-hello-child/` |

> **Note**: If `FTP_SERVER` is not configured, the workflow safely skips deployment while still running tests and packaging the `.zip` archive.
