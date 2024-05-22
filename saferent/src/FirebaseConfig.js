// src/FirebaseConfig.js
import { initializeApp } from "firebase/app";
import {
  getAuth,
  GoogleAuthProvider,
  FacebookAuthProvider,
  signInWithPopup,
} from "firebase/auth";
import { getFirestore } from "firebase/firestore";

// Votre configuration Firebase
const firebaseConfig = {
  apiKey: "AIzaSyBhEXBzCiLN9zAPT9rDRKNo5zrH55jM9iI",
  authDomain: "saferent-14c8c.firebaseapp.com",
  projectId: "saferent-14c8c",
  storageBucket: "saferent-14c8c.appspot.com",
  messagingSenderId: "273882656190",
  appId: "1:273882656190:web:371b4b4bd46827d7139def",
};

// Initialiser Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);
const googleProvider = new GoogleAuthProvider();
const facebookProvider = new FacebookAuthProvider();

// Fonction pour la connexion avec Google
const signInWithGoogle = () => {
  return signInWithPopup(auth, googleProvider);
};

// Fonction pour la connexion avec Facebook
const signInWithFacebook = () => {
  return signInWithPopup(auth, facebookProvider);
};

export { auth, db, signInWithGoogle, signInWithFacebook };
