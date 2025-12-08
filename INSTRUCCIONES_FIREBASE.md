# 🔥 Instrucciones para Configurar Firebase Google Sign-In

## ✅ Lo que ya está hecho

Tu aplicación web ya tiene todo el código necesario para funcionar con Firebase (Proyecto: **Clari30**). He mejorado:


1. ✨ **Autenticación con Google** - Completamente funcional
2. 📱 **Autenticación con Teléfono** - Ya configurada
3. 🎨 **Interfaz moderna** - Con animaciones y diseño glassmorphism
4. 🔄 **Redirección automática** - Después del login exitoso
5. 💾 **Persistencia de sesión** - Guarda datos del usuario en localStorage

---

## 📋 Pasos que DEBES hacer en Firebase Console

### Paso 1: Habilitar Google Sign-In

1. Ve a [Firebase Console](https://console.firebase.google.com/)
2. Selecciona tu proyecto: **clabi-2412**
3. En el menú lateral, haz clic en **Authentication** (Autenticación)
4. Haz clic en la pestaña **Sign-in method** (Método de inicio de sesión)
5. Busca **Google** en la lista de proveedores
6. Haz clic en **Google**
7. Activa el interruptor para **Habilitar**
8. Agrega un **correo electrónico de asistencia** (puede ser tu correo personal)
9. Haz clic en **Guardar**

### Paso 2: Verificar Dominios Autorizados

1. En la misma pestaña **Sign-in method**, desplázate hacia abajo
2. Busca la sección **Authorized domains** (Dominios autorizados)
3. Verifica que `localhost` esté en la lista (debería estar por defecto)
4. Si planeas subir tu app a internet, agrega tu dominio aquí más adelante

### Paso 3: (Opcional) Configurar Pantalla de Consentimiento OAuth

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Selecciona tu proyecto
3. Ve a **APIs y servicios** → **Pantalla de consentimiento de OAuth**
4. Configura:
   - Nombre de la aplicación
   - Logo (opcional)
   - Correo de soporte
   - Información de contacto del desarrollador

---

## 🚀 Cómo Probar tu Login

### Opción 1: Usar XAMPP (Recomendado)

1. Asegúrate de que XAMPP esté corriendo
2. Abre tu navegador
3. Ve a: `http://localhost/clari2.0/index.html`
4. Haz clic en **"Iniciar Sesión con Google"**
5. Selecciona tu cuenta de Google
6. ¡Listo! Deberías ver tu nombre y la opción de redirigir a la app principal

### Opción 2: Abrir directamente el archivo

⚠️ **IMPORTANTE**: Firebase NO funciona si abres el archivo directamente (file:///)
Debes usar un servidor web local como XAMPP, Live Server, o similar.

---

## 📁 Archivos Creados/Modificados

### 1. `app.js` - Mejorado ✨
- ✅ Mejor manejo de errores con mensajes específicos
- ✅ Estados de carga en el botón
- ✅ Redirección automática después del login
- ✅ Guarda información del usuario en localStorage
- ✅ Restaura el estado del botón si hay error

### 2. `style.css` - Mejorado ✨
- ✅ Estilos para botón deshabilitado
- ✅ Mejores estilos para inputs del formulario
- ✅ Efectos hover en todos los botones
- ✅ Animaciones suaves

### 3. `auth-guard.js` - NUEVO 🆕
Este archivo protege tus otras páginas (como `reds.html`). 

**Cómo usarlo en tus otras páginas:**

```html
<!-- En reds.html o cualquier página que quieras proteger -->
<script type="module">
    import { logout, getCurrentUser } from './auth-guard.js';
    
    // Escuchar cuando el usuario esté autenticado
    window.addEventListener('userAuthenticated', (event) => {
        const user = event.detail;
        console.log('Usuario:', user.displayName);
        // Aquí puedes actualizar tu UI con los datos del usuario
    });
    
    // Para cerrar sesión desde cualquier página
    document.getElementById('cerrarSesionBtn').addEventListener('click', () => {
        logout();
    });
</script>
```

---

### Paso 1: Configurar Facebook en Firebase

1. Copia estos datos (extraídos de tu imagen):
   - **App ID**: `1320611453204321`
   - **App Secret**: `52d5a7da8edb818e798679ec3e62b579`

2. Ve a Firebase Console -> Authentication -> Sign-in method -> Facebook.
3. Pégalos ahí y COPIA la "URI de redireccionamiento".

### Paso 2: Configurar Facebook Developers

1. Ve a la sección "Inicio de sesión con Facebook" -> Configuración.
2. Pega la URI de redireccionamiento en "URI de redireccionamiento de OAuth válidos".
3. Guarda cambios.

**Nota:** Ignora el aviso rojo de "No cumple los requisitos" por ahora. Tu app funcionará en modo desarrollo.


Para que solo usuarios autenticados puedan acceder a `reds.html` u otras páginas:

1. Agrega esto al inicio del HTML:
```html
<script type="module" src="auth-guard.js"></script>
```

2. El script automáticamente:
   - ✅ Verifica si el usuario está autenticado
   - ✅ Si NO está autenticado → Redirige a `index.html`
   - ✅ Si SÍ está autenticado → Permite el acceso

---

## 📊 Información del Usuario Disponible

Después del login, puedes acceder a:

```javascript
// Desde localStorage (disponible en cualquier página)
const userData = JSON.parse(localStorage.getItem('firebaseUser'));
console.log(userData.displayName); // Nombre del usuario
console.log(userData.email);       // Email
console.log(userData.photoURL);    // Foto de perfil
console.log(userData.uid);         // ID único del usuario

// Usando auth-guard.js
import { getCurrentUser } from './auth-guard.js';
const user = getCurrentUser();
```

---

## 🐛 Solución de Problemas

### Error: "Popup bloqueado"
- **Solución**: Permite ventanas emergentes en tu navegador para localhost

### Error: "auth/unauthorized-domain"
- **Solución**: Agrega tu dominio en Firebase Console → Authentication → Sign-in method → Authorized domains

### Error: "Firebase not initialized"
- **Solución**: Asegúrate de estar usando un servidor web (XAMPP), no abras el archivo directamente

### El login funciona pero no redirige
- **Solución**: Verifica que exista el archivo `reds.html` en la misma carpeta
- Si no existe, el código te preguntará si quieres redirigir

---

## 🎯 Próximos Pasos Recomendados

1. ✅ **Configurar Firebase Console** (Paso 1 arriba)
2. 🧪 **Probar el login** con tu cuenta de Google
3. 🔒 **Proteger reds.html** agregando `auth-guard.js`
4. 🎨 **Personalizar** el mensaje de bienvenida
5. 📱 **Probar autenticación por teléfono** (opcional)

---

## 💡 Notas Importantes

- ⚠️ **NUNCA** compartas tu `apiKey` públicamente en producción (considera usar variables de entorno)
- 🔒 Las reglas de seguridad de Firebase deben configurarse en el backend
- 💾 Los datos en localStorage pueden ser borrados por el usuario
- 🌐 Para producción, configura las reglas de Firestore/Database según tus necesidades

---

## 📞 ¿Necesitas Ayuda?

Si algo no funciona:
1. Abre la consola del navegador (F12)
2. Busca mensajes de error en rojo
3. Verifica que Firebase esté configurado correctamente
4. Asegúrate de estar usando XAMPP o un servidor local

---

**¡Tu sistema de autenticación está listo! Solo falta configurar Firebase Console y probar.** 🚀
