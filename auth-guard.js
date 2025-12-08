// auth-guard.js - Protege páginas que requieren autenticación
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

// Configuración de Firebase (debe ser la misma que en app.js)
const firebaseConfig = {
    apiKey: "AIzaSyCTRDKBJ7_8BP7RGd6FXFz9BfDhP9c8gbo",
    authDomain: "clari3-5efc6.firebaseapp.com",
    projectId: "clari3-5efc6",
    storageBucket: "clari3-5efc6.firebasestorage.app",
    messagingSenderId: "1085275362412",
    appId: "1:1085275362412:web:635b48d55c59ec883d3449",
    measurementId: "G-9K68E4X0Z0"
};

// Inicializar Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Variable para almacenar el usuario actual
let currentUser = null;

// Verificar autenticación
onAuthStateChanged(auth, (user) => {
    if (user) {
        // Usuario autenticado
        currentUser = user;
        console.log("Usuario autenticado:", user.displayName || user.email);

        // Actualizar información del usuario en localStorage
        localStorage.setItem('firebaseUser', JSON.stringify({
            uid: user.uid,
            displayName: user.displayName,
            email: user.email,
            photoURL: user.photoURL,
            phoneNumber: user.phoneNumber
        }));

        // Disparar evento personalizado para que la página sepa que el usuario está autenticado
        window.dispatchEvent(new CustomEvent('userAuthenticated', { detail: user }));

    } else {
        // Usuario no autenticado - redirigir al login
        console.log("Usuario no autenticado. Redirigiendo al login...");
        localStorage.removeItem('firebaseUser');
        window.location.href = 'index.html';
    }
});

// Función para cerrar sesión (exportada para usar en otras páginas)
export function logout() {
    auth.signOut().then(() => {
        console.log("Sesión cerrada exitosamente");
        localStorage.removeItem('firebaseUser');
        window.location.href = 'index.html';
    }).catch((error) => {
        console.error("Error al cerrar sesión:", error);
    });
}

// Función para obtener el usuario actual
export function getCurrentUser() {
    return currentUser;
}

// Función para obtener el token de autenticación
export async function getAuthToken() {
    if (currentUser) {
        try {
            const token = await currentUser.getIdToken();
            return token;
        } catch (error) {
            console.error("Error al obtener el token:", error);
            return null;
        }
    }
    return null;
}

// Exportar la instancia de auth para usar en otras partes de la aplicación
export { auth };
