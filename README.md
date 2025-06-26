# QuickFund

A modern financial application built with Next.js frontend and Laravel backend, featuring automated queue processing and comprehensive user management.

## 📁 Repositories

- **Backend (Laravel)**: https://github.com/degee147/quickfund
- **Frontend (Next.js)**: https://github.com/degee147/quickfund-frontend

## 🚀 Live Deployment

- **Frontend**: https://quickfund-frontend.vercel.app/
- **Backend API**: https://qf.kenwaribo.com

## 🏗️ Architecture

### Frontend
- **Framework**: Next.js with TypeScript
- **Styling**: Tailwind CSS with Geist font optimization
- **Deployment**: Vercel with automated CI/CD via deploy hooks
- **Deploy Hook**: `https://api.vercel.com/v1/integrations/deploy/prj_sw3cT4EYA1Ac8tpIvM33tAjHgFpz/dqtAlH5BgA`

### Backend
- **Framework**: Laravel PHP
- **Hosting**: Namecheap shared hosting (easily switchable to AWS)
- **Queue Processing**: CRON-based execution (every 5 minutes)
- **CI/CD**: GitHub Actions for automated deployment

## 🛠️ Getting Started

### Prerequisites
- Node.js 18+ and npm/yarn/pnpm/bun
- PHP 8.0+ (for backend development)

### Frontend Development

1. Clone the frontend repository:
```bash
git clone https://github.com/degee147/quickfund-frontend.git
cd quickfund-frontend
```

2. Install dependencies:
```bash
npm install
# or
yarn install
# or
pnpm install
# or
bun install
```

3. Start the development server:
```bash
npm run dev
# or
yarn dev
# or
pnpm dev
# or
bun dev
```

4. Open [http://localhost:3000](http://localhost:3000) to view the application

5. Edit `app/page.tsx` to start developing - changes auto-reload

### Backend Development

1. Clone the backend repository:
```bash
git clone https://github.com/degee147/quickfund.git
cd quickfund
```

2. Follow the Laravel setup instructions in the backend repository for local development

## 🔐 Test Accounts

### User Accounts
Feel free to create your own account using the "Get Started" button, or use these test accounts:

**User 1:**
- Email: `kenwaribo@gmail.com`
- Password: `kenwaribo@gmail.com`

**User 2:**
- Email: `degee2@ken.com`
- Password: `degee2@ken.com`

### Admin Access
**Admin Panel:**
- Email: `admin@quickfund.ng`
- Password: `password`

## ⚙️ Queue Management

### Current Setup (Shared Hosting)
- **Scheduler**: CRON jobs running every 5 minutes
- **Limitation**: Dockerization not supported on shared hosting

### Planned AWS Migration
- **Process Manager**: Supervisor for robust queue management
- **Scalability**: Enhanced performance and reliability
- **Docker Support**: Full containerization capabilities

## 🚀 Deployment

### Frontend (Vercel)
The frontend automatically deploys via Vercel's GitHub integration and deploy hooks. Push to the main branch triggers automatic deployment.

### Backend (Namecheap/Laravel)
Backend deployment is automated through GitHub Actions CI/CD pipeline, deploying to the shared hosting environment.

## 📚 Learn More

### Next.js Resources
- [Next.js Documentation](https://nextjs.org/docs) - comprehensive Next.js guide
- [Learn Next.js](https://nextjs.org/learn) - interactive tutorial
- [Next.js GitHub](https://github.com/vercel/next.js) - contribute to the framework

### Font Optimization
This project uses [`next/font`](https://nextjs.org/docs/app/building-your-application/optimizing/fonts) to automatically optimize and load [Geist](https://vercel.com/font), Vercel's modern font family.

## 🔄 CI/CD Pipeline

- **Frontend**: Vercel automatic deployments with deploy hooks
- **Backend**: GitHub Actions workflow for Laravel application
- **Queue Processing**: Automated CRON-based task execution

## 🏗️ Future Enhancements

- Migration to AWS infrastructure
- Implementation of Supervisor for queue management
- Docker containerization support
- Enhanced scalability and performance optimizations

## 📞 Support

For questions or support, please refer to the application's built-in help system or contact the development team.

---

*Built with ❤️ using Next.js, Laravel, and modern web technologies*
