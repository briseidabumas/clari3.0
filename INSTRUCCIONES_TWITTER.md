# Cómo Configurar Twitter Login en Firebase

Para que el botón de "X (Twitter)" funcione, necesitas realizar una configuración **obligatoria** en el panel de Firebase.

### Paso 1: Habilitar Proveedor en Firebase
1. Ve a la consola de Firebase: [https://console.firebase.google.com/](https://console.firebase.google.com/)
2. Entra a tu proyecto **Clari3**.
3. En el menú izquierdo, ve a **Autenticación (Authentication)** -> Pestaña **Sign-in method**.
4. Busca "Twitter" y dale clic.
5. Verás que te pide **API Key** y **API Secret**. No cierres esta ventana.
6. Copia la "URL de devolución de llamada" (Callback URL) que te muestra Firebase (algo como `https://clari3-5efc6.firebaseapp.com/__/auth/handler`).

### Paso 2: Crear App en Twitter Developer Portal
1. Ve a [Twitter Developer Portal](https://developer.twitter.com/en/portal/dashboard) e inicia sesión.
2. Crea un nuevo proyecto y una App.
3. En la configuración de la App (Settings), ve a **User Authentication Settings** y dale a "Set up".
4. **App permissions**: Selecciona "Read" o "Read and Write".
5. **Type of App**: Selecciona "Web App, Automated App or Bot".
6. **App Info**:
   - **Callback URI / Redirect URL**: Pega la URL que copiaste de Firebase.
   - **Website URL**: Puedes poner `https://clari3-5efc6.firebaseapp.com` o la de tu localhost si tuvieras.
7. Guarda los cambios.
8. Obtendrás un **Client ID** y **Client Secret** (o API Key y Secret Key).

### Paso 3: Finalizar en Firebase
1. Vuelve a la pestaña de Firebase.
2. Pega las llaves (API Key y API Secret) que obtuviste de Twitter.
3. Haz clic en **Guardar**.

¡Listo! Ahora el botón funcionará.
