// 1. Importaciones de Firebase
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-analytics.js";
import {
    getAuth,
    GoogleAuthProvider,
    FacebookAuthProvider,
    signInWithPopup,
    onAuthStateChanged,
    signOut,
    signInWithEmailAndPassword,
    createUserWithEmailAndPassword
} from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

// 2. Configuración de Firebase (Clari3)
const firebaseConfig = {
    apiKey: "AIzaSyCTRDKBJ7_8BP7RGd6FXFz9BfDhP9c8gbo",
    authDomain: "clari3-5efc6.firebaseapp.com",
    projectId: "clari3-5efc6",
    storageBucket: "clari3-5efc6.firebasestorage.app",
    messagingSenderId: "1085275362412",
    appId: "1:1085275362412:web:635b48d55c59ec883d3449",
    measurementId: "G-9K68E4X0Z0"
};

// 3. Inicialización
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const auth = getAuth(app);
const googleProvider = new GoogleAuthProvider();
const facebookProvider = new FacebookAuthProvider();

// 4. Referencias DOM
const authForm = document.getElementById('authForm');
const emailInput = document.getElementById('emailInput');
const passwordInput = document.getElementById('passwordInput');
const submitBtn = document.getElementById('submitBtn');
const googleBtn = document.getElementById('googleBtn');
const facebookBtn = document.getElementById('facebookBtn');
const toggleAuthModeBtn = document.getElementById('toggleAuthMode');
const toggleText = document.getElementById('toggleText');
const formTitle = document.getElementById('formTitle');
const errorMessage = document.getElementById('errorMessage');

// Variables de estado
let isLoginMode = true; // Empieza en modo Login

// 5. Manejar cambio entre Login y Registro
toggleAuthModeBtn.addEventListener('click', (e) => {
    e.preventDefault();
    isLoginMode = !isLoginMode; // Alternar modo

    if (isLoginMode) {
        formTitle.textContent = "USER LOGIN";
        submitBtn.textContent = "LOGIN";
        toggleText.textContent = "¿No tienes cuenta?";
        toggleAuthModeBtn.textContent = "Sign Up";
        errorMessage.style.display = 'none';
        document.querySelector('.options-row').style.display = 'flex'; // Mostrar Remember/Forgot
    } else {
        formTitle.textContent = "SIGN UP";
        submitBtn.textContent = "REGISTER";
        toggleText.textContent = "¿Ya tienes cuenta?";
        toggleAuthModeBtn.textContent = "Login";
        errorMessage.style.display = 'none';
        document.querySelector('.options-row').style.display = 'none'; // Ocultar Remember/Forgot
    }
});

// 6. Manejar Login/Registro con Correo
authForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = emailInput.value;
    const password = passwordInput.value;

    // UI Loading
    errorMessage.style.display = 'none';
    const originalBtnText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = "Procesando...";

    try {
        if (isLoginMode) {
            // LOGIN
            const userCredential = await signInWithEmailAndPassword(auth, email, password);
            console.log("Login exitoso:", userCredential.user);
            // Redirección manejada en onAuthStateChanged
        } else {
            // REGISTRO
            const userCredential = await createUserWithEmailAndPassword(auth, email, password);
            console.log("Registro exitoso:", userCredential.user);
            alert("¡Cuenta creada con éxito! Iniciando sesión...");
        }
    } catch (error) {
        console.error("Error:", error);
        showError(error);
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
    }
});

// 7. Manejar Login con Google
googleBtn.addEventListener('click', () => {
    errorMessage.style.display = 'none';
    googleBtn.disabled = true;

    signInWithPopup(auth, googleProvider)
        .then((result) => {
            console.log("Google Login exitoso:", result.user);
        })
        .catch((error) => {
            console.error("Error Google:", error);
            showError(error);
            googleBtn.disabled = false;
        });
});

// 8. Manejar Login con Facebook
facebookBtn.addEventListener('click', () => {
    errorMessage.style.display = 'none';
    facebookBtn.disabled = true;

    signInWithPopup(auth, facebookProvider)
        .then((result) => {
            console.log("Facebook Login exitoso:", result.user);
        })
        .catch((error) => {
            console.error("Error Facebook:", error);
            if (error.code === 'auth/account-exists-with-different-credential') {
                showError({ code: 'custom', message: 'Ya existe una cuenta con este correo pero usa otro método (Google o Contraseña). Inicia sesión con ese método primero.' });
            } else {
                showError(error);
            }
            facebookBtn.disabled = false;
        });
});

// 9. Observador de Estado (Redirección centralizada)
onAuthStateChanged(auth, async (user) => {
    if (user) {
        // Sincronizar con Base de Datos MySQL
        try {
            const syncResponse = await fetch('php/sync_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    firebase_uid: user.uid,
                    email: user.email,
                    displayName: user.displayName,
                    photoURL: user.photoURL
                })
            });
            const syncData = await syncResponse.json();

            if (syncData.success) {
                console.log("Usuario sincronizado con MySQL:", syncData.user);
                // Guardar datos combinados
                localStorage.setItem('firebaseUser', JSON.stringify({
                    uid: user.uid,
                    displayName: syncData.user.nombre_completo,
                    email: user.email,
                    photoURL: syncData.user.foto_perfil_url || user.photoURL,
                    dbId: syncData.user.id_usuario // ID de MySQL
                }));
            }
        } catch (e) {
            console.error("Error sincronizando usuario:", e);
        }

        // Redirigir
        setTimeout(() => {
            window.location.href = 'home.html';
        }, 1000);
    }
});

// Helper para mostrar errores amigables
function showError(error) {
    errorMessage.style.display = 'block';
    let msg = "Ocurrió un error. Intenta de nuevo.";

    if (error.code === 'auth/wrong-password') msg = "Contraseña incorrecta.";
    if (error.code === 'auth/user-not-found') msg = "Usuario no encontrado. ¿Quieres registrarte?";
    if (error.code === 'auth/email-already-in-use') msg = "Este correo ya está registrado.";
    if (error.code === 'auth/invalid-email') msg = "Correo electrónico inválido.";
    if (error.code === 'auth/weak-password') msg = "La contraseña debe tener al menos 6 caracteres.";
    if (error.code === 'auth/popup-closed-by-user') msg = "Ventana cerrada antes de terminar.";
    if (error.code === 'custom') msg = error.message;

    errorMessage.textContent = msg;
}
