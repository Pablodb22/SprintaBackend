# 🚀 Sprinta - Backend API

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com) [![PHP](https://img.shields.io/badge/PHP-8.2-blue.svg)](https://php.net) [![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Neon-orange.svg)](https://neon.tech) [![Docker](https://img.shields.io/badge/Docker-Supported-green.svg)](https://docker.com)

**Sprinta** es una plataforma completa de gestión de proyectos y tareas colaborativas. Este repositorio contiene el **backend robusto** construido con **Laravel 12**, diseñado para integrarse perfectamente con el [frontend en Next.js](https://github.com/Pablodb22/SprintaFrontend).

## 🛠️ Tecnologías del Stack

| Componente | Tecnología | Versión |
|------------|------------|---------|
| **Backend** | Laravel + PHP | 12.x + 8.2 |
| **Base de Datos** | PostgreSQL (Neon) | Serverless |
| **Frontend** | Next.js + TypeScript | 14.x + TailwindCSS |
| **Despliegue** | Docker + Vite | ✅ Listo |
| **Cache/Queues** | Redis + Database | Configurado |
| **Testing** | PHPUnit | ✅ |

## ✨ Funcionalidades Principales

### 👥 Gestión de Usuarios
- 📝 Registro y autenticación completa
- 🔐 Autenticación API segura con Sanctum
- 👤 Perfiles de usuario personalizados (Modelo `Usuario`)

### 📂 Gestión de Proyectos
- 🆕 CRUD completo de proyectos
- 👥 Asignación de equipos y colaboradores
- 📊 Estados y seguimiento avanzado
- 🎯 Control de acceso por proyecto (Modelo `Proyectos`)

### ✅ Gestión de Tareas
- 📋 Tareas con prioridades y fechas límite
- 👥 Asignación a miembros del equipo
- 📈 Estados de progreso (To Do, In Progress, Done)
- 🔗 Relación con proyectos (Modelo `Tareas`)

### 🌐 API RESTful Completa
```
GET    /api/usuarios       → Lista de usuarios
POST   /api/usuarios       → Crear usuario
GET    /api/proyectos      → Lista de proyectos
POST   /api/proyectos      → Crear proyecto
PUT    /api/proyectos/{id} → Actualizar proyecto
GET    /api/tareas         → Lista de tareas
POST   /api/tareas         → Crear tarea
```

## 🚀 Inicio Rápido

### 1. Clonar y Configurar
```bash
git clone https://github.com/[tu-usuario]/sprinta-backend.git
cd sprinta-backend
cp .env.example .env
php artisan key:generate
```

### 2. Base de Datos (PostgreSQL Neon)
```bash
# Configurar DB_URL en .env
php artisan migrate
php artisan db:seed
```

### 3. Instalar Dependencias
```bash
composer install
npm install
npm run build
```

### 4. Ejecutar Servidor de Desarrollo
```bash
# Opción 1: Comando completo
composer run dev

# Opción 2: Manual
php artisan serve &
npm run dev
```

### 5. Docker (Opcional)
```bash
docker build -t sprinta-backend .
docker run -p 8000:9000 sprinta-backend
```

## 📱 Integración Frontend
El frontend Next.js se comunica via API REST:
```typescript
// Ejemplo en Next.js
const response = await fetch('/api/proyectos');
const proyectos = await response.json();
```

## 🧪 Testing
```bash
composer run test
# O detallado
php artisan test
```

## 📈 Estructura del Proyecto
```
sprinta-backend/
├── app/
│   ├── Http/Controllers/     # Controladores API
│   ├── Models/               # Modelos Eloquent
│   └── Providers/
├── database/migrations/      # Migraciones PostgreSQL
├── routes/api.php            # Rutas API
├── resources/                # Assets frontend
└── tests/                    # Pruebas automatizadas
```

## 🔒 Seguridad & Performance
- ✅ CSRF Protection y CORS configurado
- ✅ Rate Limiting en rutas críticas
- ✅ Validación de datos robusta
- ✅ Cache y Queue optimizados
- ✅ Logs estructurados con Pail

## 🤝 Contribuir
1. Fork del repositorio
2. Crear feature branch (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -m 'Add nueva funcionalidad'`)
4. Push (`git push origin feature/nueva-funcionalidad`)
5. Abrir Pull Request

## 📄 Licencia
Este proyecto está bajo la [Licencia MIT](LICENSE).

---

**Desarrollado con ❤️ para la gestión eficiente de proyectos**  
[![Laravel](https://laravel.com/assets/img/og-image.png)](https://laravel.com)
