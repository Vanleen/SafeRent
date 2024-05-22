// src/components/LeftSection.js
import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import FacebookIcon from '../assets/Facebook.svg';
import GoogleIcon from '../assets/Google.svg';
import { signInWithGoogle, signInWithFacebook } from '../FirebaseConfig';
import './LeftSection.css';

const LeftSection = () => {
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
    <div className="left-section">
      <h1>Welcome</h1>
      <p>Sign in to keep safeguarding your renting process.</p>
      <form className="login-form">
        <label htmlFor="email">Email</label>
        <input type="email" id="email" placeholder="Example@email.com" required />
        <label htmlFor="password">Password</label>
        <input type="password" id="password" placeholder="********" required />
        <Link to="/forgot-password" className="forgot-password">Forgot Password?</Link>
        <button type="submit" className="sign-in-button">Sign in</button>
      </form>
      <div className="or-divider">
        <span>Or</span>
      </div>
      <button type="button" className="social-login google" onClick={handleGoogleSignIn}>
        <img src={GoogleIcon} alt="Google" />
        Sign in with Google
      </button>
      <button type="button" className="social-login facebook" onClick={handleFacebookSignIn}>
        <img src={FacebookIcon} alt="Facebook" />
        Sign in with Facebook
      </button>
      <p className="sign-up-text">Don't you have an account? <Link to="/signup">Sign up</Link></p>
    </div>
  );
};

export default LeftSection;
