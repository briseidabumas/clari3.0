# REVISIÓN FINAL: API KEY vs CLIENT ID

Es muy probable que estés usando las llaves incorrectas. Twitter muestra **dos tipos** de llaves y es fácil confundirse.

### ¡NO USES "OAuth 2.0 Client ID"!
Si estás copiando las llaves de la sección que dice "OAuth 2.0 Client ID and Client Secret", **NO FUNCIONARÁ**. Firebase no usa esas para este método.

### USA "Consumer Keys (API Key and Secret)"
1. Ve a "Keys and Tokens" en tu Twitter Developer Portal.
2. Busca la sección de arriba del todo: **Consumer Keys**.
3. Esas son las que dicen **API Key** y **API Key Secret**.
   - Solo esas funcionan con Firebase.
   - Si usas las de "Client ID", te dará error de credenciales inválidas.

### Lista de Verificación Definitiva:
1. **Llaves Correctas**: Asegúrate de estar copiando las **Consumer Keys** (API Key / API Secret), no las Client ID.
2. **Sin Espacios**: Al copiar y pegar en Firebase, asegúrate de que no haya espacios en blanco al inicio ni al final.
3. **URL Exacta**: `https://clari3-5efc6.firebaseapp.com/__/auth/handler` en Twitter.
4. **Permisos**: En "User authentication settings", asegúrate de que "Type of App" sea **Web App**, y que esté activado "Request email address from users" si es posible (aunque para login básico 'Read' basta).

Si sigue fallando después de corregir esto, dale al botón **Regenerate** en la sección **Consumer Keys**, y pega las nuevas llaves en Firebase.
