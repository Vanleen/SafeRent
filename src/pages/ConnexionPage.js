// src/pages/ConnexionPage.js
import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import FacebookIcon from '../assets/Facebook.svg';
import GoogleIcon from '../assets/Google.svg';
import { signInWithGoogle, signInWithFacebook } from '../FirebaseConfig';
import LeftSection from '../components/LeftSection'; // Importer LeftSection
import RightSection from '../components/RightSection'; // Importer RightSection
import './ConnexionPage.css';

const ConnexionPage = () => {
  const navigate = useNavigate();

  const handleGoogleSignIn = async () => {
    try {
      const result = await signInWithGoogle();
      console.log('User signed in: ', result.user);
      localStorage.setItem('authToken', result.user.accessToken); // Sauvegarder le token d'authentification
      navigate('/home'); // Rediriger vers la page d'accueil
    } catch (error) {
      console.error('Error signing in with Google: ', error);
    }
  };

  const handleFacebookSignIn = async () => {
    try {
      const result = await signInWithFacebook();
      console.log('User signed in: ', result.user);
      localStorage.setItem('authToken', result.user.accessToken); // Sauvegarder le token d'authentification
      navigate('/home'); // Rediriger vers la page d'accueil
    } catch (error) {
      console.error('Error signing in with Facebook: ', error);
    }
  };

  return (
    <div className="login-container">
      <LeftSection />
      <RightSection />
    </div>
  );
}

export default ConnexionPage;
