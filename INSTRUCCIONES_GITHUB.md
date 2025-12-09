# Configuración de Autenticación con GitHub en Firebase

Sigue estos pasos para habilitar el inicio de sesión con GitHub en tu proyecto Firebase.

## Paso 1: Configurar GitHub

1. Ve a tu cuenta de GitHub y haz clic en tu foto de perfil > **Settings**.
2. En la barra lateral izquierda, desplázate hacia abajo y haz clic en **Developer settings**.
3. Haz clic en **OAuth Apps** y luego en el botón **New OAuth App**.
4. Rellena el formulario con la siguiente información:
    *   **Application Name**: El nombre de tu app (ej. `Clari3 Social`).
    *   **Homepage URL**: La URL de tu aplicación (si estás en local, usa `http://localhost` o la URL de tu hosting).
    *   **Authorization callback URL**: *Deja esto pendiente por un momento, lo obtendremos de Firebase.*

## Paso 2: Configurar Firebase

1. Ve a la [Consola de Firebase](https://console.firebase.google.com/).
2. Selecciona tu proyecto (`clari3`).
3. En el menú izquierdo, ve a **Authentication** > **Sign-in method**.
4. Haz clic en **Add new provider** y selecciona **GitHub**.
5. Verás un interruptor para **Habilitar** (Enable). Actívalo.
6. Copia la URL que aparece abajo donde dice **Authorization callback URL** (ej. `https://clari3-5efc6.firebaseapp.com/__/auth/handler`).

## Paso 3: Finalizar Configuración en GitHub

1. Vuelve a la pestaña de GitHub donde estabas creando la OAuth App.
2. Pega la URL que copiaste de Firebase en el campo **Authorization callback URL**.
3. Haz clic en **Register application**.
4. Una vez creada, verás el **Client ID**. Copialo.
5. Haz clic en **Generate a new client secret**. Copia el **Client Secret**.

## Paso 4: Finalizar Configuración en Firebase

1. Vuelve a la pestaña de Firebase.
2. Pega el **Client ID** y el **Client Secret** que obtuviste de GitHub en los campos correspondientes.
3. Haz clic en **Save**.

¡Listo! Ahora el botón de GitHub en tu login funcionará correctamente.

---
**Nota**: Si estás probando en `localhost`, asegúrate de que tu dominio local esté autorizado en Firebase Authentication > Settings > Authorized domains.
